@extends('layouts.main')

@section('title', 'NGO Dashboard')

@section('content')
<div class="row mt-3">
    {{-- LEFT SIDEBAR --}}
    <div class="col-md-3 mb-3 mb-md-0">
        @include('pages.ngos._sidebar')
    </div>

    {{-- MAIN CONTENT --}}
    <div class="col-md-9">
        <div class="card shadow-sm border-0 dashboard-card mb-4">
            <div class="card-body pb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">
                            Welcome, {{ auth()->user()->organization_name ?? auth()->user()->name }}
                        </h3>
                        <small class="text-muted">Here is an overview of your NGO activity.</small>
                    </div>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('ngos.create') }}" class="btn btn-primary btn-sm">
                            + Add New NGO
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- FLASH MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card stat-card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Total Pickups</p>
                                <h4 class="mb-0 fw-bold">{{ $stats['total_pickups'] }}</h4>
                                <small class="text-success">+3 this week</small>
                            </div>
                            <div class="display-6 text-primary">
                                <i class="bi bi-truck"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Pending Requests</p>
                                <h4 class="mb-0 fw-bold">{{ $stats['pending_requests'] }}</h4>
                                <small class="text-warning">Action needed</small>
                            </div>
                            <div class="display-6 text-warning">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Completed Pickups</p>
                                <h4 class="mb-0 fw-bold">{{ $stats['completed_pickups'] }}</h4>
                                <small class="text-muted">Great job! 🎉</small>
                            </div>
                            <div class="display-6 text-success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- NGO TABLE --}}
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">
                    <i class="bi bi-building me-1"></i> Your NGO Information
                </span>

                <div class="input-group input-group-sm" style="width: 230px;">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search in table..." disabled>
                </div>
            </div>

            <div class="card-body p-0">
                @if($ngos->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th style="width: 120px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ngos as $ngo)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ngo->name }}</td>
                                        <td>{{ $ngo->email }}</td>
                                        <td>{{ $ngo->phone ?? '-' }}</td>
                                        <td>{{ $ngo->address ?? '-' }}</td>
                                        <td>
                                            @if($ngo->status === 'approved')
                                                <span class="badge bg-success rounded-pill">Approved</span>
                                            @elseif($ngo->status === 'pending')
                                                <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                                            @else
                                                <span class="badge bg-danger rounded-pill">Rejected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4">
                        <p class="mb-0 text-muted">No NGO found for this account.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
