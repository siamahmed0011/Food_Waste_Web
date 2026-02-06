@extends('layouts.app')

@section('title', 'My Requests')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        {{-- Sidebar --}}
        <div class="col-12 col-lg-3">
            @include('pages.ngos._sidebar')
        </div>

        {{-- Main --}}
        <div class="col-12 col-lg-9">

            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
                <div>
                    <h3 class="mb-1 fw-bold">My Requests</h3>
                    <div class="text-muted">Track your pickup requests and their status.</div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('ngo.available_foods') }}" class="btn btn-primary">
                        Request New Pickup
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Filters --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('ngo.orders') }}"
                           class="btn btn-sm {{ empty($status) ? 'btn-dark' : 'btn-outline-dark' }}">
                            All
                        </a>

                        @php
                            $filters = ['pending','approved','picked_up','completed','rejected','cancelled'];
                        @endphp

                        @foreach($filters as $f)
                            <a href="{{ route('ngo.orders', ['status' => $f]) }}"
                               class="btn btn-sm {{ ($status === $f) ? 'btn-dark' : 'btn-outline-dark' }}">
                                {{ strtoupper(str_replace('_',' ', $f)) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Orders table --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    @if($orders->count() === 0)
                        <div class="text-center py-5">
                            <h5 class="mb-2">No requests found</h5>
                            <div class="text-muted mb-3">
                                @if($status)
                                    No requests in <b>{{ strtoupper(str_replace('_',' ', $status)) }}</b> status.
                                @else
                                    You haven’t requested any pickup yet.
                                @endif
                            </div>
                            <a href="{{ route('ngo.available_foods') }}" class="btn btn-primary">
                                Browse Available Foods
                            </a>
                        </div>
                    @else

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
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
                                            $badge = match($o->status) {
                                                'pending'   => 'warning',
                                                'approved'  => 'primary',
                                                'picked_up' => 'dark',
                                                'completed' => 'success',
                                                'rejected'  => 'danger',
                                                'cancelled' => 'secondary',
                                                default     => 'secondary'
                                            };
                                        @endphp

                                        <tr>
                                            <td class="text-muted">{{ $orders->firstItem() + $i }}</td>

                                            <td>
                                                <div class="fw-semibold">{{ $o->foodPost?->title ?? '—' }}</div>
                                                <div class="text-muted small">
                                                    Qty:
                                                    @if($o->foodPost)
                                                        {{ $o->foodPost->quantity }} {{ $o->foodPost->unit }}
                                                    @else
                                                        —
                                                    @endif
                                                    • Address: {{ $o->foodPost?->pickup_address ?? '—' }}
                                                </div>
                                            </td>

                                            <td>
                                                <div class="fw-semibold">{{ $o->donor?->name ?? '—' }}</div>
                                                <div class="text-muted small">{{ $o->donor?->phone ?? '—' }}</div>
                                            </td>

                                            <td class="text-muted small">
                                                {{ $o->pickup_time_from?->format('d M Y, h:i A') ?? '—' }}
                                                →
                                                {{ $o->pickup_time_to?->format('d M Y, h:i A') ?? '—' }}

                                                @if($o->final_pickup_at)
                                                    <div class="mt-1">
                                                        <span class="badge bg-info text-dark">
                                                            Final: {{ $o->final_pickup_at->format('d M Y, h:i A') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="badge bg-{{ $badge }}">{{ strtoupper($o->status) }}</span>
                                            </td>

                                            <td class="text-end">
                                                @if($o->status === 'pending')
                                                    <form action="{{ route('ngo.orders.cancel', $o->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Cancel this request?')">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @elseif($o->status === 'approved')
                                                    <span class="text-muted small">Waiting for pickup</span>
                                                @elseif($o->status === 'picked_up')
                                                    <span class="text-muted small">Picked up</span>
                                                @elseif($o->status === 'completed')
                                                    <span class="text-muted small">Completed</span>
                                                @elseif($o->status === 'rejected')
                                                    <span class="text-danger small">Rejected</span>
                                                @elseif($o->status === 'cancelled')
                                                    <span class="text-muted small">Cancelled</span>
                                                @else
                                                    <span class="text-muted small">—</span>
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
@endsection
