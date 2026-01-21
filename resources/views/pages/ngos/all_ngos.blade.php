@extends('layouts.main')

@section('title', 'All NGOs')

@section('content')
<div class="row mt-3">
    <div class="col-md-3 mb-3 mb-md-0">
        @include('pages.ngos._sidebar')
    </div>

    <div class="col-md-9">
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-body">

                <h3 class="mb-1">All Registered NGOs</h3>
                <small class="text-muted">View all organizations using this platform.</small>
                <hr>

                @if($ngos->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Status</th>
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
                    <p class="mb-0 text-muted">No NGOs registered yet.</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
