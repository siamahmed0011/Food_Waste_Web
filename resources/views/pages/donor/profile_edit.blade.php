@extends('layouts.main')

@section('title', 'Edit Profile')

@push('styles')
<style>
.edit-card {
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

    <h2 class="mb-3">Edit Profile</h2>

    <div class="edit-card">

        <form action="{{ route('donor.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Full Name *</label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control"
                    value="{{ old('phone', $user->phone) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control"
                    value="{{ old('address', $user->address) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Image</label>
                <input type="file" name="image" class="form-control">

                @if($user->image)
                    <img src="{{ asset('storage/'.$user->image) }}"
                         width="100" class="rounded mt-2">
                @endif
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('donor.profile') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>

        </form>

    </div>
</div>

@endsection
