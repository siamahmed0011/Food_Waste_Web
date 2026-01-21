@extends('layouts.main')

@section('title','Organization Registration')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="row g-0 shadow rounded overflow-hidden">
                {{-- Left side info --}}
                <div class="col-md-4 bg-dark text-white d-flex align-items-center p-4">
                    <div>
                        <h3 class="mb-3">Join as Organization</h3>
                        <p>
                            Register your NGO or food bank to receive verified
                            surplus food from donors in your area.
                        </p>
                        <ul class="small">
                            <li>View nearby food donations</li>
                            <li>Send pickup requests</li>
                            <li>Maintain donation history</li>
                        </ul>
                    </div>
                </div>

                {{-- Right side form --}}
                <div class="col-md-8 bg-white p-4">
                    <h3 class="mb-4">Organization Registration</h3>

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
                        <input type="hidden" name="role" value="organization">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Organization Name</label>
                                <input type="text" name="organization_name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Owner Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Organization Type / ID</label>
                                <input type="text" name="organization_type" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <button class="btn btn-primary w-100 mt-2">Register Organization</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection