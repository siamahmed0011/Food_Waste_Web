@extends('layouts.main')

@section('title', 'Edit Profile')

@push('styles')
<style>
    .edit-wrap{ padding: 14px 0; }

    .edit-hero{
        background: linear-gradient(135deg, rgba(34,197,94,.16), rgba(6,182,212,.14));
        border: 1px solid rgba(15,23,42,.06);
        border-radius: 16px;
        padding: 16px 18px;
    }
    .edit-title{ margin:0; font-weight:900; font-size:26px; line-height:1.15; }
    .edit-sub{ margin:8px 0 0; color:#475569; font-weight:600; }

    .edit-card{
        background:#fff;
        border-radius:16px;
        padding:18px;
        box-shadow:0 12px 30px rgba(15,23,42,.06);
        border:1px solid rgba(15,23,42,.06);
        margin-top:14px;
    }

    .edit-label{
        font-weight:800;
        color:#0f766e;
        font-size:.92rem;
        margin-bottom:.35rem;
    }

    .help-text{
        font-size:.82rem;
        color:#64748b;
        font-weight:600;
        margin-top:.35rem;
    }

    .img-preview{
        width:72px;height:72px;border-radius:14px;
        object-fit:cover;
        border:1px solid rgba(15,23,42,.08);
        box-shadow:0 10px 22px rgba(15,23,42,.06);
    }
</style>
@endpush

@section('content')
<div class="edit-wrap">
    <div class="panel-layout">
        <aside class="panel-left">
            @include('pages.donor.sidebar')
        </aside>

        <section class="panel-right">

            {{-- Header --}}
            <div class="edit-hero">
                <h2 class="edit-title">Edit Profile</h2>
                <p class="edit-sub">Update your contact details and pickup preferences.</p>
            </div>

            {{-- Form card --}}
            <div class="edit-card">
                <form action="{{ route('donor.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">

                        {{-- Full Name --}}
                        <div class="col-md-6">
                            <label class="edit-label">Full Name *</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <label class="edit-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}">
                        </div>

                        {{-- Donor Type --}}
                        <div class="col-md-6">
                            <label class="edit-label">Donor Type</label>
                            <select name="donor_type" class="form-select">
                                <option value="">Select type</option>
                                <option value="individual" {{ old('donor_type', $user->donor_type ?? '')=='individual'?'selected':'' }}>Individual</option>
                                <option value="restaurant" {{ old('donor_type', $user->donor_type ?? '')=='restaurant'?'selected':'' }}>Restaurant</option>
                                <option value="hotel" {{ old('donor_type', $user->donor_type ?? '')=='hotel'?'selected':'' }}>Hotel</option>
                                <option value="grocery" {{ old('donor_type', $user->donor_type ?? '')=='grocery'?'selected':'' }}>Grocery</option>
                                <option value="caterer" {{ old('donor_type', $user->donor_type ?? '')=='caterer'?'selected':'' }}>Caterer</option>
                                <option value="event" {{ old('donor_type', $user->donor_type ?? '')=='event'?'selected':'' }}>Event</option>
                                <option value="other" {{ old('donor_type', $user->donor_type ?? '')=='other'?'selected':'' }}>Other</option>
                            </select>
                        </div>

                        {{-- Organization --}}
                        <div class="col-md-6">
                            <label class="edit-label">Organization / Business Name (optional)</label>
                            <input type="text" name="organization_name" class="form-control"
                                   value="{{ old('organization_name', $user->organization_name ?? '') }}"
                                   placeholder="e.g., Green Leaf Restaurant">
                        </div>

                        {{-- Preferred Pickup Time --}}
                        <div class="col-md-6">
                            <label class="edit-label">Preferred Pickup Time</label>
                            <select name="pickup_time" class="form-select">
                                <option value="">Select time window</option>
                                <option value="morning" {{ old('pickup_time', $user->pickup_time ?? '')=='morning'?'selected':'' }}>Morning (9am - 12pm)</option>
                                <option value="afternoon" {{ old('pickup_time', $user->pickup_time ?? '')=='afternoon'?'selected':'' }}>Afternoon (12pm - 4pm)</option>
                                <option value="evening" {{ old('pickup_time', $user->pickup_time ?? '')=='evening'?'selected':'' }}>Evening (4pm - 8pm)</option>
                            </select>
                        </div>

                        {{-- Alternative Phone --}}
                        <div class="col-md-6">
                            <label class="edit-label">Alternative Phone (optional)</label>
                            <input type="text" name="alt_phone" class="form-control"
                                   value="{{ old('alt_phone', $user->alt_phone ?? '') }}"
                                   placeholder="Backup contact number">
                        </div>

                        {{-- Pickup Address (full width) --}}
                        <div class="col-12">
                            <label class="edit-label">Pickup Address (recommended)</label>
                            <textarea name="pickup_address" class="form-control" rows="2"
                                      placeholder="Exact pickup location">{{ old('pickup_address', $user->pickup_address ?? '') }}</textarea>
                            <div class="help-text">Tip: Add floor, gate, landmark to help NGO pickup quickly.</div>
                        </div>

                        {{-- Pickup Notes (full width) --}}
                        <div class="col-12">
                            <label class="edit-label">Pickup Notes (optional)</label>
                            <textarea name="pickup_notes" class="form-control" rows="2"
                                      placeholder="Gate no, floor, call before coming...">{{ old('pickup_notes', $user->pickup_notes ?? '') }}</textarea>
                        </div>

                        {{-- General Address (full width) --}}
                        <div class="col-12">
                            <label class="edit-label">Address (optional)</label>
                            <input type="text" name="address" class="form-control"
                                   value="{{ old('address', $user->address) }}"
                                   placeholder="General address (if different from pickup address)">
                        </div>

                        {{-- Profile Image (full width) --}}
                        <div class="col-12">
                            <label class="edit-label">Profile Image</label>
                            <input type="file" name="image" class="form-control">

                            @if($user->image)
                                <div class="mt-2 d-flex align-items-center gap-2">
                                    <img src="{{ asset('storage/'.$user->image) }}" class="img-preview" alt="Profile">
                                    <div class="help-text">Current photo</div>
                                </div>
                            @endif
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('donor.profile') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>

        </section>
    </div>
</div>
@endsection
