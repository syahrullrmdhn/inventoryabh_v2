<?php
namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::orderBy('name')->paginate(10);
        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'contact' => 'nullable|string|max:255'
        ]);
        $owner = Owner::create($data);
        log_activity('Menambahkan owner', $data);
        return redirect()->route('owners.index')->with('success', 'Owner added!');
    }

    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'contact' => 'nullable|string|max:255'
        ]);
        $owner->update($data);
        log_activity('Mengupdate owner', $data);
        return redirect()->route('owners.index')->with('success', 'Owner updated!');
    }

    public function destroy(Owner $owner)
    {
        log_activity('Menghapus owner', ['id' => $owner->id, 'name' => $owner->name]);
        $owner->delete();
        return redirect()->route('owners.index')->with('success', 'Owner deleted!');
    }
}
