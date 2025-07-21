<?php
namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::orderBy('name')->paginate(10);
        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:255'
        ]);
        $wh = Warehouse::create($data);
        log_activity('Menambahkan warehouse', $data);
        return redirect()->route('warehouses.index')->with('success', 'Warehouse added!');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:255'
        ]);
        $warehouse->update($data);
        log_activity('Mengupdate warehouse', $data);
        return redirect()->route('warehouses.index')->with('success', 'Warehouse updated!');
    }

    public function destroy(Warehouse $warehouse)
    {
        log_activity('Menghapus warehouse', ['id' => $warehouse->id, 'name' => $warehouse->name]);
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('success', 'Warehouse deleted!');
    }
}
