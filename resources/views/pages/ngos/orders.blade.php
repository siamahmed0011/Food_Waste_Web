@extends('layouts.main')

@section('title', 'My Requests')

@section('content')
<style>
    .ngo-wrap{
        background:#f8fafc;
        padding: 1.6rem 0;
    }
    .ngo-container{
        max-width: 1240px;
    }
    @media (min-width: 992px){
        .ngo-left-tight{ padding-left:0 !important; }
    }

    .page-head{
        display:flex;
        flex-wrap:wrap;
        align-items:flex-end;
        justify-content:space-between;
        gap: .75rem;
        margin-bottom: 1rem;
    }
    .page-head h2{
        margin:0;
        font-weight: 900;
        letter-spacing:.01em;
        font-size: 1.6rem;
        color:#0f172a;
    }
    .page-head .sub{
        margin:.25rem 0 0 0;
        color:#64748b;
        font-weight: 600;
        font-size:.95rem;
    }

    .btn-pill{
        border-radius: 999px !important;
        padding: .55rem 1rem !important;
        font-weight: 800 !important;
        font-size:.9rem !important;
    }

    .card-soft{
        border:0;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        overflow:hidden;
    }
    .filter-bar{
        display:flex;
        flex-wrap:wrap;
        gap:.5rem;
    }
    .filter-bar .btn{
        border-radius: 999px;
        font-weight: 800;
        font-size:.82rem;
        padding: .45rem .85rem;
    }

    .ngo-table thead th{
        font-size:.8rem;
        letter-spacing:.06em;
        color:#64748b;
        text-transform: uppercase;
        border-bottom:1px solid #e2e8f0 !important;
        background:#f8fafc;
        padding: .85rem 1rem;
        white-space: nowrap;
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
        white-space:nowrap;
    }
    .b-pending{ background:#FEF3C7; color:#92400E; }
    .b-approved{ background:#DBEAFE; color:#1D4ED8; }
    .b-picked{ background:#E5E7EB; color:#111827; }
    .b-completed{ background:#DCFCE7; color:#166534; }
    .b-rejected{ background:#FEE2E2; color:#991B1B; }
    .b-cancelled{ background:#E2E8F0; color:#334155; }

    .mini{
        border-radius:999px;
        padding:.35rem .7rem;
        font-weight: 800;
        font-size:.78rem;
        white-space: nowrap;
    }

    .donor-cell{
        display:flex;
        align-items:center;
        gap:.5rem;
        flex-wrap:nowrap;
        white-space: nowrap;
    }
    .donor-name{
        font-weight: 800;
        color:#0f172a;
    }
    .muted{
        color:#64748b;
        font-weight: 600;
        font-size:.9rem;
    }
    .food-title{
        font-weight: 900;
        color:#0f172a;
    }

    .status-filter {
    background: #f1f5f9;
    padding: 10px 14px;
    border-radius: 14px;
    }

    .status-filter .active {
    background: #111827;
    color: #fff;
    border-radius: 999px;
    }

</style>

<div class="ngo-wrap">
    <div class="container ngo-container">
      <div class="status-filter d-flex flex-wrap gap-2 mb-3">
 
        <div class="row g-4">

            {{-- Sidebar --}}
            <div class="col-12 col-lg-3 ngo-left-tight">
                @include('pages.ngos._sidebar')
            </div>

            {{-- Main --}}
            <div class="col-12 col-lg-9">

                <div class="page-head">
                    <div>
                        <h2>My Requests</h2>
                        <div class="sub">Track your pickup requests and their status.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('ngo.available_foods') }}" class="btn btn-primary btn-pill">
                            Request New Pickup
                        </a>
                    </div>
                </div>

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
                @endif

                {{-- Filters --}}
                <div class="card-soft mb-3">
                    <div class="p-3">
                        <div class="filter-bar">
                            <a href="{{ route('ngo.orders') }}"
                               class="btn {{ empty($status) ? 'btn-dark' : 'btn-outline-dark' }}">
                                All
                            </a>

                            @php
                                $filters = ['pending','approved','picked_up','completed','rejected','cancelled'];
                            @endphp

                            @foreach($filters as $f)
                                <a href="{{ route('ngo.orders', ['status' => $f]) }}"
                                   class="btn {{ ($status === $f) ? 'btn-dark' : 'btn-outline-dark' }}">
                                    {{ strtoupper(str_replace('_',' ', $f)) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="card-soft">
                    <div class="p-3">

                        @if($orders->count() === 0)
                            <div class="text-center py-5">
                                <div class="fw-bold mb-2" style="font-size:1.05rem;">No requests found</div>
                                <div class="text-muted mb-3" style="font-weight:600;">
                                    @if($status)
                                        No requests in <b>{{ strtoupper(str_replace('_',' ', $status)) }}</b> status.
                                    @else
                                        You haven’t requested any pickup yet.
                                    @endif
                                </div>
                                <a href="{{ route('ngo.available_foods') }}" class="btn btn-primary btn-pill">
                                    Browse Available Foods
                                </a>
                            </div>
                        @else

                            <div class="table-responsive">
                                <table class="table ngo-table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">#</th>
                                            <th>Food</th>
                                            <th>Donor</th>
                                            <th>Pickup Window</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $i => $o)
                                        @php
                                            $s = $o->status ?? 'pending';
                                            $badgeClass = match($s){
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
                                            <td class="text-muted" style="font-weight:800;">
                                                {{ $orders->firstItem() + $i }}
                                            </td>

                                            <td>
                                                <div class="food-title">
                                                    {{ $o->foodPost?->title ?? '—' }}
                                                </div>
                                                <div class="text-muted small">
                                                  <span class="me-2">Qty: {{ $o->foodPost->quantity }} {{ $o->foodPost->unit }}</span>
                                                  <span>{{ $o->foodPost->pickup_address }}</span>
                                                </div>


                                            </td>

                                            <td>
                                                <div class="donor-cell">
                                                    <span class="donor-name">{{ $o->donor?->name ?? '—' }}</span>

                                                    @if($o->donor)
                                                        <a href="{{ route('ngo.donor.show', $o->donor->id) }}"
                                                           class="btn btn-outline-secondary mini">
                                                            View Profile
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="muted">{{ $o->donor?->phone ?? '—' }}</div>
                                            </td>

                                            <td class="muted" style="white-space:nowrap;">
                                                {{ $o->pickup_time_from?->format('d M Y, h:i A') ?? '—' }}
                                                <span class="text-muted">→</span>
                                                {{ $o->pickup_time_to?->format('d M Y, h:i A') ?? '—' }}

                                                @if($o->final_pickup_at)
                                                    <div class="mt-2">
                                                        <span class="badge-soft b-approved">
                                                            Final: {{ $o->final_pickup_at->format('d M Y, h:i A') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="badge-soft {{ $badgeClass }}">
                                                    {{ strtoupper(str_replace('_',' ', $s)) }}
                                                </span>
                                            </td>

                                            <td class="text-end" style="white-space:nowrap;">
                                                @if($s === 'pending')
                                                    <form action="{{ route('ngo.orders.cancel', $o->id) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-outline-danger mini"
                                                                onclick="return confirm('Cancel this request?')">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @elseif($s === 'approved')
                                                    <span class="muted">Waiting for pickup</span>
                                                @elseif($s === 'picked_up')
                                                    <span class="muted">Picked up</span>
                                                @elseif($s === 'completed')
                                                    <span class="muted">Completed</span>
                                                @elseif($s === 'rejected')
                                                    <span class="text-danger" style="font-weight:800;">Rejected</span>
                                                @elseif($s === 'cancelled')
                                                    <span class="muted">Cancelled</span>
                                                @else
                                                    <span class="muted">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $orders->links() }}
                            </div>

                        @endif

                    </div>
                </div>

            </div>

        </div>
      </div>
    </div>
</div>
@endsection
