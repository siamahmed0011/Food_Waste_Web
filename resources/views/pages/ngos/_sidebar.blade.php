<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="p-3 border-bottom">
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

            <div class="border-top"></div>

        </div>
    </div>
</div>
