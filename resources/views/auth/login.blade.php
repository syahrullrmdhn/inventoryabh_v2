@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen w-full overflow-hidden bg-gray-900">
  {{-- Left: Form Section --}}
  <div class="flex flex-col justify-center w-full max-w-xl px-8 z-10 relative">
    {{-- Glossy effect elements --}}
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute top-1/4 -right-20 w-80 h-80 rounded-full bg-blue-500/10 filter blur-[100px]"></div>
      <div class="absolute bottom-1/4 -left-20 w-80 h-80 rounded-full bg-blue-500/5 filter blur-[100px]"></div>
    </div>

    <div class="relative z-10 backdrop-blur-sm bg-black/30 rounded-2xl p-8 border border-gray-800 shadow-2xl">
      {{-- Logo/Brand --}}
      <div class="flex items-center mb-8">
        <div class="w-12 h-12 rounded-xl bg-black border border-gray-800 flex items-center justify-center mr-3 shadow-inner">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
        </div>
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600">abhinawainventory</h1>
      </div>

      <h2 class="text-2xl font-semibold text-gray-100 mb-2">Welcome back</h2>
      <p class="text-gray-400 mb-8">
        Sign in to access your dashboard
      </p>

      {{-- Login Form --}}
      <form method="POST" action="{{ route('login') }}" class="w-full space-y-6">
        @csrf

        <div class="space-y-5">
          {{-- Email Field --}}
          <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                  <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
              </div>
              <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                placeholder="you@example.com"
                class="w-full pl-10 pr-4 py-3 bg-gray-800/70 text-gray-100 placeholder-gray-500 border border-gray-700 rounded-xl
                      focus:outline-none focus:ring-1 focus:ring-blue-500/50 focus:border-blue-500 transition
                      hover:border-gray-600 shadow-inner backdrop-blur-sm" />
            </div>
            @error('email')
              <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
          </div>

          {{-- Password Field --}}
          <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
              </div>
              <input id="password" name="password" type="password" required placeholder="••••••••"
                class="w-full pl-10 pr-4 py-3 bg-gray-800/70 text-gray-100 placeholder-gray-500 border border-gray-700 rounded-xl
                      focus:outline-none focus:ring-1 focus:ring-blue-500/50 focus:border-blue-500 transition
                      hover:border-gray-600 shadow-inner backdrop-blur-sm" />
            </div>
            @error('password')
              <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input id="remember-me" name="remember" type="checkbox"
              class="h-4 w-4 bg-gray-800 border-gray-700 rounded text-blue-500 focus:ring-blue-500/50">
            <label for="remember-me" class="ml-2 block text-sm text-gray-400">
              Remember me
            </label>
          </div>

          @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-400 hover:text-blue-300 transition">
              Forgot password?
            </a>
          @endif
        </div>

        <button type="submit"
          class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600
                 text-white font-medium rounded-xl transition duration-300 shadow-lg hover:shadow-blue-500/20
                 border border-blue-700/50 flex items-center justify-center space-x-2 mt-6">
          <span>Sign in</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>
      </form>
    </div>

    {{-- Footer note --}}
    <div class="text-center text-gray-500 text-xs mt-8">
      © 2025 Syahrul Ramadhan. All rights reserved.
    </div>
  </div>

  {{-- Right: Image Section --}}
  <div class="hidden lg:block relative flex-1 min-h-screen">
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/50 to-black/80 z-10"></div>
    <img src="https://images.unsplash.com/photo-1639762681057-408e52192e55?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2232&q=80"
      alt="Modern inventory management"
      class="absolute inset-0 w-full h-full object-cover object-center"
      draggable="false" loading="lazy" />

    <div class="absolute left-0 bottom-0 p-8 text-gray-100 z-20 max-w-lg">
      <div class="text-lg font-medium mb-2 text-blue-400">"Precision in inventory is the foundation of business efficiency."</div>
      <div class="text-sm text-gray-400">Modern inventory management system</div>
    </div>
  </div>
</div>
@endsection
