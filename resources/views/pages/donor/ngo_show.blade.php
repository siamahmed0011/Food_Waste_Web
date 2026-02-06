@extends('layouts.app')

@section('title', 'NGO Details')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="mb-1 fw-bold">NGO Details</h3>
            <div class="text-muted">Organization profile information</div>
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            ← Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="text-muted small">Organization Name</div>
                    <div class="fw-semibold">
                        {{ $ngoUser->organization_name ?? $ngoUser->name ?? '—' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Email</div>
                    <div class="fw-semibold">{{ $ngoUser->email ?? '—' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Phone</div>
                    <div class="fw-semibold">{{ $ngoUser->phone ?? '—' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Address</div>
                    <div class="fw-semibold">{{ $ngoUser->address ?? '—' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Organization Type</div>
                    <div class="fw-semibold">
                        {{ $ngoUser->organization_type ?? '—' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Location</div>
                    <div class="fw-semibold">
                        @if($ngoUser->latitude && $ngoUser->longitude)
                            {{ $ngoUser->latitude }}, {{ $ngoUser->longitude }}
                        @else
                            —
                        @endif
                    </div>
                </div>
            </div>

            <hr>

            <div class="text-muted small">
                This NGO profile is visible to donors for transparency and trust.
                <br>
                <em>(Next phase: rating, reviews, verification badge)</em>
            </div>

        </div>
    </div>
</div>
@endsection
