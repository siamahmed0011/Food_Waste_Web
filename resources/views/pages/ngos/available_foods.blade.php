@extends('layouts.main')

@section('title', 'Available Food Posts')

@section('content')
<div class="row mt-3">

    <div class="col-md-3">
        @include('pages.ngos._sidebar')
    </div>

    <div class="col-md-9">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3>Available Food Donations</h3>
                <small class="text-muted">Choose any donation to accept.</small>
                <hr>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($foods->count())
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Donor</th>
                                <th>Title</th>
                                <th>Qty</th>
                                <th>Pickup Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($foods as $food)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $food->donor->name }}</td>

                                    {{-- ✅ Title (no route error) --}}
                                    <td>{{ $food->title }}</td>

                                    <td>{{ $food->quantity }} {{ $food->unit }}</td>
                                    <td>{{ $food->pickup_address }}</td>

                                    {{-- ✅ Safe disabled button (no route yet) --}}
                                    <td>
                                       <form action="{{ route('ngo.food.accept', $food->id) }}" method="POST">
                                            @csrf
                                         <button type="submit" class="btn btn-success btn-sm">
                                            Accept
                                         </button>
                                       </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <p class="text-muted">No available food donations right now.</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
