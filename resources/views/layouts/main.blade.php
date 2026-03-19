<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Food Waste Reduce Platform')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Inter Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Leaflet CSS (optional) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ===== Global UI CSS (Donor/NGO panels) ===== --}}
    <style>
body{
  font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
  background:#f8fafc;
}

/* ===== Panel layout (compact) ===== */
.panel-layout{display:flex;gap:18px;align-items:flex-start;padding:14px 0;}
.panel-left{width:280px;flex:0 0 280px;}
.panel-right{flex:1;display:flex;flex-direction:column;gap:12px;}
@media (max-width: 992px){
  .panel-layout{flex-direction:column;}
  .panel-left{width:100%;flex:1;}
}

/* ===== Sidebar card ===== */
.sidecard{
  background:#fff;
  border-radius:16px;
  padding:14px;
  box-shadow:0 12px 30px rgba(15,23,42,.08);
  border:1px solid rgba(15,23,42,.06);
}
.sidecard-head{
  padding:6px 6px 12px;
  border-bottom:1px solid rgba(15,23,42,.06);
  margin-bottom:10px;
  display:flex;
  gap:12px;
  align-items:center;
}
.sidecard-title{margin:0;font-weight:900;font-size:22px;}
.sidecard-sub{margin:6px 0 0;color:#64748b;font-weight:600;font-size:.92rem;}
.sidecard-menu{display:flex;flex-direction:column;gap:8px;margin-top:8px;}
.sidecard-divider{height:1px;background:rgba(15,23,42,.08);margin:6px 0;}

/* Badge */
.sidecard-badge{
  width:38px;height:38px;border-radius:12px;
  display:grid;place-items:center;
  background:rgba(34,197,94,.14);
  color:#14532d;
  font-weight:900;
  border:1px solid rgba(15,23,42,.06);
}

/* ICON */
.side-ico{
  width:30px;height:30px;border-radius:10px;
  display:grid;place-items:center;
  background:rgba(15,23,42,.04);
  border:1px solid rgba(15,23,42,.06);
  flex:0 0 auto;
}

/* ✅ FIX: Link base (no underline, no blue color) */
.sidecard-link{
  text-decoration:none !important;
  color:#0f172a !important;
  font-weight:800;
  padding:10px 12px;
  border-radius:12px;
  display:flex;
  align-items:center;
  gap:10px;
  transition:.2s ease;
  border:1px solid transparent;
  background:transparent;
}

/* ✅ FIX: hover */
.sidecard-link:hover{
  background:rgba(37,99,235,.08);
  text-decoration:none !important;
}

/* ✅ FIX: active */
.sidecard-link.active{
  border-radius:14px;
  background:linear-gradient(180deg,#2563eb,#1d4ed8);
  color:#fff !important;
  box-shadow:0 14px 26px rgba(29,78,216,.25);
}
.sidecard-link.active .side-ico{
  background:rgba(255,255,255,.18);
  border-color:rgba(255,255,255,.22);
}
.sidecard-link.active i{ color:#fff; }

/* ✅ FIX: button logout should look like link */
.sidecard-btn{
  width:100%;
  text-align:left;
  cursor:pointer;
  background:transparent !important;
  border:none !important;
  outline:none !important;
}

/* ✅ FIX: Logout red (2 options: class "danger" or "sidecard-danger") */
.sidecard-link.danger,
.sidecard-danger{
  color:#b91c1c !important;
}
.sidecard-link.danger:hover,
.sidecard-danger:hover{
  background:rgba(185,28,28,.08) !important;
}

/* Last 3 days button premium */
.last3-btn{
  border:1px solid rgba(15,23,42,.10) !important;
  background:#fff !important;
  color:#0f172a !important;
  font-weight:800 !important;
  padding:.45rem 1rem !important;
  border-radius:999px !important;
  box-shadow:0 6px 14px rgba(15,23,42,.06) !important;
  transition:.2s ease;
}
.last3-btn:hover{
  background:rgba(34,197,94,.10) !important;
  color:#15803d !important;
}
/* 2nd content card look different (FIXED) */
.content-card.alt-card{
  overflow:hidden;
  position:relative;
  border-radius: 14px;
  padding-left: 22px;
  padding-top:12px;
  padding-bottom:12px;
  background: #fff;              /* ✅ REMOVE gradient */
  border: 1px solid rgba(15,23,42,.06);
}

.content-card.alt-card::before{
  content:"";
  position:absolute;
  left:0;
  top:0;
  bottom:0;       /* height:100% এর বদলে এটা better */
  height:auto
  width: 4px;
  opacity:.9;
  background: linear-gradient(180deg, #06b6d4, #22c55e);
  border-radius:14px 0 0 14px;
}

/* Extra safety: collapse wrapper যেন clip ঠিক থাকে */
#last3DaysNotifications{
  overflow: hidden;
  border-radius: 14px;
}

/* Empty state modern look */
/* Empty state modern look */
.empty-state{
  border:none;
  background:transparent;
  padding:14px 4px;
  border-radius:14px;
  display:flex;
  align-items:center;
  gap:14px;
}

.empty-ico{
  width:42px;
  height:42px;
  border-radius:12px;
  display:grid;
  place-items:center;
  background:#fff;
  border:1px solid rgba(15,23,42,.06);
  box-shadow:none;
  font-size:17px;
}

/* ===== Hero (clean minimal) ===== */
.hero-card.clean-hero{
  min-height:auto;
  padding:16px 18px;
  border-radius:16px;
  background:linear-gradient(135deg, rgba(34,197,94,.18), rgba(6,182,212,.18));
  border:1px solid rgba(15,23,42,.06);
  display:block;
}
.hero-kicker{font-size:.78rem;font-weight:800;color:#0f766e;margin-bottom:4px;}
.hero-title{margin:0;font-size:clamp(22px,1.8vw,28px);font-weight:900;line-height:1.15;}
.hero-sub{margin:8px 0 0;font-size:.95rem;color:#334155;font-weight:600;opacity:.9;max-width:70ch;line-height:1.45;}
@media (max-width: 576px){ .hero-card.clean-hero{padding:14px 14px;} }

/* ===== Grid cards (dashboard) ===== */
.panel-grid-3{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;}
@media (max-width: 992px){.panel-grid-3{grid-template-columns:1fr;}}
.action-card{
  background:#fff;
  border:1px solid rgba(15,23,42,.06);
  border-radius:14px;
  padding:14px;
  box-shadow:0 12px 30px rgba(15,23,42,.06);
  display:flex;
  flex-direction:column;
  gap:8px;
  height:100%;
  transition:.2s ease;
}
.action-card:hover{transform:translateY(-3px);box-shadow:0 18px 40px rgba(15,23,42,.09);}
.equal-cards .action-card{min-height:190px;}
.action-ico{width:40px;height:40px;border-radius:999px;display:flex;align-items:center;justify-content:center;font-size:1.05rem;}
.action-title{font-weight:900;font-size:16px;}
.action-text{color:#64748b;font-weight:600;font-size:.9rem;}
.bg-soft-green{background:#dcfce7;} .text-green{color:#15803d;}
.bg-soft-blue{background:#dbeafe;} .text-blue{color:#1d4ed8;}
.bg-soft-teal{background:#ccfbf1;} .text-teal{color:#0f766e;}

/* ===== Content card ===== */
.content-card{
  background:#fff;
  border:1px solid rgba(15,23,42,.06);
  border-radius:14px;
  padding:14px;
  box-shadow:0 12px 30px rgba(15,23,42,.06);
}
.content-head{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:8px;}
.tiny-footer{color:#64748b;font-weight:600;font-size:.9rem;text-align:center;padding:8px 0;}

</style>

    {{-- Page specific styles --}}
    @stack('styles')
</head>

<body>

{{-- ================= NAVBAR ================= --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <span class="text-success">Food Waste Reduce</span> Platform
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            {{-- LEFT MENU --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#contact">Contact</a></li>
            </ul>

            {{-- RIGHT MENU --}}
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">

                @guest
                    <li class="nav-item">
                        <a href="{{ route('signup.choice') }}" class="btn btn-success btn-sm px-3">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm px-3">Sign In</a>
                    </li>
                @endguest

                @auth
                    @php $user = auth()->user(); @endphp

                    {{-- Role wise dashboard links --}}
                    @if($user->role === 'donor')
                        <li class="nav-item"><a class="nav-link" href="{{ route('donor.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('donor.ngos.index') }}">NGOs</a></li>
                    @elseif($user->role === 'organization')
                        <li class="nav-item"><a class="nav-link" href="{{ route('ngo.dashboard') }}">NGO Dashboard</a></li>
                    @elseif($user->role === 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                    @endif

                    {{-- USER DROPDOWN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" data-bs-toggle="dropdown">
                            {{ $user->name }}
                            <span class="badge bg-success text-uppercase small">{{ $user->role }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li>
                                <a class="dropdown-item" href="{{ route('donor.profile') }}">
                                    <i class="bi bi-person me-2"></i> My Profile
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
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
