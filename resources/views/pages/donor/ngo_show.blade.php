@extends('layouts.app')

@section('title', 'NGO Profile')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center"
             style="width:70px;height:70px;">
            <i class="bi bi-building fs-2 text-success"></i>
        </div>

        <div>
            <h3 class="fw-bold mb-0">
                {{ $ngoUser->organization_name ?? $ngoUser->name }}
            </h3>
            <div class="text-muted">
                Organization Profile
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT: NGO INFO --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <h5 class="fw-semibold mb-3">Organization Details</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="text-muted small">Organization Name</div>
                            <div class="fw-semibold">
                                {{ $ngoUser->organization_name ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Organization Type</div>
                            <div class="fw-semibold">
                                {{ $ngoUser->organization_type ?? 'Not specified' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Email</div>
                            <div class="fw-semibold">
                                {{ $ngoUser->email }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Phone</div>
                            <div class="fw-semibold">
                                {{ $ngoUser->phone ?? '—' }}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="text-muted small">Address</div>
                            <div class="fw-semibold">
                                {{ $ngoUser->address ?? '—' }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-semibold mb-2">About this NGO</h6>
                    <p class="text-muted mb-0">
                        This organization is registered on the Food Waste Platform and participates
                        in collecting surplus food from donors to help reduce food waste.
                    </p>

                </div>
            </div>
        </div>

        {{-- RIGHT: STATS + STATUS --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body text-center">

                    <div class="mb-2">
                        <span class="badge bg-success-subtle text-success px-3 py-2">
                            Verified NGO
                        </span>
                    </div>

                    <div class="text-muted small">
                        Account Status
                    </div>

                    <div class="fw-semibold">
                        {{ ucfirst($ngoUser->status ?? 'Active') }}
                    </div>
                </div>
            </div>

            {{-- Future rating placeholder --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="fw-semibold mb-2">Ratings & Reviews</h6>
                    <div class="text-muted small">
                        Rating system will be available after pickup completion.
                    </div>

                    <div class="mt-2">
                        ⭐ ⭐ ⭐ ⭐ ⭐
                        <div class="small text-muted">(Coming soon)</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Back --}}
    <div class="mt-4">
        <a href="{{ route('donor.pickups.index') }}" class="btn btn-outline-secondary">
            ← Back to Pickup Requests
        </a>
    </div>

</div>
@endsection
