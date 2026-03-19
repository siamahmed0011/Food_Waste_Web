{{-- resources/views/pages/donor/sidebar.blade.php --}}

<div class="sidecard">
    <div class="sidecard-head d-flex gap-3 align-items-center">
        <div class="sidecard-badge">FW</div>
        <div>
            <h3 class="sidecard-title">Donor Panel</h3>
            <p class="sidecard-sub">Manage donations & profile</p>
        </div>
    </div>

    <div class="sidecard-menu">
        <a class="sidecard-link {{ request()->routeIs('donor.dashboard') ? 'active' : '' }}"
           href="{{ route('donor.dashboard') }}">
            <span class="side-ico"><i class="bi bi-speedometer2"></i></span>
            <span>Dashboard</span>
        </a>

        <a class="sidecard-link {{ request()->routeIs('donor.food.create') ? 'active' : '' }}"
           href="{{ route('donor.food.create') }}">
            <span class="side-ico"><i class="bi bi-plus-circle"></i></span>
            <span>Create Food</span>
        </a>

        <a class="sidecard-link {{ request()->routeIs('donor.donations*') ? 'active' : '' }}"
           href="{{ route('donor.donations') }}">
            <span class="side-ico"><i class="bi bi-journal-text"></i></span>
            <span>My Donations</span>
        </a>

        <a class="sidecard-link {{ request()->routeIs('donor.pickups.*') ? 'active' : '' }}"
           href="{{ route('donor.pickups.index') }}">
            <span class="side-ico"><i class="bi bi-truck"></i></span>
            <span>Pickup Requests</span>
        </a>

        <a class="sidecard-link {{ request()->routeIs('donor.profile*') ? 'active' : '' }}"
           href="{{ route('donor.profile') }}">
            <span class="side-ico"><i class="bi bi-person"></i></span>
            <span>Profile</span>
        </a>

        <div class="sidecard-divider"></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="sidecard-link sidecard-btn sidecard-danger" type="submit">
                <span class="side-ico"><i class="bi bi-box-arrow-right"></i></span>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
