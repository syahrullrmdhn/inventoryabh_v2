@extends('layouts.app')
@section('title', 'Edit Inventory')
@section('content')
<div class="max-w-xl mx-auto">
  <div class="bg-gray-800/50 backdrop-blur-lg rounded-2xl border border-gray-700 shadow-lg p-8 mt-10">
    <h2 class="text-2xl font-bold mb-6 text-white">Edit Inventory</h2>
    <form action="{{ route('inventory.update', $inventory) }}" method="POST" class="space-y-5">
      @csrf
      @method('PUT')

      <div>
        <label class="block mb-1 text-gray-300">Inventory Name</label>
        <input name="inventory_name" value="{{ old('inventory_name', $inventory->inventory_name) }}"
               class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500"
               required />
        @error('inventory_name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-300">Model/Type</label>
        <select name="model_type_id" required
          class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500">
          <option value="">- Select Model/Type -</option>
          @foreach($modelTypes as $mt)
            <option value="{{ $mt->id }}" {{ old('model_type_id', $inventory->model_type_id) == $mt->id ? 'selected' : '' }}>
              {{ $mt->name }} (Min: {{ $mt->minimum_stock }})
            </option>
          @endforeach
        </select>
        @error('model_type_id')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-300">Serial Number</label>
        <input name="serial_number" value="{{ old('serial_number', $inventory->serial_number) }}"
               class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500" />
        @error('serial_number')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
      </div>

      <div class="flex gap-4">
        <div class="flex-1">
          <label class="block mb-1 text-gray-300">Stock Quantity</label>
          <input name="stock_quantity" type="number" min="0" value="{{ old('stock_quantity', $inventory->stock_quantity) }}"
                 class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500" required />
          @error('stock_quantity')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>
        <div class="flex-1 pt-7">
          <span class="block text-xs text-gray-500">* Minimum stock mengikuti master model/type</span>
        </div>
      </div>

      <div>
        <label class="block mb-1 text-gray-300">Status</label>
        <select name="status" required
          class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500">
          <option value="Available" {{ old('status', $inventory->status) == 'Available' ? 'selected' : '' }}>Available</option>
          <option value="Reserved" {{ old('status', $inventory->status) == 'Reserved' ? 'selected' : '' }}>Reserved</option>
          <option value="Out of Stock" {{ old('status', $inventory->status) == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
        </select>
        @error('status')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-300">Owner</label>
        <select name="owner_id" required
          class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500">
          <option value="">- Select Owner -</option>
          @foreach($owners as $o)
            <option value="{{ $o->id }}" {{ old('owner_id', $inventory->owner_id) == $o->id ? 'selected' : '' }}>
              {{ $o->name }}{{ $o->contact ? " ($o->contact)" : "" }}
            </option>
          @endforeach
        </select>
        @error('owner_id')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-300">Warehouse</label>
        <select name="warehouse_id" required
          class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500">
          <option value="">- Select Warehouse -</option>
          @foreach($warehouses as $w)
            <option value="{{ $w->id }}" {{ old('warehouse_id', $inventory->warehouse_id) == $w->id ? 'selected' : '' }}>
              {{ $w->name }}{{ $w->location ? " ($w->location)" : "" }}
            </option>
          @endforeach
        </select>
        @error('warehouse_id')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
      </div>

      <div class="flex gap-4">
        <div class="flex-1">
          <label class="block mb-1 text-gray-300">Inventory In Date</label>
          <input name="inventory_in_date" type="date" value="{{ old('inventory_in_date', $inventory->inventory_in_date) }}"
                 class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500" />
          @error('inventory_in_date')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>
        <div class="flex-1">
          <label class="block mb-1 text-gray-300">Inventory Out Date</label>
          <input name="inventory_out_date" type="date" value="{{ old('inventory_out_date', $inventory->inventory_out_date) }}"
                 class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500" />
          @error('inventory_out_date')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="pt-4 flex gap-3">
        <button type="submit"
          class="py-2 px-6 bg-blue-600 rounded-lg text-white font-semibold hover:bg-blue-700 transition">
          Update
        </button>
        <a href="{{ route('inventory.index') }}"
           class="py-2 px-6 rounded-lg bg-gray-700 text-gray-300 hover:bg-gray-600 transition">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
