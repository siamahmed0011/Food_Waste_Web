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

            <h2 class="mb-3">
                {{ $isEdit ? 'Edit Food Post' : 'Post New Food' }}
            </h2>

            <p class="text-muted mb-4">
                {{ $isEdit
                    ? 'Update your posted food details so NGOs have accurate information.'
                    : 'Share your surplus food details. Nearby NGOs will be able to request pickup before the food expires.'
                }}
            </p>

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
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
                  class="card shadow-sm border-0 p-4">

                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                {{-- Title --}}
                <div class="mb-3">
                    <label class="form-label">Food Title *</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $isEdit ? $post->title : '') }}" required>
                </div>

                {{-- Category + Quantity + Unit --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control"
                               value="{{ old('category', $isEdit ? $post->category : '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control"
                               value="{{ old('quantity', $isEdit ? $post->quantity : '') }}" min="1">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Unit</label>
                        <input type="text" name="unit" class="form-control"
                               value="{{ old('unit', $isEdit ? $post->unit : '') }}"
                               placeholder="plates, boxes, kg">
                    </div>
                </div>

                {{-- Date fields --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cooked At</label>
                        <input type="datetime-local" name="cooked_at" class="form-control"
                               value="{{ old('cooked_at',
                                   ($isEdit && $post->cooked_at)
                                       ? $post->cooked_at->format('Y-m-d\TH:i')
                                       : ''
                               ) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Best before (expiry)</label>
                        <input type="datetime-local" name="expiry_time" class="form-control"
                               value="{{ old('expiry_time',
                                   ($isEdit && $post->expiry_time)
                                       ? $post->expiry_time->format('Y-m-d\TH:i')
                                       : ''
                               ) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pickup Time Range</label>
                        <div class="d-flex gap-1">
                            <input type="datetime-local" name="pickup_time_from"
                                   class="form-control"
                                   value="{{ old('pickup_time_from',
                                       ($isEdit && $post->pickup_time_from)
                                           ? $post->pickup_time_from->format('Y-m-d\TH:i')
                                           : ''
                                   ) }}">

                            <input type="datetime-local" name="pickup_time_to"
                                   class="form-control"
                                   value="{{ old('pickup_time_to',
                                       ($isEdit && $post->pickup_time_to)
                                           ? $post->pickup_time_to->format('Y-m-d\TH:i')
                                           : ''
                                   ) }}">
                        </div>
                    </div>
                </div>

                {{-- Pickup address --}}
                <div class="mb-3">
                    <label class="form-label">
                        Pickup Address
                        <span class="text-muted small">(empty = use your saved address)</span>
                    </label>
                    <input type="text" name="pickup_address" class="form-control"
                           placeholder="{{ $user->address ?? 'Your saved address will be used' }}"
                           value="{{ old('pickup_address', $isEdit ? $post->pickup_address : '') }}">
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label">Description / Notes</label>
                    <textarea name="description" rows="3" class="form-control">
                        {{ old('description', $isEdit ? $post->description : '') }}
                    </textarea>
                </div>

                {{-- Image --}}
                <div class="mb-4">
                    <label class="form-label">Food Image (optional)</label>
                    <input type="file" name="image_path" class="form-control">

                    @if($isEdit && $post->image_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $post->image_path) }}"
                                 alt="Food image" width="120" class="rounded shadow">
                        </div>
                    @endif
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('donor.dashboard') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-success">
                        {{ $isEdit ? 'Update Food' : 'Post Food' }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
