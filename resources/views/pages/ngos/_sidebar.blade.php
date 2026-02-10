<div class="card border-0 shadow-sm ngo-side">
    <div class="card-body pb-2">
        <div class="fw-bold">NGO Panel</div>
        <div class="text-muted small">Manage requests & profile</div>
    </div>

    <div class="list-group list-group-flush">
        <a href="{{ route('ngo.dashboard') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('ngo.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('ngo.available_foods') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('ngo.available_foods') ? 'active' : '' }}">
            Available Foods
        </a>

        <a href="{{ route('ngo.orders') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('ngo.orders*') ? 'active' : '' }}">
            My Requests
        </a>

        <a href="{{ route('ngo.donors') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('ngo.donors') ? 'active' : '' }}">
            Donors
        </a>

        <a href="{{ route('ngo.all_ngos') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('ngo.all_ngos') ? 'active' : '' }}">
            All NGOs
        </a>

        <a href="{{ route('ngo.profile') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('ngo.profile') ? 'active' : '' }}">
            Profile
        </a>

        <a href="{{ route('ngo.settings') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('ngo.settings*') ? 'active' : '' }}">
            Settings
        </a>
    </div>
</div>

<style>
    .ngo-side .list-group-item{
        border: 0;
        padding: .9rem 1rem;
        font-weight: 600;
        color: #0f172a;
        border-radius: 0;
    }
    .ngo-side .list-group-item.active{
        background: #2563eb;
        color: #fff;
    }
    .ngo-side .list-group-item:hover{
        background: #f1f5f9;
    }
    .ngo-side .list-group-item.active:hover{
        background: #2563eb;
    }
</style>
