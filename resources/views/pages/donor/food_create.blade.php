@extends('layouts.main')

@php
    // create page a $post nai, edit page a ache
    $isEdit = isset($post) && $post;
@endphp

@section('title', $isEdit ? 'Edit Food Post' : 'Post New Food')

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">

            {{-- Page Header (Professional) --}}
            <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-3">
                <div>
                    <h2 class="mb-1 fw-bold">
                        {{ $isEdit ? 'Edit Food Post' : 'Post New Food' }}
                    </h2>
                    <p class="text-muted mb-0">
                        {{ $isEdit
                            ? 'Update your posted food details so NGOs have accurate information.'
                            : 'Share your surplus food details. Nearby NGOs will be able to request pickup before the food expires.'
                        }}
                    </p>
                </div>

                {{-- Optional: quick back link --}}
                <a href="{{ route('donor.dashboard') }}" class="btn btn-outline-secondary">
                    ← Back
                </a>
            </div>

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm">
                    <div class="fw-semibold mb-1">Please fix the following:</div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ========= FORM START ========= --}}
            <form method="POST"
                  action="{{ $isEdit ? route('donor.food.update', $post->id) : route('donor.food.store') }}"
                  enctype="multipart/form-data"
                  class="card border-0 shadow-sm">

                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                {{-- Card body --}}
                <div class="card-body p-4 p-md-5">

                    {{-- Section: Basic --}}
                    <div class="mb-4">
                        <div class="fw-semibold mb-2">Basic Information</div>
                        <div class="text-muted small">Help NGOs understand what food is available.</div>
                    </div>

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Food Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title', $isEdit ? $post->title : '') }}"
                               placeholder="e.g., Extra Chicken Biryani for 5 people"
                               required>
                    </div>

                    {{-- Category + Quantity + Unit --}}
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Category</label>
                            <input type="text" name="category" class="form-control"
                                   value="{{ old('category', $isEdit ? $post->category : '') }}"
                                   placeholder="e.g., Rice">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Quantity</label>
                            <input type="number" name="quantity" class="form-control"
                                   value="{{ old('quantity', $isEdit ? $post->quantity : '') }}"
                                   min="1" placeholder="e.g., 5">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Unit</label>
                            <input type="text" name="unit" class="form-control"
                                   value="{{ old('unit', $isEdit ? $post->unit : '') }}"
                                   placeholder="plates, boxes, kg">
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Section: Time --}}
                    <div class="mb-4">
                        <div class="fw-semibold mb-2">Time & Pickup Window</div>
                        <div class="text-muted small">Accurate time helps NGOs plan pickup efficiently.</div>
                    </div>

                    {{-- Date fields --}}
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Cooked At</label>
                            <input type="datetime-local" name="cooked_at" class="form-control"
                                   value="{{ old('cooked_at',
                                       ($isEdit && $post->cooked_at)
                                           ? $post->cooked_at->format('Y-m-d\TH:i')
                                           : ''
                                   ) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Best before (expiry)</label>
                            <input type="datetime-local" name="expiry_time" class="form-control"
                                   value="{{ old('expiry_time',
                                       ($isEdit && $post->expiry_time)
                                           ? $post->expiry_time->format('Y-m-d\TH:i')
                                           : ''
                                   ) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pickup Time Range</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="datetime-local" name="pickup_time_from"
                                           class="form-control"
                                           value="{{ old('pickup_time_from',
                                               ($isEdit && $post->pickup_time_from)
                                                   ? $post->pickup_time_from->format('Y-m-d\TH:i')
                                                   : ''
                                           ) }}">
                                </div>
                                <div class="col-6">
                                    <input type="datetime-local" name="pickup_time_to"
                                           class="form-control"
                                           value="{{ old('pickup_time_to',
                                               ($isEdit && $post->pickup_time_to)
                                                   ? $post->pickup_time_to->format('Y-m-d\TH:i')
                                                   : ''
                                           ) }}">
                                </div>
                            </div>
                            <div class="form-text">From → To (preferred window)</div>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Section: Location & Details --}}
                    <div class="mb-4">
                        <div class="fw-semibold mb-2">Location & Notes</div>
                        <div class="text-muted small">Pickup address and extra notes improve success rate.</div>
                    </div>

                    {{-- Pickup address --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Pickup Address
                            <span class="text-muted fw-normal small">(empty = use your saved address)</span>
                        </label>
                        <input type="text" name="pickup_address" class="form-control"
                               placeholder="{{ $user->address ?? 'Your saved address will be used' }}"
                               value="{{ old('pickup_address', $isEdit ? $post->pickup_address : '') }}">
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description / Notes</label>
                        <textarea name="description" rows="4" class="form-control"
                                  placeholder="Any additional notes (e.g., spicy, contains allergens, packed in boxes...)">{{ old('description', $isEdit ? $post->description : '') }}</textarea>
                    </div>

                    {{-- Image --}}
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Food Image (optional)</label>
                        <input type="file" name="image_path" class="form-control">

                        @if($isEdit && $post->image_path)
                            <div class="mt-3 d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $post->image_path) }}"
                                     alt="Food image" width="120" class="rounded-3 shadow-sm">
                                <div class="text-muted small">
                                    Current image shown. Upload a new one to replace it.
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- Card footer --}}
                <div class="card-footer bg-white border-0 p-4 pt-0 p-md-5 pt-md-0">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <a href="{{ route('donor.dashboard') }}" class="btn btn-outline-secondary px-4">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-success px-4">
                            {{ $isEdit ? 'Update Food' : 'Post Food' }}
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
