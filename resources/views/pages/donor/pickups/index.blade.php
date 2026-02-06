@extends('layouts.app')

@section('title', 'Pickup Requests')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
        <div>
            <h3 class="mb-1 fw-bold">Pickup Requests</h3>
            <div class="text-muted">Incoming NGO requests for your food posts.</div>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('donor.pickups.index') }}" class="btn btn-sm {{ empty($status) ? 'btn-dark' : 'btn-outline-dark' }}">All</a>
            @foreach(['pending','approved','picked_up','completed','rejected','cancelled'] as $s)
                <a href="{{ route('donor.pickups.index', ['status' => $s]) }}"
                   class="btn btn-sm {{ ($status === $s) ? 'btn-dark' : 'btn-outline-dark' }}">
                    {{ strtoupper(str_replace('_',' ', $s)) }}
                </a>
            @endforeach
        </div>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($pickups->count() === 0)
                <div class="text-center py-5">
                    <h5 class="mb-2">No pickup requests found</h5>
                    <div class="text-muted">When an NGO requests your post, it will appear here.</div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Food</th>
                                <th>NGO</th>
                                <th>Window</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pickups as $i => $p)
                                @php
                                    $badge = match($p->status) {
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
                                    <td class="text-muted">{{ $pickups->firstItem() + $i }}</td>

                                    <td>
                                        <div class="fw-semibold">{{ $p->foodPost?->title ?? '—' }}</div>
                                        <div class="text-muted small">
                                            Qty: {{ $p->foodPost?->quantity ?? '—' }} {{ $p->foodPost?->unit ?? '' }}
                                            • Address: {{ $p->foodPost?->pickup_address ?? '—' }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $p->ngo?->organization_name ?? $p->ngo?->name ?? 'NGO' }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ $p->ngo?->phone ?? $p->contact_phone ?? '—' }}
                                        </div>
                                        <div class="mt-1">
                                            {{-- ✅ Donor can view full NGO details --}}
                                            <a href="{{ route('donor.ngo.show', $p->ngo_user_id) }}" class="btn btn-sm btn-outline-secondary">
                                                View NGO
                                            </a>
                                        </div>
                                    </td>

                                    <td class="text-muted small">
                                        {{ $p->pickup_time_from?->format('d M Y, h:i A') ?? '—' }}
                                        →
                                        {{ $p->pickup_time_to?->format('d M Y, h:i A') ?? '—' }}

                                        @if($p->final_pickup_at)
                                            <div class="mt-1">
                                                <span class="badge bg-info text-dark">
                                                    Final: {{ $p->final_pickup_at->format('d M Y, h:i A') }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge bg-{{ $badge }}">{{ strtoupper($p->status) }}</span>
                                    </td>

                                    <td class="text-end">
                                        @if($p->status === 'pending')
                                            {{-- Approve with optional final time --}}
                                            <form action="{{ route('donor.pickups.approve', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="datetime-local" name="final_pickup_at" class="form-control form-control-sm d-inline-block"
                                                       style="width: 190px;" title="Set final pickup time (optional)">
                                                <button class="btn btn-sm btn-primary ms-1">Approve</button>
                                            </form>

                                            <form action="{{ route('donor.pickups.reject', $p->id) }}" method="POST" class="d-inline ms-1">
                                                @csrf
                                                <input type="hidden" name="reason" value="Rejected by donor">
                                                <button class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Reject this request?')">
                                                    Reject
                                                </button>
                                            </form>

                                        @elseif($p->status === 'approved')
                                            <form action="{{ route('donor.pickups.pickedup', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-dark">Mark Picked Up</button>
                                            </form>

                                            <form action="{{ route('donor.pickups.complete', $p->id) }}" method="POST" class="d-inline ms-1">
                                                @csrf
                                                <button class="btn btn-sm btn-success">Complete</button>
                                            </form>

                                        @elseif($p->status === 'picked_up')
                                            <form action="{{ route('donor.pickups.complete', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success">Complete</button>
                                            </form>
                                        @else
                                            <span class="text-muted small">No actions</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $pickups->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
