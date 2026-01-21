<div class="list-group shadow-sm rounded-3">

    <a href="{{ route('ngo.dashboard') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('ngo.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>

    <a href="{{ route('ngo.profile') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('ngo.profile') ? 'active' : '' }}">
        <i class="bi bi-person-badge me-2"></i> Profile
    </a>

    <a href="{{ route('ngo.orders') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('ngo.orders') ? 'active' : '' }}">
        <i class="bi bi-box-seam me-2"></i> Orders
    </a>

    {{-- ⭐ NEW: Available Foods --}}
    <a href="{{ route('ngo.available_foods') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('ngo.available_foods') ? 'active' : '' }}">
        <i class="bi bi-basket me-2"></i> Available Foods
    </a>

    {{-- NEW: All NGOs --}}
    <a href="{{ route('ngo.all_ngos') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('ngo.all_ngos') ? 'active' : '' }}">
        <i class="bi bi-building me-2"></i> All NGOs
    </a>

    {{-- NEW: Donors list --}}
    <a href="{{ route('ngo.donors') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('ngo.donors') ? 'active' : '' }}">
        <i class="bi bi-people me-2"></i> Donors
    </a>

    <a href="{{ route('ngo.settings') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('ngo.settings') ? 'active' : '' }}">
        <i class="bi bi-gear me-2"></i> Settings
    </a>

</div>
