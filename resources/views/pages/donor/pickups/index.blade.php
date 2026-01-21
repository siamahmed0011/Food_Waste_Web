@extends('layouts.main')

@section('title', 'My Pickup Requests')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">My Pickup Requests</h4>
        <a href="{{ route('donor.pickups.create') }}" class="btn btn-primary">
            + New Pickup Request
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            {{-- FRONTEND DUMMY TABLE – later real data asbe --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Food</th>
                            <th>Quantity</th>
                            <th>Pickup Time</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Example static row (just for UI preview) --}}
                        <tr>
                            <td>1</td>
                            <td>Biriyani</td>
                            <td>20 plates</td>
                            <td>2025-12-05 08:00 PM</td>
                            <td>
                                <span class="badge bg-warning text-dark">Pending</span>
                            </td>
                            <td>2025-12-03</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                    View
                                </button>
                            </td>
                        </tr>

                        {{-- Later: @foreach($pickups as $pickup) ... @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
