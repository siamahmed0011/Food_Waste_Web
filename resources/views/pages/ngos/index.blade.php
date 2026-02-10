@extends('layouts.main')

@section('title', 'NGO Dashboard')

@section('content')
<style>
    /* Make page more left-aligned + less empty space */
    .ngo-wrap{
        background:#f8fafc;
        padding: 1.6rem 0;
    }
    .ngo-container{
        max-width: 1240px; /* a bit wider so left column feels closer */
    }

    .ngo-hero{
        background: linear-gradient(135deg, #22c55e, #16a3b8);
        border-radius: 18px;
        color:#fff;
        padding: 1.6rem 1.8rem;
        box-shadow: 0 18px 35px rgba(15,23,42,.18);
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:1rem;
    }
    .ngo-hero h1{
        font-size: clamp(1.7rem, 2.7vw, 2.2rem);
        font-weight: 800;
        margin:0 0 .35rem 0;
        letter-spacing:.02em;
    }
    .ngo-hero p{
        margin:0;
        opacity:.95;
        max-width: 58ch;
        font-size:.95rem;
        line-height:1.45;
    }

    .ngo-grid{ margin-top: 1.2rem; }

    .ngo-stat{
        background:#fff;
        border:0;
        border-radius: 16px;
        padding: 1.1rem 1.2rem;
        box-shadow: 0 12px 30px rgba(15,23,42,.08);
        height:100%;
    }
    .ngo-stat .label{
        font-size: .85rem;
        color:#64748b;
        font-weight:700;
        margin-bottom:.35rem;
    }
    .ngo-stat .num{
        font-size: 2rem;
        font-weight: 900;
        margin:0;
        color:#0f172a;
        line-height:1;
    }
    .ngo-stat .sub{
        margin-top:.35rem;
        color:#64748b;
        font-size:.9rem;
        font-weight: 600;
    }

    .ngo-card{
        background:#fff;
        border:0;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(15,23,42,.08);
        overflow:hidden;
    }
    .ngo-card-head{
        padding: 1.1rem 1.2rem;
        border-bottom: 1px solid #e2e8f0;
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:1rem;
    }
    .ngo-card-head h3{
        margin:0;
        font-size: 1.25rem;
        font-weight: 900;
        color:#0f172a;
    }
    .ngo-card-head .muted{
        margin: .25rem 0 0 0;
        color:#64748b;
        font-size:.92rem;
        font-weight: 600;
    }
    .ngo-card-head .btn{
        border-radius: 999px;
        padding: .5rem 1rem;
        font-weight: 800;
        font-size:.88rem;
    }

    .ngo-table{ margin:0; }
    .ngo-table thead th{
        font-size:.8rem;
        letter-spacing:.06em;
        color:#64748b;
        text-transform: uppercase;
        border-bottom:1px solid #e2e8f0 !important;
        background:#f8fafc;
        padding: .85rem 1rem;
    }
    .ngo-table tbody td{
        padding: 1rem;
        vertical-align: middle;
        border-top:1px solid #eef2f7;
        font-weight: 600;
        color:#0f172a;
    }

    .badge-soft{
        border-radius:999px;
        padding:.35rem .7rem;
        font-weight:900;
        font-size:.75rem;
        display:inline-flex;
        align-items:center;
        gap:.35rem;
    }
    .b-pending{ background:#FEF3C7; color:#92400E; }
    .b-approved{ background:#DBEAFE; color:#1D4ED8; }
    .b-picked{ background:#E5E7EB; color:#111827; }
    .b-completed{ background:#DCFCE7; color:#166534; }
    .b-rejected{ background:#FEE2E2; color:#991B1B; }
    .b-cancelled{ background:#E2E8F0; color:#334155; }

    .btn-mini{
        border-radius: 999px;
        padding: .35rem .7rem;
        font-weight: 800;
        font-size:.78rem;
    }

    /* Make left sidebar closer to page edge on large screens */
    @media (min-width: 992px){
        .ngo-left-tight{
            padding-left: 0 !important;
        }
    }
</style>

<div class="ngo-wrap">
    <div class="container ngo-container">
        <div class="row g-4">

            {{-- Sidebar --}}
            <div class="col-12 col-lg-3 ngo-left-tight">
                @include('pages.ngos._sidebar')
            </div>

            {{-- Main --}}
            <div class="col-12 col-lg-9">

                {{-- Hero (NO Total Requests pill) --}}
                <div class="ngo-hero">
                    <div>
                        <h1>Welcome, {{ auth()->user()->name }}</h1>
                        <p>
                            This is your NGO panel. Browse available food, request pickups, and track distribution progress with ease.
                        </p>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="row g-3 ngo-grid">
                    <div class="col-md-4">
                        <div class="ngo-stat">
                            <div class="label">Total Requests</div>
                            <p class="num">{{ $stats['total'] ?? 0 }}</p>
                            <div class="sub">All pickup requests you made</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="ngo-stat">
                            <div class="label">Pending</div>
                            <p class="num">{{ $stats['pending'] ?? 0 }}</p>
                            <div class="sub">Waiting for donor approval</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="ngo-stat">
                            <div class="label">Completed</div>
                            <p class="num">{{ $stats['completed'] ?? 0 }}</p>
                            <div class="sub">Completed pickups history</div>
                        </div>
                    </div>
                </div>

                {{-- Recent Requests (only LAST 3) --}}
                <div class="ngo-card mt-4">
                    <div class="ngo-card-head">
                        <div>
                            <h3>Recent Requests</h3>
                            <div class="muted">Last 3 pickup requests you created</div>
                        </div>

                        {{-- View all => My Requests --}}
                        <a href="{{ route('ngo.orders') }}" class="btn btn-outline-secondary">
                            View all
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table ngo-table align-middle">
                            <thead>
                                <tr>
                                    <th>Food</th>
                                    <th>Donor</th>
                                    <th>Status</th>
                                    <th class="text-end">Requested</th>
                                </tr>
                            </thead>

                            <tbody>
                            @php
                                $recent3 = ($recent ?? collect())->take(3);
                            @endphp

                            @if($recent3->count() === 0)
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5" style="font-weight:700;">
                                        No requests yet
                                    </td>
                                </tr>
                            @else
                                @foreach($recent3 as $r)
                                    @php
                                        $status = $r->status ?? 'pending';
                                        $badgeClass = match($status){
                                            'pending' => 'b-pending',
                                            'approved' => 'b-approved',
                                            'picked_up' => 'b-picked',
                                            'completed' => 'b-completed',
                                            'rejected' => 'b-rejected',
                                            'cancelled' => 'b-cancelled',
                                            default => 'b-cancelled',
                                        };
                                    @endphp
                                    <tr>
                                        <td class="fw-bold">
                                            {{ $r->foodPost?->title ?? '—' }}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>{{ $r->donor?->name ?? '—' }}</span>

                                                @if($r->donor)
                                                    <a href="{{ route('ngo.donor.show', $r->donor->id) }}"
                                                       class="btn btn-outline-secondary btn-mini">
                                                        View Profile
                                                    </a>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <span class="badge-soft {{ $badgeClass }}">
                                                {{ strtoupper(str_replace('_',' ', $status)) }}
                                            </span>
                                        </td>

                                        <td class="text-end text-muted" style="font-weight:700;">
                                            {{ optional($r->created_at)->diffForHumans() ?? '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-muted mt-3" style="font-weight:600;">
                    Tip: Keep your phone/address updated so donors can coordinate pickup smoothly.
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
