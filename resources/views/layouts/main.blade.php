<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Food Waste Platform')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Leaflet CSS (for map) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Extra page-specific styles --}}
    @stack('styles')
    <style>
  /* RESET – prevent navbar from collapsing */
.navbar {
    min-height: 70px !important;
    display: flex !important;
    align-items: center !important;
}

/* 🌸 Soft Lavender Gradient Navbar */
.navbar {
    background: linear-gradient(90deg, #e8d9ff, #d8c7ff, #c7b3ff) !important;
    padding: 12px 0 !important;
    box-shadow: 0 4px 14px rgba(0,0,0,0.12);
    z-index: 1000;
}

/* Brand + Link Styling */
.navbar .navbar-brand,
.navbar .nav-link {
    color: #3f2b6d !important;
    font-weight: 600;
    transition: 0.25s ease-in-out;
}

/* Hover */
.navbar .nav-link:hover {
    color: #6b4bce !important;
    text-shadow: 0 0 6px rgba(107, 75, 206, 0.4);
}

/* Dropdown menu */
.navbar .dropdown-menu {
    background: #f4e8ff !important;
    border: 1px solid #d8c7ff !important;
    border-radius: 10px;
}

/* Dropdown item */
.navbar .dropdown-item {
    color: #3f2b6d !important;
}
.navbar .dropdown-item:hover {
    background: #e8d9ff !important;
    color: #6b4bce !important;
}

</style>





</style>

</head>
<body>

  {{-- ================= NAVBAR ================= --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-purple shadow-sm">
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
                <ul class="navbar-nav ms-auto">

                    @guest
                        <li class="nav-item me-2">
                            <a href="{{ route('signup.choice') }}" class="btn btn-success btn-sm">Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-success btn-sm">Sign In</a>
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
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle fw-semibold" href="#" data-bs-toggle="dropdown">
                                {{ $user->name }}
                                <span class="badge bg-success text-uppercase small">{{ $user->role }}</span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">

                                {{-- Profile --}}
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

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <strong>✔ Success:</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ERROR --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <strong>⚠ Error:</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- WARNING --}}
            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <strong>⚠ Warning:</strong> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- INFO --}}
            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <strong>ℹ Info:</strong> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- VALIDATION ERRORS --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <strong>⚠ Please fix the following:</strong>
                    <ul class="mt-2 mb-0">
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
    <div class="container-fluid py-3">
        @yield('content')
    </div>



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
</body>
</html>
