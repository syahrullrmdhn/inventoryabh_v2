<aside class="w-64 h-screen fixed bg-gray-900/90 backdrop-blur-lg border-r border-gray-800 p-6 flex flex-col shadow-xl">
  <!-- Logo/Brand -->
  <div class="flex items-center gap-3 mb-10">
    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
    </div>
    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">abhinventory</h1>
  </div>

  <!-- Navigation Menu -->
  <nav class="space-y-1.5 flex-1">
    @foreach([
      [
        'route' => 'dashboard',
        'label' => 'Dashboard',
        'icon'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'
      ],
      [
        'route' => 'inventory.index',
        'label' => 'Inventory',
        'icon'  => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'
      ],
      [
        'route' => 'model-types.index',
        'label' => 'Model/Type',
        'icon'  => 'M4 4h16v2H4V4zm0 4h16v2H4V8zm0 4h10v2H4v-2zm0 4h10v2H4v-2z'
      ],
      [
        'route' => 'owners.index',
        'label' => 'Manage Owner',
        'icon'  => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m7-6a4 4 0 11-8 0 4 4 0 018 0zm6 6a4 4 0 00-3-3.87' // Icon user group
      ],
      [
        'route' => 'warehouses.index',
        'label' => 'Manage Warehouse',
        'icon'  => 'M3 7l9-4 9 4M4 10v7a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 012-2h0a2 2 0 012 2v2a2 2 0 002 2h2a2 2 0 002-2v-7' // Icon warehouse/building
      ],
      [
        'route' => 'users.index',
        'label' => 'User Management',
        'icon'  => 'M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z' // Icon user
      ],
    ] as $m)
      <a href="{{ route($m['route']) }}"
         class="flex items-center gap-3 p-3 rounded-xl transition-all duration-200
                {{ request()->routeIs($m['route'].'*')
                    ? 'bg-blue-900/30 text-blue-400 border border-blue-800/50 shadow-lg shadow-blue-900/10'
                    : 'text-gray-400 hover:bg-gray-800/50 hover:text-gray-200 border border-transparent' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $m['icon'] }}" />
        </svg>
        <span class="font-medium">{{ $m['label'] }}</span>
        @if(request()->routeIs($m['route'].'*'))
          <div class="ml-auto w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
        @endif
      </a>
    @endforeach
  </nav>

  <!-- Logout Button -->
  <form action="{{ route('logout') }}" method="POST" class="mt-auto">
    @csrf
    <button type="submit"
      class="w-full py-3 px-4 flex items-center justify-center gap-2
             bg-gray-800 hover:bg-gray-700/80 border border-gray-700 hover:border-gray-600
             text-gray-300 hover:text-white rounded-xl transition-all
             shadow-md hover:shadow-lg hover:shadow-red-900/20">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
      </svg>
      <span>Logout</span>
    </button>
  </form>
</aside>
