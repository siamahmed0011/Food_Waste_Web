@extends('layouts.main')

@section('title', 'NGO Directory')

{{-- ==================== PAGE SPECIFIC CSS ==================== --}}
@push('styles')
<style>

/* ===== Hero header – donor dashboard banner er moto ===== */
.ngo-header {
    background: linear-gradient(90deg, #16a34a, #06b6d4);
    border-radius: 24px;
    padding: 26px 32px;
    box-shadow: 0 20px 60px rgba(15, 118, 110, 0.25);
    color: #ffffff;
    margin-bottom: 32px;
}

.ngo-header h2 {
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 4px;
    color: #ffffff !important;
    text-shadow: 0 1px 3px rgba(0,0,0,0.25);
}

.ngo-header p {
    margin: 0;
    opacity: 0.9;
    color: #ffffff !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.25);
}

</style>
@endpush


{{-- ==================== PAGE CONTENT ==================== --}}
@section('content')
<div class="container py-4">

    {{-- Header Card --}}
    <div class="ngo-header mb-4">
        <h2 class="fw-bold mb-1 text-success"> NGOs list</h2>
        <p class="mb-0 text-muted">
            You can explore all verified NGOs registered on our platform.
        </p>
    </div>

    {{-- Search + Filter Form --}}
    <form method="GET" action="{{ route('donor.ngos.index') }}" class="row g-3 mb-4 ngo-search">
        <div class="col-md-5">
            <input type="text" name="q" class="form-control"
                   placeholder="Search by NGO name..."
                   value="{{ $search ?? '' }}">
        </div>

        <div class="col-md-5">
            <input type="text" name="area" class="form-control"
                   placeholder="Filter by area..."
                   value="{{ $area ?? '' }}">
        </div>

        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-success">Search</button>
        </div>
    </form>

    {{-- If empty --}}
    @if($ngos->isEmpty())
        <div class="bg-white rounded-4 shadow-sm p-5 text-center">
            <h5 class="fw-bold mb-2">No NGOs Found</h5>
            <p class="text-muted mb-0">Try adjusting your search or filters.</p>
        </div>

    @else
        {{-- NGO Cards --}}
        <div class="row g-4">
            @foreach($ngos as $ngo)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm ngo-card h-100">
                        <div class="card-body d-flex flex-column">

                            {{-- Title + badge --}}
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold mb-0">{{ $ngo->name }}</h5>
                                <span class="badge bg-success text-uppercase small">NGO</span>
                            </div>

                            {{-- Area --}}
                            @if(!empty($ngo->address))
                                <p class="small text-muted mb-1">
                                    <strong>Area:</strong> {{ $ngo->address }}
                                </p>
                            @endif

                            {{-- Email --}}
                            <p class="small text-muted mb-1">
                                <strong>Email:</strong> {{ $ngo->email }}
                            </p>

                            {{-- Phone --}}
                            @if(!empty($ngo->phone))
                                <p class="small text-muted mb-1">
                                    <strong>Phone:</strong> {{ $ngo->phone }}
                                </p>
                            @endif

                            {{-- Registered date --}}
                            <p class="small text-muted mb-3">
                                Registered:
                                {{ $ngo->created_at?->format('d M Y') ?? 'N/A' }}
                            </p>

                            {{-- Bottom badge --}}
                            <div class="mt-auto">
                                <span class="ngo-verified">
                                    ✔ Verified Partner
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $ngos->withQueryString()->links() }}
        </div>

    @endif

</div>
@endsection
