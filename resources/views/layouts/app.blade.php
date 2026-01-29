{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  @vite(['resources/css/theme.css','resources/js/app.js'])
  <title>@yield('title','Food Donation')</title>
</head>
<body>
  @include('partials.nav') {{-- তুমি চাইলে --}}
  <main class="page">
    <div class="container">
      @yield('content')
    </div>
  </main>
</body>
</html>
