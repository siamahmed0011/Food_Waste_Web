@extends('layouts.main')

@section('title', 'Food Donation Details')

@section('content')
<div class="row mt-3">

    <div class="col-md-3">
        @include('pages.ngos._sidebar')
    </div>

    <div class="col-md-9">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <h3 class="mb-3">{{ $food->title }}</h3>
                <small class="text-muted">Full details of this food donation</small>
                <hr>

                {{-- Success / Error Messages --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row">

                    {{-- Food Information --}}
                    <div class="col-md-7">
                        <h5>Food Information</h5>
                        <ul class="list-unstyled">

                            <li><strong>Category:</strong> {{ $food->category ?? '-' }}</li>

                            <li><strong>Quantity:</strong>
                                {{ $food->quantity }} {{ $food->unit }}
                            </li>

                            <li><strong>Status:</strong>
                                <span class="badge bg-info text-dark">
                                    {{ ucfirst($food->status) }}
                                </span>
                            </li>

                            <li><strong>Cooked at:</strong>
                                {{ optional($food->cooked_at)->format('d M Y, h:i A') ?? '-' }}
                            </li>

                            <li><strong>Expires at:</strong>
                                {{ optional($food->expiry_time)->format('d M Y, h:i A') ?? '-' }}
                            </li>

                            <li><strong>Pickup Window:</strong>
                                {{ optional($food->pickup_time_from)->format('d M Y, h:i A') ?? '-' }}
                                @if($food->pickup_time_to)
                                    – {{ $food->pickup_time_to->format('d M Y, h:i A') }}
                                @endif
                            </li>

                            <li><strong>Pickup Address:</strong> {{ $food->pickup_address }}</li>
                        </ul>

                        @if($food->description)
                            <h6>Description</h6>
                            <p>{{ $food->description }}</p>
                        @endif
                    </div>

                    {{-- ✅ Donor Information (fixed) --}}
                    <div class="col-md-5">
                        <h5>Donor Information</h5>

                        <ul class="list-unstyled">
                            <li><strong>Name:</strong> {{ $food->donor->name ?? '-' }}</li>
                            <li><strong>Email:</strong> {{ $food->donor->email ?? '-' }}</li>
                            <li><strong>Phone:</strong> {{ $food->donor->phone ?? '-' }}</li>
                            <li><strong>Address:</strong> {{ $food->donor->address ?? '-' }}</li>
                        </ul>

                        @if($food->image_path)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $food->image_path) }}"
                                     class="img-fluid rounded"
                                     alt="Food Image">
                            </div>
                        @endif
                    </div>
                </div>

                <hr>

                {{-- Accept Button --}}
                @if($food->status === 'available')
                    <form action="{{ route('ngo.food.accept', $food->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg">
                            Accept This Donation
                        </button>
                    </form>
                @else
                    <span class="badge bg-secondary">
                        This food has already been {{ $food->status }}.
                    </span>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
