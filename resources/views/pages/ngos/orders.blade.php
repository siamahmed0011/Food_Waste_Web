@extends('layouts.main')

@section('title', 'NGO Orders')

@section('content')
<div class="row mt-3">
    <div class="col-md-3 mb-3 mb-md-0">
        @include('pages.ngos._sidebar')
    </div>

    <div class="col-md-9">
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-body">
                <h3 class="mb-1">Pickup Orders</h3>
                <small class="text-muted">All pickup requests assigned to your NGO.</small>
                <hr>

                @if(session('success'))
                    <div class="alert alert-success py-2">{{ session('success') }}</div>
                @endif

                @if($orders->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Donor</th>
                                    <th>Food Title</th>
                                    <th>Pickup Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->donor_name ?? '-' }}</td>
                                        <td>{{ $order->food_title ?? '-' }}</td>
                                        <td>{{ $order->pickup_time ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-secondary text-capitalize">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="mb-0 text-muted">No orders found for your NGO yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
