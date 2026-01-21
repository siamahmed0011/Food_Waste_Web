@extends('layouts.main')

@section('title', 'Browse NGOs')

@section('content')
<div class="container mt-4">
    <h2 class="mb-2">Partner NGOs</h2>
    <p class="text-muted mb-4">
        These are the approved organizations currently working with our platform.
    </p>

    @if($ngos->count())
        <div class="row g-3">
            @foreach($ngos as $ngo)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-1">{{ $ngo->name }}</h5>
                            <small class="text-muted d-block mb-2">
                                {{ $ngo->address ?? 'Address not provided' }}
                            </small>

                            <p class="mb-1"><strong>Email:</strong> {{ $ngo->email }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $ngo->phone ?? '-' }}</p>

                            <span class="badge bg-success mt-2">Approved NGO</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">No approved NGOs available right now.</p>
    @endif
</div>
@endsection
