<!-- layouts/guest.blade.php (untuk login) -->
<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Abhinawa Inventory Login')</title>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="bg-gradient-to-br from-gray-900 to-black font-mulish min-h-screen flex items-center justify-center p-4">
  @yield('content')
  <script src="{{ mix('js/app.js') }}" defer></script>
  @stack('scripts')
</body>
</html>
