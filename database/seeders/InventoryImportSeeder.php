<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\ModelType;
use App\Models\Owner;
use App\Models\Warehouse;
use App\Models\Inventory;
use OpenSpout\Reader\XLSX\Reader; // pakai Spout v4.x

class InventoryImportSeeder extends Seeder
{
    public function run()
    {
        $path = storage_path('app/inventory.xlsx');
        if (!file_exists($path)) {
            echo "File inventory.xlsx tidak ditemukan di storage/app\n";
            return;
        }

        $reader = new Reader();
        $reader->open($path);

        $header = [];
        $rowNum = 0;

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $rowNum++;
                $cells = $row->toArray();

                // Baris header
                if ($rowNum == 1) {
                    $header = array_map(function($h) {
                        return strtolower(trim($h));
                    }, $cells);
                    continue;
                }
                if (count($cells) < count($header)) continue;

                $rowData = array_combine($header, $cells);

                // --- ModelType ---
                $modelTypeName = trim(($rowData['brand'] ?? '') . ' ' . ($rowData['type'] ?? ''));
                if (!$modelTypeName) continue;
                $modelType = ModelType::firstOrCreate(
                    ['name' => $modelTypeName],
                    ['minimum_stock' => 1]
                );

                // --- Owner ---
                $ownerName = '-';
                if (isset($rowData['notes / owner'])) {
                    $note = strtoupper($rowData['notes / owner']);
                    if (str_contains($note, 'ABHINAWA')) $ownerName = 'ABHINAWA';
                    elseif (str_contains($note, 'OWS')) $ownerName = 'OWS';
                    elseif (str_contains($note, 'DCC')) $ownerName = 'DCC';
                    elseif (str_contains($note, 'ISPL')) $ownerName = 'ISPL';
                }
                $owner = Owner::firstOrCreate(['name' => $ownerName]);

                // --- Warehouse ---
                $warehouseName = '-';
                if (isset($rowData['notes / owner'])) {
                    if (str_contains(strtolower($rowData['notes / owner']), 'pejaten')) $warehouseName = 'Pejaten Office';
                }
                $warehouse = Warehouse::firstOrCreate(['name' => $warehouseName]);

                // --- Inventory ---
                $serial = $rowData['serial number'] ?? $rowData['serial'] ?? null;
                $status = $this->mapStatus($rowData['status'] ?? 'Available'); // Pakai mapping

                $inDate  = $this->parseDate($rowData['date received'] ?? null);
                $outDate = $this->parseDate($rowData['date use'] ?? null);
                $createdAt = $this->parseDate($rowData['created at'] ?? null, true) ?? now();

                $inv = [
                    'inventory_name'     => $modelTypeName,
                    'model_type_id'      => $modelType->id,
                    'owner_id'           => $owner->id,
                    'warehouse_id'       => $warehouse->id,
                    'serial_number'      => $serial,
                    'stock_quantity'     => 1,
                    'status'             => $status,
                    'inventory_in_date'  => $inDate,
                    'inventory_out_date' => $outDate,
                    'created_at'         => $createdAt,
                    'updated_at'         => now(),
                ];

                // Cek duplikat serial
                if (!$serial || !Inventory::where('serial_number', $serial)->exists()) {
                    Inventory::create($inv);
                }
            }
            break; // hanya sheet pertama
        }
        $reader->close();
        echo "Import selesai!\n";
    }

    // --- Mapping status Excel ke allowed ENUM ---
    private function mapStatus($status)
    {
        $allowed = ['Available', 'Reserved', 'Out of Stock'];
        $status = trim(strtolower($status));
        if (in_array(ucfirst($status), $allowed)) {
            return ucfirst($status);
        }
        // Map string lain (In use, Used, Inuse, Used Out, dst)
        if (str_contains($status, 'use')) {
            return 'Reserved';
        }
        if (str_contains($status, 'out')) {
            return 'Out of Stock';
        }
        return 'Available';
    }

    private function parseDate($value, $withTime = false)
    {
        if (!$value) return null;
        try {
            // Spout Excel date: numeric, else string
            if (is_numeric($value) && $value > 10000) {
                $unixDate = ($value - 25569) * 86400;
                $dt = Carbon::createFromTimestamp($unixDate);
            } else {
                $dt = Carbon::parse($value);
            }
            return $withTime ? $dt->format('Y-m-d H:i:s') : $dt->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
