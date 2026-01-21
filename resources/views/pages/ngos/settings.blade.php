@extends('layouts.main')

@section('title', 'NGO Settings')

@section('content')
<div class="row mt-3">
    {{-- LEFT SIDEBAR --}}
    <div class="col-md-3 mb-3 mb-md-0">
        @include('pages.ngos._sidebar')
    </div>

    {{-- MAIN CONTENT --}}
    <div class="col-md-9">
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-body">
                @php
                    $user = auth()->user();
                    $ngo  = \App\Models\Ngo::where('email', $user->email)->first();
                @endphp

                <h3 class="mb-1">Account Settings</h3>
                <small class="text-muted">Update your NGO account details.</small>
                <hr>

                {{-- SUCCESS MESSAGE --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- VALIDATION ERRORS --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- SETTINGS FORM --}}
                <form action="{{ route('ngo.settings.update') }}" method="POST">
                    @csrf

                    {{-- ORG NAME + TYPE --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Organization Name</label>
                            <input type="text" name="organization_name" class="form-control"
                                   value="{{ old('organization_name', $user->organization_name ?? $user->name) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Organization Type</label>
                            <input type="text" name="organization_type" class="form-control"
                                   value="{{ old('organization_type', $user->organization_type) }}">
                        </div>
                    </div>

                    {{-- EMAIL + PHONE --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            <small class="text-muted">Email cannot be changed from here.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>

                    {{-- ADDRESS --}}
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                    </div>

                    {{-- LATITUDE + LONGITUDE --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" class="form-control"
                                   value="{{ old('latitude', optional($ngo)->latitude) }}"
                                   placeholder="e.g. 23.8103">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" class="form-control"
                                   value="{{ old('longitude', optional($ngo)->longitude) }}"
                                   placeholder="e.g. 90.4125">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
