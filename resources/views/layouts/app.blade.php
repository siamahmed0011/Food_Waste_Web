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

    /* ✅ Smooth hover effect for all cards */
    .card{
        transition: 0.3s ease;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    /* ✅ Sidebar premium look */
    .sidebar-card{
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        border: 0;
    }
    .sidebar-link{
        transition: all 0.2s ease;
        border-radius: 10px;
        padding: 10px 14px;
        display:block;
        color: #111827;
        text-decoration: none;
        font-weight: 600;
    }
    .sidebar-link:hover{
        background: #f1f5f9;
        padding-left: 18px;
    }
    .sidebar-link.active{
        background: #2563eb;
        color: #fff;
    }

    /* ✅ Welcome card */
    .welcome-card{
        border-radius: 18px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    /* ✅ Stat cards */
    .stat-card{
        border-radius: 16px;
        border: 0;
    }
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
