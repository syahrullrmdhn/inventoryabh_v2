<?php
// app/Http/Controllers/ModelTypeController.php

namespace App\Http\Controllers;

use App\Models\ModelType;
use Illuminate\Http\Request;

class ModelTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = ModelType::query()
            ->search(
                $request->input('q'),
                $request->input('min_stock'),
                $request->input('max_stock')
            )
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('model_types.index', compact('types'));
    }

    public function create()
    {
        return view('model_types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'minimum_stock' => 'required|integer|min:0',
        ]);

        ModelType::create($data);
        log_activity('Menambahkan model/type', $data);

        return redirect()
            ->route('model-types.index')
            ->with('success', 'Added!');
    }

    public function edit(ModelType $modelType)
    {
        return view('model_types.edit', compact('modelType'));
    }

    public function update(Request $request, ModelType $modelType)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'minimum_stock' => 'required|integer|min:0',
        ]);

        $modelType->update($data);
        log_activity('Mengupdate model/type', $data);

        return redirect()
            ->route('model-types.index')
            ->with('success', 'Updated!');
    }

    public function destroy(ModelType $modelType)
    {
        log_activity('Menghapus model/type', [
            'id'   => $modelType->id,
            'name' => $modelType->name,
        ]);

        $modelType->delete();

        return redirect()
            ->route('model-types.index')
            ->with('success', 'Deleted!');
    }
}
