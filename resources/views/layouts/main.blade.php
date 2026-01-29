<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Food Waste Platform')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Inter Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Leaflet CSS (for map) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Your app.css (Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Extra page-specific styles --}}
    @stack('styles')
</head>

<body>

    {{-- ================= NAVBAR ================= --}}
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">

            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                Food Waste Platform
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">

                {{-- LEFT MENU --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#about">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#contact">Contact</a>
                    </li>
                </ul>

                {{-- RIGHT MENU --}}
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">

                    @guest
                        <li class="nav-item">
                            <a href="{{ route('signup.choice') }}" class="btn btn-success btn-sm px-3">
                                Sign Up
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm px-3">
                                Sign In
                            </a>
                        </li>
                    @endguest

                    @auth
                        @php $user = auth()->user(); @endphp

                        {{-- Role wise dashboard links --}}
                        @if($user->role === 'donor')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('donor.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('donor.ngos.index') }}">NGOs</a>
                            </li>

                        @elseif($user->role === 'organization')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('ngo.dashboard') }}">NGO Dashboard</a>
                            </li>

                        @elseif($user->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                            </li>
                        @endif

                        {{-- USER DROPDOWN --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-semibold" href="#" data-bs-toggle="dropdown">
                                {{ $user->name }}
                                <span class="badge bg-success text-uppercase small">{{ $user->role }}</span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                                {{-- Profile (role-safe route) --}}
                                <li>
                                    <a class="dropdown-item" href="{{ route('donor.profile') }}">
                                        My Profile
                                    </a>
                                </li>

                                <li><hr class="dropdown-divider"></li>

                                {{-- Logout --}}
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger" type="submit">
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth

                </ul>

            </div>
        </div>
    </nav>

    {{-- ================= GLOBAL NOTIFICATIONS ================= --}}
    @if (session('success') || session('error') || session('warning') || session('info') || $errors->any())
        <div class="container mt-3">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <strong>✔ Success:</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <strong>⚠ Error:</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <strong>⚠ Warning:</strong> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <strong>ℹ Info:</strong> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <strong>⚠ Please fix the following:</strong>
                    <ul class="mt-2 mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

        </div>
    @endif

    {{-- ================= PAGE CONTENT ================= --}}
    <main class="page">
        <div class="container py-3">
            @yield('content')
        </div>
    </main>

    {{-- ================= SCRIPTS ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Auto-close alerts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('.alert-dismissible');
            setTimeout(() => {
                alerts.forEach(alert => {
                    const instance = bootstrap.Alert.getOrCreateInstance(alert);
                    instance.close();
                });
            }, 4000);
        });
    </script>

    {{-- Leaflet --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @stack('scripts')

</body>
</html>
