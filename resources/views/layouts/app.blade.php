<!-- layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','AbhinawaInventory Login')</title>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="bg-darkbg text-white min-h-screen flex">
  @auth
    @include('layouts.sidebar')
  @endauth

  <div class="@auth flex-1 p-6 overflow-auto @else flex items-center justify-center p-4 @endauth">
    @yield('content')
  </div>
  <script src="{{ mix('js/app.js') }}" defer></script>
  @stack('scripts')
</body>
</html>
