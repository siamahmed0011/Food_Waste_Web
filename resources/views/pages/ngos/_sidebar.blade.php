<style>
    .ngo-sidebar-card{
        background:#fff;
        border-radius:18px;
        box-shadow:0 12px 30px rgba(15,23,42,.08);
        overflow:hidden;
    }

    .ngo-sidebar-header{
        padding:1.2rem 1.3rem;
        border-bottom:1px solid #e2e8f0;
    }

    .ngo-sidebar-header h5{
        margin:0;
        font-weight:800;
        font-size:1.05rem;
        color:#0f172a;
    }

    .ngo-sidebar-header p{
        margin:.2rem 0 0 0;
        font-size:.85rem;
        color:#64748b;
        font-weight:600;
    }

    .ngo-menu{
        padding:.6rem;
    }

    .ngo-menu a{
        display:block;
        padding:.65rem 1rem;
        border-radius:999px;
        font-weight:700;
        font-size:.95rem;
        color:#0f172a;
        text-decoration:none;
        transition:all .25s ease;
    }

    .ngo-menu a:hover{
        background:#f1f5f9;
        transform:translateX(3px);
    }

    .ngo-menu a.active{
        background:linear-gradient(135deg,#2563eb,#1d4ed8);
        color:#fff !important;
        box-shadow:0 8px 18px rgba(37,99,235,.25);
    }
</style>

<div class="ngo-sidebar-card">

    <div class="ngo-sidebar-header">
        <h5>NGO Panel</h5>
        <p>Manage requests & profile</p>
    </div>

    <div class="ngo-menu">

        <a href="{{ route('ngo.dashboard') }}"
           class="{{ request()->routeIs('ngo.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('ngo.available_foods') }}"
           class="{{ request()->routeIs('ngo.available_foods*') ? 'active' : '' }}">
            Available Foods
        </a>

        <a href="{{ route('ngo.orders') }}"
           class="{{ request()->routeIs('ngo.orders*') ? 'active' : '' }}">
            My Requests
        </a>

        <a href="{{ route('ngo.donors') }}"
           class="{{ request()->routeIs('ngo.donors*') ? 'active' : '' }}">
            Donors
        </a>

        <a href="{{ route('ngo.all_ngos') }}"
           class="{{ request()->routeIs('ngo.all_ngos*') ? 'active' : '' }}">
            All NGOs
        </a>

        <a href="{{ route('ngo.profile') }}"
           class="{{ request()->routeIs('ngo.profile') ? 'active' : '' }}">
            Profile
        </a>

        <a href="{{ route('ngo.settings') }}"
           class="{{ request()->routeIs('ngo.settings*') ? 'active' : '' }}">
            Settings
        </a>

    </div>
</div>
