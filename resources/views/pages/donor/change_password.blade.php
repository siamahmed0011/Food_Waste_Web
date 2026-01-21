@extends('layouts.main')

@section('title', 'Change Password')

@push('styles')
<style>
.password-card {
    background: #fff;
    border-radius: 14px;
    padding: 2rem;
    box-shadow: 0 10px 25px rgba(15,23,42,.08);
}
.form-label {
    font-weight: 600;
    color: #15803d;
}
</style>
@endpush

@section('content')

<div class="container py-4 py-md-5">

    <h2 class="mb-3">Change Password</h2>

    <div class="password-card">

        <form action="{{ route('donor.profile.password.update') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Old Password *</label>
                <input type="password" name="old_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password *</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm New Password *</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('donor.profile') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">Update Password</button>
            </div>

        </form>

    </div>
</div>

@endsection
