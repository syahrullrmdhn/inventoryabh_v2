{{-- resources/views/model_types/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Model/Type Master')

@section('content')
<div class="ml-64 p-8 min-h-screen bg-gray-900">
  <div class="max-w-4xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
      <div>
        <h2 class="text-2xl font-bold text-white">Model/Type Master</h2>
        <p class="text-gray-400 mt-1">Manage all your inventory models and types</p>
      </div>
      <a href="{{ route('model-types.create') }}"
         class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-md hover:shadow-blue-500/30">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
        </svg>
        Add Model/Type
      </a>
    </div>

    <!-- Search & Filter -->
    <div class="bg-gray-800/60 rounded-xl border border-gray-700 p-4 mb-6">
      <form method="GET" action="" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
        <div class="sm:col-span-2">
          <label class="block text-sm font-medium text-gray-300 mb-1">Search</label>
          <div class="relative">
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Cari nama model/type…"
                   class="w-full rounded-lg bg-gray-700 text-white border border-gray-600 px-3 py-2 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @if(request('q'))
              <a href="{{ route('model-types.index', collect(request()->except('q','page'))->toArray()) }}"
                 class="absolute inset-y-0 right-2 flex items-center text-gray-400 hover:text-gray-200" title="Clear">
                 ✕
              </a>
            @endif
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-300 mb-1">Min Stock ≥</label>
          <input type="number" name="min_stock" value="{{ request('min_stock') }}"
                 class="w-full rounded-lg bg-gray-700 text-white border border-gray-600 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-1">Max Stock ≤</label>
          <input type="number" name="max_stock" value="{{ request('max_stock') }}"
                 class="w-full rounded-lg bg-gray-700 text-white border border-gray-600 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="sm:col-span-4 flex gap-2">
          <button type="submit"
                  class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition shadow-md hover:shadow-blue-500/30">
            Apply
          </button>
          @if(request('q') || request('min_stock') || request('max_stock'))
            <a href="{{ route('model-types.index') }}"
               class="px-4 py-2 text-gray-300 hover:text-white rounded-lg border border-gray-600 hover:border-gray-500 transition">
              Reset
            </a>
          @endif
        </div>
      </form>

      @if(request('q') || request('min_stock') || request('max_stock'))
        <div class="mt-2 text-sm text-gray-400">
          @if(request('q'))
            Keyword: <span class="text-gray-200 font-medium">"{{ request('q') }}"</span>
          @endif
          @if(request('min_stock'))
            <span class="ml-2">Min: <span class="text-gray-200 font-medium">{{ request('min_stock') }}</span></span>
          @endif
          @if(request('max_stock'))
            <span class="ml-2">Max: <span class="text-gray-200 font-medium">{{ request('max_stock') }}</span></span>
          @endif
        </div>
      @endif
    </div>

    <!-- Table Card -->
    <div class="bg-gray-800/50 rounded-xl border border-gray-700 shadow-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
          <thead class="bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Minimum Stock</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-gray-800 divide-y divide-gray-700">
            @forelse($types as $type)
              <tr class="hover:bg-gray-700/40 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-white">{{ $type->name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-blue-400">{{ $type->minimum_stock }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex justify-end space-x-2">
                    <a href="{{ route('model-types.edit', $type) }}"
                       class="inline-flex items-center px-3 py-1 border border-blue-600 rounded-md text-blue-400 hover:bg-blue-900/30 hover:text-white transition-colors">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8-8.379-2.83-2.828z"/>
                      </svg>
                      Edit
                    </a>
                    <form action="{{ route('model-types.destroy', $type) }}" method="POST" class="inline">
                      @csrf @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center px-3 py-1 border border-red-600 rounded-md text-red-400 hover:bg-red-900/30 hover:text-white transition-colors"
                              onclick="return confirm('Are you sure you want to delete this model/type?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Delete
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="px-6 py-8 text-center text-gray-400">No data.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
      <div class="text-sm text-gray-400">
        Showing {{ $types->firstItem() }} to {{ $types->lastItem() }} of {{ $types->total() }} items
      </div>
      <div class="bg-gray-800 rounded-lg border border-gray-700">
        {{ $types->links() }}
      </div>
    </div>

  </div>
</div>
@endsection
