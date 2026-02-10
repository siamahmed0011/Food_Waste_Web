@extends('layouts.main')

@section('title', 'Available Food Posts')

@section('content')
<style>
    .ngo-page{ background:#f8fafc; padding: 2rem 0; }
    .ngo-box{
        background:#fff;
        border:0;
        border-radius:16px;
        box-shadow: 0 12px 30px rgba(15,23,42,.08);
    }
    .ngo-box .head{
        padding: 1.1rem 1.2rem;
        border-bottom:1px solid #e2e8f0;
    }
    .ngo-box .head h3{ margin:0; font-weight:900; color:#0f172a; }
    .ngo-box .head .muted{ color:#64748b; font-weight:600; font-size:.92rem; }
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
        border-top:1px solid #eef2f7;
        vertical-align: middle;
        font-weight: 600;
        color:#0f172a;
    }
    .btn-pill{ border-radius:999px; font-weight:800; padding:.45rem .9rem; font-size:.82rem; }
    .tag{
        border-radius:999px;
        padding:.35rem .7rem;
        font-weight:900;
        font-size:.75rem;
        display:inline-flex;
        align-items:center;
        background:#e2e8f0;
        color:#334155;
    }
    .tag-pending{ background:#FEF3C7; color:#92400E; }
    .tag-approved{ background:#DBEAFE; color:#1D4ED8; }
    .tag-picked{ background:#E5E7EB; color:#111827; }
    .tag-completed{ background:#DCFCE7; color:#166534; }
</style>

<div class="ngo-page">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-3">
                @include('pages.ngos._sidebar')
            </div>

            <div class="col-12 col-lg-9">
                <div class="ngo-box">
                    <div class="head">
                        <h3>Available Food Donations</h3>
                        <div class="muted">Choose any donation to accept.</div>
                    </div>

                    <div class="p-3">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if($foods->count())
                            <div class="table-responsive">
                                <table class="table ngo-table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width:55px;">#</th>
                                            <th>Donor</th>
                                            <th>Title</th>
                                            <th style="width:120px;">Qty</th>
                                            <th>Pickup Address</th>
                                            <th class="text-end" style="width:220px;">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($foods as $food)
                                        @php
                                            $req = $requestedMap[$food->id] ?? null; // PickupRequest or null
                                            $blocked = $req !== null;
                                            $status = $req->status ?? null;

                                            $tagClass = match($status){
                                                'pending' => 'tag tag-pending',
                                                'approved' => 'tag tag-approved',
                                                'picked_up' => 'tag tag-picked',
                                                'completed' => 'tag tag-completed',
                                                default => 'tag'
                                            };
                                        @endphp

                                        <tr>
                                            <td class="text-muted">{{ $loop->iteration }}</td>

                                            <td>
                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                    <span class="fw-bold">{{ $food->donor?->name ?? '—' }}</span>

                                                    @if($food->donor)
                                                        <a href="{{ route('ngo.donor.show', $food->donor->id) }}"
                                                           class="btn btn-outline-secondary btn-pill">
                                                            View Profile
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="fw-bold">{{ $food->title }}</td>

                                            <td>{{ $food->quantity }} {{ $food->unit }}</td>

                                            <td class="text-muted" style="font-weight:700;">
                                                {{ $food->pickup_address }}
                                            </td>

                                            <td class="text-end">
                                                @if($blocked)
                                                    <span class="{{ $tagClass }}">
                                                        Requested: {{ strtoupper(str_replace('_',' ', $status)) }}
                                                    </span>
                                                    <button class="btn btn-secondary btn-pill ms-2" disabled>
                                                        Accepted
                                                    </button>
                                                @else
                                                    <form action="{{ route('ngo.food.accept', $food->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-pill">
                                                            Accept
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $foods->links() }}
                            </div>
                        @else
                            <div class="text-muted p-3" style="font-weight:700;">
                                No available food donations right now.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
