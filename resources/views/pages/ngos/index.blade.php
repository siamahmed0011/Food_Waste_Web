@extends('layouts.app')

@section('title', 'NGO Dashboard')

@section('content')
<div class="container py-4">

    <div class="row g-4">
        {{-- Sidebar --}}
        <div class="col-12 col-lg-3">
            @include('pages.ngos._sidebar')
        </div>

        {{-- Main --}}
        <div class="col-12 col-lg-9">

            {{-- Header --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
                <div>
                    <h3 class="mb-1 fw-bold">NGO Dashboard</h3>
                    <div class="text-muted">Overview of your pickup requests & activity.</div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('ngo.available_foods') }}" class="btn btn-primary">
                        Browse Available Foods
                    </a>
                    <a href="{{ route('ngo.orders') }}" class="btn btn-outline-secondary">
                        My Requests
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-muted small">Total Requests</div>
                            <div class="fs-3 fw-bold">{{ $stats['total_pickups'] ?? 0 }}</div>
                            <div class="text-muted small mt-1">All pickup requests you made</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-muted small">Pending</div>
                            <div class="fs-3 fw-bold">{{ $stats['pending_requests'] ?? 0 }}</div>
                            <div class="small mt-1">
                                @if(($stats['pending_requests'] ?? 0) > 0)
                                    <span class="text-warning fw-semibold">Waiting for donor approval</span>
                                @else
                                    <span class="text-muted">No pending requests</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-muted small">Completed</div>
                            <div class="fs-3 fw-bold">{{ $stats['completed_pickups'] ?? 0 }}</div>
                            <div class="text-muted small mt-1">Completed pickups history</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Activity (professional) --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <h5 class="mb-0 fw-bold">Recent Requests</h5>
                            <div class="text-muted small">Latest pickup requests you created</div>
                        </div>
                        <a href="{{ route('ngo.orders') }}" class="btn btn-outline-secondary btn-sm">View all</a>
                    </div>

                    {{-- If you don't have recent list passed yet, show empty state --}}
                    @isset($recentRequests)
                        @if($recentRequests->count() === 0)
                            <div class="text-center py-4 text-muted">
                                No requests yet. Browse foods to request a pickup.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Food</th>
                                            <th>Donor</th>
                                            <th>Status</th>
                                            <th class="text-end">Requested</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentRequests as $r)
                                            @php
                                                $badge = match($r->status) {
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
                                                <td class="fw-semibold">{{ $r->foodPost?->title ?? '—' }}</td>
                                                <td class="text-muted">{{ $r->donor?->name ?? '—' }}</td>
                                                <td><span class="badge bg-{{ $badge }}">{{ strtoupper($r->status) }}</span></td>
                                                <td class="text-end text-muted small">{{ $r->created_at?->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @else
                        <div class="text-muted small">
                            (Optional) Recent requests section will show once we pass $recentRequests from controller.
                        </div>
                    @endisset
                </div>
            </div>

            <div class="mt-3 small text-muted">
                Tip: Keep your phone/address updated so donors can coordinate pickup smoothly.
            </div>

        </div>
    </div>
</div>
@endsection
