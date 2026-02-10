@extends('layouts.app')

@section('title', 'Donor Profile')

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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h3 class="fw-bold mb-0">Donor Profile</h3>
                    <div class="text-muted">View donor information & contact details</div>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                    ← Back
                </a>
            </div>

            {{-- Profile Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <div class="row g-4 align-items-center">

                        {{-- Avatar --}}
                        <div class="col-md-3 text-center">
                            <img
                                src="{{ $donorUser->image ? asset('storage/'.$donorUser->image) : asset('images/default-user.png') }}"
                                class="rounded-circle mb-2"
                                width="120"
                                height="120"
                                style="object-fit: cover"
                            >
                            <div class="fw-semibold">{{ $donorUser->name }}</div>
                            <span class="badge bg-success mt-1">Donor</span>
                        </div>

                        {{-- Info --}}
                        <div class="col-md-9">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <div class="text-muted small">Email</div>
                                    <div class="fw-semibold">{{ $donorUser->email }}</div>
                                </div>

                                <div class="col-md-6">
                                    <div class="text-muted small">Phone</div>
                                    <div class="fw-semibold">{{ $donorUser->phone ?? '—' }}</div>
                                </div>

                                <div class="col-md-12">
                                    <div class="text-muted small">Address</div>
                                    <div class="fw-semibold">{{ $donorUser->address ?? '—' }}</div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- Extra Stats --}}
            <div class="row g-3 mt-3">

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="text-muted small">Total Donations</div>
                            <h4 class="fw-bold mb-0">
                                {{ \App\Models\FoodPost::where('user_id', $donorUser->id)->count() }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="text-muted small">Available Posts</div>
                            <h4 class="fw-bold mb-0">
                                {{ \App\Models\FoodPost::where('user_id', $donorUser->id)->where('status','available')->count() }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="text-muted small">Completed Pickups</div>
                            <h4 class="fw-bold mb-0">
                                {{ \App\Models\PickupRequest::where('donor_user_id',$donorUser->id)->where('status','completed')->count() }}
                            </h4>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection
