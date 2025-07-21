@extends('layouts.app')

@section('title','Dashboard')

@section('meta_title','Dashboard | Abhinawa Inventory')
@section('meta_description','Ringkasan inventaris Anda: total items, stok minimum, dan out‑of‑stock.')
@section('meta_image', asset('images/dashboard-preview.png'))

@section('content')
<div class="ml-64 p-8 min-h-screen bg-gradient-to-br from-gray-900 to-gray-800">
  <div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">Dashboard</h1>
      <div class="text-sm text-gray-400">Last updated: {{ now()->format('d M Y, H:i') }}</div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <!-- Card Total Items -->
      <div class="p-6 bg-gray-800/50 rounded-xl border border-gray-700 shadow-lg hover:shadow-blue-500/10 transition-all hover:border-blue-500/30">
        <div class="flex items-center gap-3 mb-4">
          <div class="p-2 rounded-lg bg-blue-900/30 border border-blue-800/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
          </div>
          <h2 class="text-lg font-medium text-gray-300">Total Items</h2>
        </div>
        <p class="text-4xl font-bold text-white">{{ $total }}</p>
        <div class="mt-2 text-sm text-blue-400 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
          </svg>
          <span>All inventory items</span>
        </div>
      </div>

      <!-- Card Below Min -->
      <div class="p-6 bg-gray-800/50 rounded-xl border border-gray-700 shadow-lg hover:shadow-amber-500/10 transition-all hover:border-amber-500/30">
        <div class="flex items-center gap-3 mb-4">
          <div class="p-2 rounded-lg bg-amber-900/30 border border-amber-800/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77-1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <h2 class="text-lg font-medium text-gray-300">Below Min</h2>
        </div>
        <p class="text-4xl font-bold text-white">{{ $belowMin }}</p>
        <div class="mt-2 text-sm text-amber-400 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Items needing attention</span>
        </div>
      </div>

      <!-- Card Out of Stock -->
      <div class="p-6 bg-gray-800/50 rounded-xl border border-gray-700 shadow-lg hover:shadow-red-500/10 transition-all hover:border-red-500/30">
        <div class="flex items-center gap-3 mb-4">
          <div class="p-2 rounded-lg bg-red-900/30 border border-red-800/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h2 class="text-lg font-medium text-gray-300">Out of Stock</h2>
        </div>
        <p class="text-4xl font-bold text-white">{{ $outStock }}</p>
        <div class="mt-2 text-sm text-red-400 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
          <span>Urgent restock needed</span>
        </div>
      </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-gray-800/50 rounded-xl border border-gray-700 shadow-lg p-6 mb-8">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-200">Inventory Levels</h2>
        <div class="flex gap-2">
          <span class="inline-flex items-center text-sm text-blue-400">
            <span class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span> In Stock
          </span>
          <span class="inline-flex items-center text-sm text-red-400">
            <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span> Min Stock
          </span>
        </div>
      </div>
      <div class="overflow-x-auto" style="max-width:100%;">
        <div class="min-w-[600px] max-w-full" style="min-width:600px; max-width:900px;">
          <canvas id="stockChart" height="260"></canvas>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-gray-800/50 rounded-xl border border-gray-700 shadow-lg p-6">
      <h2 class="text-xl font-semibold text-gray-200 mb-4">Recent Activity</h2>
      <div class="space-y-4 max-h-96 overflow-y-auto">
        @forelse($recentActivities as $a)
          <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-800/30 flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 2v1m0 2v2m0 2v1m0 2v1m0 2v1" />
              </svg>
            </div>
            <div>
              <div class="text-sm text-white font-semibold">
                {{ $a->user->name ?? 'Unknown User' }}
                <span class="font-normal text-gray-400">({{ $a->ip_address }})</span>
              </div>
              <div class="text-sm text-blue-300">{{ $a->activity }}</div>
              @if($a->info)
                <div class="text-xs text-gray-400">
                  @php
                    $info = json_decode($a->info, true);
                  @endphp
                  @if(is_array($info))
                    @foreach($info as $k=>$v)
                      <span class="mr-2"><span class="font-medium">{{ $k }}:</span> {{ $v }}</span>
                    @endforeach
                  @else
                    {{ $a->info }}
                  @endif
                </div>
              @endif
              <div class="text-xs text-gray-500">{{ $a->created_at->format('d M Y H:i') }}</div>
            </div>
          </div>
        @empty
          <div class="text-center py-8 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="mt-2">Activity log will appear here</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = {!! $chartData->pluck('inventory_name') !!};
  const stocks = {!! $chartData->pluck('stock_quantity') !!};
  const mins   = {!! $chartData->pluck('minimum_stock') !!};

  new Chart(document.getElementById('stockChart'), {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'In Stock',
          data: stocks,
          backgroundColor: 'rgba(59, 130, 246, 0.7)',
          borderColor: 'rgba(59, 130, 246, 1)',
          borderWidth: 1,
          borderRadius: 4
        },
        {
          label: 'Min Stock',
          data: mins,
          backgroundColor: 'rgba(239, 68, 68, 0.7)',
          borderColor: 'rgba(239, 68, 68, 1)',
          borderWidth: 1,
          borderRadius: 4
        },
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          grid: { color: 'rgba(255, 255, 255, 0.1)' },
          ticks: { color: '#9CA3AF', font: { size: 14 } }
        },
        y: {
          grid: { color: 'rgba(255, 255, 255, 0.1)' },
          ticks: { color: '#9CA3AF', font: { size: 14 } },
          beginAtZero: true
        }
      },
      plugins: {
        legend: {
          display: true,
          labels: { color: '#fff', font: { size: 15 } }
        },
        tooltip: {
          backgroundColor: 'rgba(31, 41, 55, 0.9)',
          titleColor: '#E5E7EB',
          bodyColor: '#D1D5DB',
          borderColor: '#4B5563',
          borderWidth: 1,
          padding: 12,
          usePointStyle: true
        }
      }
    }
  });
</script>
@endpush
