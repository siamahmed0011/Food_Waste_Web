@extends('layouts.app')

@section('title', 'Pickup Requests')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
        <div>
            <h3 class="fw-bold mb-1">Pickup Requests</h3>
            <div class="text-muted">Incoming NGO requests for your food posts.</div>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('donor.pickups.index') }}"
               class="btn btn-sm {{ empty($status) ? 'btn-dark' : 'btn-outline-dark' }}">
                All
            </a>

            @foreach(['pending','approved','picked_up','completed','rejected','cancelled'] as $s)
                <a href="{{ route('donor.pickups.index', ['status' => $s]) }}"
                   class="btn btn-sm {{ ($status === $s) ? 'btn-dark' : 'btn-outline-dark' }}">
                    {{ strtoupper(str_replace('_',' ', $s)) }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Alerts --}}
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
                                <th style="width:60px;">#</th>
                                <th>Food</th>
                                <th>NGO</th>
                                <th>Pickup Window</th>
                                <th style="width:130px;">Status</th>
                                <th class="text-end" style="width:360px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($pickups as $i => $p)
                                @php
                                    $badge = match($p->status) {
                                        'pending'   => 'warning',
                                        'approved'  => 'primary',
                                        'picked_up' => 'info',
                                        'completed' => 'success',
                                        'rejected'  => 'danger',
                                        'cancelled' => 'secondary',
                                        default     => 'secondary'
                                    };

                                    $ngoName = $p->ngo?->organization_name ?? $p->ngo?->name ?? 'NGO';
                                    $ngoPhone = $p->ngo?->phone ?? $p->contact_phone ?? '—';
                                    $ngoEmail = $p->ngo?->email ?? '—';
                                    $ngoAddress = $p->ngo?->address ?? '—';
                                @endphp

                                <tr>
                                    <td class="text-muted">{{ $pickups->firstItem() + $i }}</td>

                                    {{-- Food --}}
                                    <td>
                                        <div class="fw-semibold">{{ $p->foodPost?->title ?? '—' }}</div>
                                        <div class="text-muted small">
                                            Qty: {{ $p->foodPost?->quantity ?? '—' }} {{ $p->foodPost?->unit ?? '' }}
                                            • Address: {{ $p->foodPost?->pickup_address ?? '—' }}
                                        </div>
                                    </td>

                                    {{-- NGO --}}
                                    <td>
                                        <div class="d-flex align-items-start gap-2">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                 style="width:38px;height:38px;">
                                                <i class="bi bi-building text-secondary"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold d-flex align-items-center gap-2">
                                                    {{ $ngoName }}
                                                    <a href="{{ route('donor.ngo.show', $p->ngo?->id) }}"
                                                       class="btn btn-sm btn-outline-secondary py-0 px-2"
                                                       style="font-size:.78rem;">
                                                        View Profile
                                                    </a>
                                                </div>

                                                <div class="text-muted small">
                                                    <span class="me-2"><i class="bi bi-telephone"></i> {{ $ngoPhone }}</span>
                                                    <span><i class="bi bi-envelope"></i> {{ $ngoEmail }}</span>
                                                </div>

                                                <div class="text-muted small">
                                                    <i class="bi bi-geo-alt"></i> {{ $ngoAddress }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Window --}}
                                    <td class="text-muted small">
                                        {{ $p->pickup_time_from?->format('d M Y, h:i A') ?? '—' }}
                                        →
                                        {{ $p->pickup_time_to?->format('d M Y, h:i A') ?? '—' }}

                                        @if($p->final_pickup_at)
                                            <div class="mt-1">
                                                <span class="badge bg-dark-subtle text-dark">
                                                    Final: {{ $p->final_pickup_at->format('d M Y, h:i A') }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        <span class="badge bg-{{ $badge }} text-uppercase">
                                            {{ str_replace('_',' ', $p->status) }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-end">

                                        {{-- Pending => Approve/Reject --}}
                                        @if($p->status === 'pending')

                                            <div class="d-flex justify-content-end flex-wrap gap-2">

                                                <form action="{{ route('donor.pickups.approve', $p->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="text-muted small d-none d-md-block">Final time (optional)</div>
                                                        <input type="datetime-local"
                                                               name="final_pickup_at"
                                                               class="form-control form-control-sm"
                                                               style="width: 190px;">
                                                        <button class="btn btn-sm btn-primary">
                                                            Approve
                                                        </button>
                                                    </div>
                                                </form>

                                                <form action="{{ route('donor.pickups.reject', $p->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="reason" id="reject_reason_{{ $p->id }}" value="Rejected by donor">
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="
                                                                const r = prompt('Reject reason (optional):', 'Not available / timing issue');
                                                                if(r !== null) document.getElementById('reject_reason_{{ $p->id }}').value = r || 'Rejected by donor';
                                                                if(confirm('Reject this request?')) this.closest('form').submit();
                                                            ">
                                                        Reject
                                                    </button>
                                                </form>

                                            </div>

                                        {{-- Approved => Picked up + Complete --}}
                                        @elseif($p->status === 'approved')

                                            <div class="d-flex justify-content-end flex-wrap gap-2">
                                                <form action="{{ route('donor.pickups.pickedup', $p->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-dark">
                                                        Mark Picked Up
                                                    </button>
                                                </form>

                                                <form action="{{ route('donor.pickups.complete', $p->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm btn-success">
                                                        Complete
                                                    </button>
                                                </form>
                                            </div>

                                        {{-- Picked up => Complete --}}
                                        @elseif($p->status === 'picked_up')

                                            <form action="{{ route('donor.pickups.complete', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success">
                                                    Complete
                                                </button>
                                            </form>

                                        {{-- Others => No action --}}
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
