<?php
namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $modelTypes = \App\Models\ModelType::orderBy('name')->get();
        $owners = \App\Models\Owner::orderBy('name')->get();
        $warehouses = \App\Models\Warehouse::orderBy('name')->get();

        $query = Inventory::with(['modelType','owner','warehouse']);

        // Filter
        if ($request->owner_id) $query->where('owner_id', $request->owner_id);
        if ($request->warehouse_id) $query->where('warehouse_id', $request->warehouse_id);
        if ($request->status) $query->where('status', $request->status);

        $inv = $query->orderBy('inventory_name')->paginate(10);

        return view('inventory.index', compact('inv','modelTypes','owners','warehouses'));
    }

    public function create()
    {
        $modelTypes = \App\Models\ModelType::orderBy('name')->get();
        $owners = \App\Models\Owner::orderBy('name')->get();
        $warehouses = \App\Models\Warehouse::orderBy('name')->get();
        return view('inventory.create', compact('modelTypes', 'owners', 'warehouses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inventory_name'     => 'required|string|max:255',
            'model_type_id'      => 'required|exists:model_types,id',
            'owner_id'           => 'required|exists:owners,id',
            'warehouse_id'       => 'required|exists:warehouses,id',
            'serial_number'      => 'nullable|string|max:255',
            'stock_quantity'     => 'required|integer|min:0',
            'status'             => 'required|in:Available,Reserved,Out of Stock,In use',
            'inventory_in_date'  => 'nullable|date',
            'inventory_out_date' => 'nullable|date',
        ]);
        $inventory = Inventory::create($data);
        log_activity('Menambahkan inventory', ['id' => $inventory->id, 'name' => $inventory->inventory_name]);
        return redirect()->route('inventory.index')->with('success', 'Item added!');
    }

    public function edit(Inventory $inventory)
    {
        $modelTypes = \App\Models\ModelType::orderBy('name')->get();
        $owners = \App\Models\Owner::orderBy('name')->get();
        $warehouses = \App\Models\Warehouse::orderBy('name')->get();
        return view('inventory.edit', compact('inventory', 'modelTypes', 'owners', 'warehouses'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'inventory_name'     => 'required|string|max:255',
            'model_type_id'      => 'required|exists:model_types,id',
            'owner_id'           => 'required|exists:owners,id',
            'warehouse_id'       => 'required|exists:warehouses,id',
            'serial_number'      => 'nullable|string|max:255',
            'stock_quantity'     => 'required|integer|min:0',
            'status'             => 'required|in:Available,Reserved,Out of Stock,In use',
            'inventory_in_date'  => 'nullable|date',
            'inventory_out_date' => 'nullable|date',
        ]);
        $inventory->update($data);
        log_activity('Mengupdate inventory', ['id' => $inventory->id, 'name' => $inventory->inventory_name]);
        return redirect()->route('inventory.index')->with('success', 'Item updated!');
    }

    public function destroy(Inventory $inventory)
    {
        log_activity('Menghapus inventory', ['id' => $inventory->id, 'name' => $inventory->inventory_name]);
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Item deleted!');
    }
}
