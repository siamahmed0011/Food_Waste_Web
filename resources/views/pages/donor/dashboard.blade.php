@extends('layouts.main')

@section('title', 'Donor Dashboard')

@section('content')
    {{-- ========== DASHBOARD PAGE CSS ========== --}}
    <style>
        .dd-wrapper {
            background: #f8fafc;
        }

        /* Hero card */
        .dd-hero-card {
            background: linear-gradient(135deg, #22c55e, #16a3b8);
            border-radius: 18px;
            color: #fff;
            padding: 1.8rem 2rem;
            box-shadow: 0 18px 35px rgba(15, 23, 42, .25);
        }

        .dd-hero-title {
            font-size: clamp(1.9rem, 3vw, 2.3rem);
            font-weight: 800;
            letter-spacing: .02em;
            margin-bottom: .4rem;
        }

        .dd-hero-subtitle {
            font-size: .97rem;
            opacity: .95;
        }

        .dd-hero-actions .btn {
            border-radius: 999px;
            padding: .55rem 1.6rem;
            font-weight: 600;
            font-size: .9rem;
        }

        /* Small stat pills on hero (optional future use) */
        .dd-hero-pill {
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            padding: .35rem .85rem;
            font-size: .8rem;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }

        .dd-hero-pill-number {
            font-weight: 700;
        }

        /* Cards row */
        .dd-card-row {
            margin-top: 2.3rem;
        }

        .dd-card {
            border-radius: 16px;
            border: 0;
            background: #fff;
            padding: 1.5rem 1.4rem 1.4rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .08);
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: .6rem;
        }

        .dd-card-icon {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: .4rem;
        }

        .dd-card-icon--green {
            background: #dcfce7;
            color: #15803d;
        }

        .dd-card-icon--blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .dd-card-icon--teal {
            background: #ccfbf1;
            color: #0f766e;
        }

        .dd-card-title {
            font-size: 1.05rem;
            font-weight: 700;
        }

        .dd-card-text {
            font-size: .9rem;
            color: #6b7280;
            margin-bottom: .4rem;
        }

        .dd-card .btn {
            font-size: .88rem;
            border-radius: 999px;
            padding: .45rem 1.2rem;
        }

        @media (max-width: 767.98px) {
            .dd-hero-card {
                padding: 1.5rem 1.4rem;
            }
        }

        .donor-footer {
        background: #f4f6f6;
        color: #555;
        font-size: 0.9rem;
        border-top: 1px solid #e0e0e0;
        }

    </style>

    {{-- ========== DASHBOARD PAGE HTML ========== --}}
    <div class="dd-wrapper py-4 py-md-5">
        <div class="container">

            {{-- HERO / WELCOME AREA --}}
            <div class="dd-hero-card">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h2 class="dd-hero-title">
                            Welcome, {{ $user->name ?? auth()->user()->name }}
                        </h2>
                        <p class="dd-hero-subtitle mb-0">
                            This is your donor panel. From here you can post surplus food, track your previous
                            donations and manage pickup requests with nearby NGOs.
                        </p>
                    </div>

                
                </div>
            </div>

            {{-- MAIN CARDS --}}
            <div class="row g-4 dd-card-row">

                {{-- Post New Food --}}
                <div class="col-md-4">
                    <div class="dd-card">
                        <div class="dd-card-icon dd-card-icon--green">
                            <i class="bi bi-clipboard-plus"></i>
                        </div>
                        <div class="dd-card-title">Post New Food</div>
                        <p class="dd-card-text">
                            Share extra food in just a few clicks so nearby NGOs can request a safe pickup.
                        </p>
                        <a href="{{ route('donor.food.create') }}" class="btn btn-success mt-auto">
                            Post Now
                        </a>
                    </div>
                </div>

                {{-- My Donations --}}
                <div class="col-md-4">
                    <div class="dd-card">
                        <div class="dd-card-icon dd-card-icon--blue">
                            <i class="bi bi-journal-check"></i>
                        </div>
                        <div class="dd-card-title">My Donations</div>
                        <p class="dd-card-text">
                            See a history of all the meals you’ve shared and manage each donation easily.
                        </p>
                        <a href="{{ route('donor.donations') }}" class="btn btn-outline-primary mt-auto">
                            View Donations
                        </a>
                    </div>
                </div>

                {{-- Pickup Requests  --}}
                <div class="col-md-4">
                    <div class="dd-card">
                        <div class="dd-card-icon dd-card-icon--teal">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="dd-card-title">Pickup Requests</div>
                        <p class="dd-card-text">
                            Manage pickup requests from NGOs and keep track of collection status.
                        </p>

                        <div class="d-flex flex-wrap gap-2 mt-auto">
                            
                            <a href="{{ url('/donor/pickups/create') }}" class="btn btn-outline-success btn-sm">
                                Request Pickup
                            </a>
                            <a href="{{ url('/donor/pickups') }}" class="btn btn-success btn-sm">
                                My Requests
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- ========================= --}}
{{-- 🔔 RECENT NOTIFICATIONS --}}
{{-- ========================= --}}
<div class="mt-4 p-3 bg-white shadow-sm rounded">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">Recent Notifications</h5>

        {{-- ছোট bar/button: গত ৩ দিনের সব নোটিফিকেশন --}}
        <button class="btn btn-sm btn-outline-secondary"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#last3DaysNotifications"
                aria-expanded="false"
                aria-controls="last3DaysNotifications">
            Notifications (last 3 days: {{ $threeDaysNotifications->count() }})
        </button>
    </div>

    @if($recentNotifications->count())
        @foreach($recentNotifications as $note)
            <div class="mb-1">
                <strong>{{ $note->data['ngo_name'] ?? 'NGO' }}</strong>
                accepted your donation:
                <span class="text-primary">"{{ $note->data['food_title'] ?? '' }}"</span>
                <span class="text-muted small">· {{ $note->created_at->diffForHumans() }}</span>
            </div>
        @endforeach
    @else
        <p class="text-muted mb-0">No notifications yet.</p>
    @endif
</div>

 
<div class="collapse mt-3" id="last3DaysNotifications">
    <div class="p-3 bg-white shadow-sm rounded">
        <h5 class="mb-2">Notifications from Last 3 Days</h5>

        @if($threeDaysNotifications->count())
            @foreach($threeDaysNotifications as $note)
                <div class="mb-2 border-bottom pb-1">
                    <strong>{{ $note->data['ngo_name'] ?? 'NGO' }}</strong>
                    accepted your donation:
                    <span class="text-primary">"{{ $note->data['food_title'] ?? '' }}"</span>
                    <div class="small text-muted">
                        {{ $note->created_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted mb-0">No notifications in the last 3 days.</p>
        @endif
    </div>
</div>


    {{-- ===== SIMPLE DONOR FOOTER ===== --}}
        <footer class="donor-footer text-center py-3 mt-4">
            <div class="container">
                 <p class="mb-0">
                      © {{ date('Y') }} Food Waste Platform — Helping Reduce Food Waste.
                 </p>
            </div>
        </footer>

@endsection
