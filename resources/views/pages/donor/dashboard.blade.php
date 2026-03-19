@extends('layouts.main')

@section('title', 'Donor Dashboard')

@section('content')
<div class="panel-layout">
    <aside class="panel-left">
        @include('pages.donor.sidebar')
    </aside>

    <section class="panel-right">

        {{-- HERO (Compact + professional) --}}
        <div class="hero-card clean-hero">
            <div>
                <div class="hero-kicker">Food Waste Reduce Platform</div>
                <h2 class="hero-title mb-0">
                    Welcome, {{ $user->name ?? auth()->user()->name }}
                </h2>
                <p class="hero-sub mb-0">
                    Post surplus food, track your donations, and manage pickup requests with NGOs.
                </p>
            </div>
        </div>

        {{-- ACTION CARDS --}}
        <div class="panel-grid-3 equal-cards">
            <div class="action-card">
                <div class="action-ico bg-soft-green text-green">
                    <i class="bi bi-clipboard-plus"></i>
                </div>
                <div class="action-title">Post New Food</div>
                <div class="action-text">Share extra food so nearby NGOs can request pickup.</div>
                <a href="{{ route('donor.food.create') }}" class="btn btn-success rounded-pill mt-auto w-100">
                    Post Now
                </a>
            </div>

            <div class="action-card">
                <div class="action-ico bg-soft-blue text-blue">
                    <i class="bi bi-journal-check"></i>
                </div>
                <div class="action-title">My Donations</div>
                <div class="action-text">View all your posted food items and donation history.</div>
               <a href="{{ route('donor.donations') }}" class="btn btn-success rounded-pill mt-auto w-100">
    View Donations
</a>

            </div>

            <div class="action-card">
                <div class="action-ico bg-soft-teal text-teal">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="action-title">Pickup Requests</div>
                <div class="action-text">Review NGO pickup requests and update pickup status.</div>

                <div class="d-flex flex-column gap-2 mt-auto">
                    <a href="{{ route('donor.pickups.index') }}" class="btn btn-success rounded-pill w-100">
                        View Requests
                    </a>
                    <a href="{{ route('donor.donations') }}" class="btn btn-success rounded-pill w-100 fw-semibold">
    Manage Posts
</a>

                </div>
            </div>
        </div>

{{-- NOTIFICATIONS --}}
<div class="content-card">
    <div class="content-head">
        <div>
            <h5 class="mb-0 fw-bold">Recent Notifications</h5>
            <div class="small text-muted mt-1">Latest updates about your donations</div>
        </div>

        <button class="btn btn-sm rounded-pill last3-btn"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#last3DaysNotifications">
            Last 3 days: {{ $threeDaysNotifications->count() }}
        </button>
    </div>

    @if($recentNotifications->count())
        <div class="notif-list">
            @foreach($recentNotifications as $note)
                <div class="notif-item">
                    <div class="notif-title">
                        <strong>{{ $note->data['ngo_name'] ?? 'NGO' }}</strong>
                        accepted:
                        <span class="text-primary fw-semibold">"{{ $note->data['food_title'] ?? '' }}"</span>
                    </div>
                    <div class="notif-sub">{{ $note->created_at->diffForHumans() }}</div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-ico"><i class="bi bi-bell"></i></div>
            <div>
                <div class="fw-semibold">No notifications yet</div>
                <div class="text-muted small">When an NGO accepts your donation, you’ll see it here.</div>
            </div>
        </div>
    @endif
</div>

{{-- LAST 3 DAYS --}}
<div class="collapse mt-3" id="last3DaysNotifications">
    <div class="content-card alt-card">
        <div class="content-head">
            <h5 class="mb-0 fw-bold section-title">Notifications from Last 3 Days</h5>
        </div>

        @if($threeDaysNotifications->count())
            <div class="notif-list">
                @foreach($threeDaysNotifications as $note)
                    <div class="notif-item">
                        <div class="notif-title">
                            <strong>{{ $note->data['ngo_name'] ?? 'NGO' }}</strong>
                            accepted:
                            <span class="text-primary fw-semibold">"{{ $note->data['food_title'] ?? '' }}"</span>
                        </div>
                        <div class="notif-sub">{{ $note->created_at->diffForHumans() }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-ico"><i class="bi bi-clock-history"></i></div>
                <div>
                    <div class="fw-semibold">No updates in last 3 days</div>
                    <div class="text-muted small">You’re all caught up.</div>
                </div>
            </div>
        @endif
    </div>
</div>
        <div class="tiny-footer">
            © {{ date('Y') }} Food Waste Platform — Helping Reduce Food Waste.
        </div>

    </section>
</div>
@endsection
