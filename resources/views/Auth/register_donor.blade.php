@extends('layouts.main')

@section('title','Donor Registration')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="row g-0 shadow rounded overflow-hidden">
                {{-- Left side: info panel --}}
                <div class="col-md-4 bg-success text-white d-flex align-items-center p-4">
                    <div>
                        <h3 class="mb-3">Become a Donor</h3>
                        <p>
                            Share your surplus food with nearby NGOs and volunteers.
                            Your small contribution can bring a big smile to someone in need.
                        </p>
                        <ul class="small">
                            <li>Safe & quick pickup</li>
                            <li>Location based matching</li>
                            <li>Track your donations</li>
                        </ul>
                    </div>
                </div>

                {{-- Right side: form --}}
                <div class="col-md-8 bg-white p-4">
                    <h3 class="mb-4">Donor Registration</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
                        <input type="hidden" name="role" value="donor">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Donor Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                        
                            <div class="col-md-6 mb-3">
                                <label class="form-label">District</label>
                                <input type="text" name="district" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Road No.</label>
                                <input type="text" name="road_no" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">House No.</label>
                                <input type="text" name="house_no" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <button class="btn btn-success w-100 mt-2">Sign Up as Donor</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

