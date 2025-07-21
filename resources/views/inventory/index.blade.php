@extends('layouts.app')

@section('title','Inventory')

@section('content')
<div class="ml-64 p-8 min-h-screen bg-gray-900">
  <div class="max-w-7xl mx-auto">

    <!-- Header & Filter Section -->
    <div class="flex flex-col gap-6 mb-8">
      <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
          <h1 class="text-3xl font-bold text-white">Inventory Management</h1>
          <p class="text-gray-400 mt-1">Efficiently track and manage your inventory assets</p>
        </div>

        <a href="{{ route('inventory.create') }}"
           class="flex items-center gap-2 w-fit px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-blue-500/30 border border-blue-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
          </svg>
          <span>Add New Item</span>
        </a>
      </div>

      <!-- Filter Card -->
      <div class="bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-700">
        <form class="flex flex-col sm:flex-row gap-3 items-end" method="GET" action="">
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Owner</label>
              <select name="owner_id" class="w-full rounded-lg bg-gray-700 text-white border border-gray-600 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Owners</option>
                @foreach($owners as $o)
                  <option value="{{ $o->id }}" {{ request('owner_id') == $o->id ? 'selected' : '' }}>
                    {{ $o->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Warehouse</label>
              <select name="warehouse_id" class="w-full rounded-lg bg-gray-700 text-white border border-gray-600 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Warehouses</option>
                @foreach($warehouses as $w)
                  <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>
                    {{ $w->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Status</label>
              <select name="status" class="w-full rounded-lg bg-gray-700 text-white border border-gray-600 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Status</option>
                @foreach(['Available', 'Reserved', 'Out of Stock'] as $status)
                  <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="flex gap-2">
            <button type="submit"
              class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition shadow-md hover:shadow-blue-500/30">
              Apply Filters
            </button>
            @if(request('owner_id') || request('warehouse_id') || request('status'))
            <a href="{{ route('inventory.index') }}"
               class="px-4 py-2 text-gray-300 hover:text-white rounded-lg border border-gray-600 hover:border-gray-500 transition">
              Reset
            </a>
            @endif
          </div>
        </form>
      </div>
    </div>

    <!-- Inventory Table Section -->
    <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden shadow-lg">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
          <thead class="bg-gray-700">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">#</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Item</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Model/Type</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Serial</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Stock</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Min</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Location</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Dates</th>
              <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-gray-800 divide-y divide-gray-700">
            @foreach($inv as $i)
            <tr class="hover:bg-gray-700/50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                {{ $loop->iteration + ($inv->currentPage()-1)*$inv->perPage() }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-white">{{ $i->inventory_name }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                {{ $i->modelType->name ?? '-' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-300">
                {{ $i->serial_number }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium
                @if($i->stock_quantity < ($i->modelType->minimum_stock ?? 0)) text-red-400 @else text-blue-400 @endif">
                {{ $i->stock_quantity }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                {{ $i->modelType->minimum_stock ?? '-' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2.5 py-1 text-xs rounded-full font-medium
                  @if($i->status === 'Available') bg-green-900/30 text-green-400
                  @elseif($i->status === 'Reserved') bg-amber-900/30 text-amber-400
                  @else bg-red-900/30 text-red-400 @endif">
                  {{ $i->status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-300">{{ $i->owner->name ?? '-' }}</div>
                <div class="text-xs text-gray-500">{{ $i->warehouse->name ?? '-' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-300">In: {{ $i->inventory_in_date }}</div>
                <div class="text-xs text-gray-500">Out: {{ $i->inventory_out_date ?? '-' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex justify-end space-x-2">
                  <a href="{{ route('inventory.edit', $i) }}"
                     class="inline-flex items-center px-3 py-1 border border-blue-600 rounded-md text-blue-400 hover:bg-blue-900/30 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8-8.379-2.83-2.828z" />
                    </svg>
                    Edit
                  </a>
                  <form action="{{ route('inventory.destroy', $i) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-3 py-1 border border-red-600 rounded-md text-red-400 hover:bg-red-900/30 hover:text-white transition-colors"
                            onclick="return confirm('Are you sure you want to delete this item?')">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                      </svg>
                      Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
      <div class="text-sm text-gray-400">
        Showing {{ $inv->firstItem() }} to {{ $inv->lastItem() }} of {{ $inv->total() }} items
      </div>
      <div class="bg-gray-800 rounded-lg border border-gray-700">
        {{ $inv->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
