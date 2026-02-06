<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Food Donation')</title>

    <!-- ✅ Bootstrap CSS (NO VITE, NO NPM) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional custom css -->
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 12px; }
        .navbar-brand { font-weight: 700; }
    </style>
</head>
<body>

    {{-- Navbar --}}
    @include('partials.nav')

    {{-- Page content --}}
    <main class="py-4">
        @yield('content')
    </main>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
