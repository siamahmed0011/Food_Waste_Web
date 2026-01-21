{{-- resources/views/pages/donor/food_show.blade.php --}}
@extends('layouts.main')

@section('title', $post->title . ' - Donation Details')

@php
    use Carbon\Carbon;
@endphp

@section('content')
<style>
    .food-show-wrapper{
        background:#f8fafc;
        min-height:70vh;
        padding-top:2rem;
        padding-bottom:3rem;
    }
    .food-show-card{
        max-width:900px;
        margin:0 auto;
        border-radius:18px;
        border:0;
        box-shadow:0 18px 35px rgba(15,23,42,.16);
        overflow:hidden;
    }
    .food-show-header{
        background:linear-gradient(135deg,#22c55e,#14b8a6);
        color:#fff;
        padding:1.6rem 2rem;
    }
    .food-show-title{
        font-size:clamp(1.4rem,2.4vw,1.8rem);
        font-weight:800;
        margin-bottom:.2rem;
    }
    .food-show-badge{
        display:inline-block;
        padding:.20rem .75rem;
        border-radius:999px;
        font-size:.75rem;
        font-weight:600;
        margin-top:.4rem;
        background:rgba(15,23,42,.15);
    }
    .detail-row{
        padding:1.5rem 2rem 0 2rem;
    }
    .detail-label{
        font-weight:700;
        font-size:.9rem;
        letter-spacing:.06em;
        text-transform:uppercase;
        color:#16a34a;          /* সব label জন্য আলাদা রঙ */
        margin-bottom:.15rem;
    }
    .detail-value{
        font-size:.95rem;
        color:#111827;
    }
    .detail-value-muted{
        color:#6b7280;
        font-size:.9rem;
    }
    .divider-line{
        border-top:1px solid #e5e7eb;
        margin:1.5rem 0;
    }
    .posted-footer{
        background:#f9fafb;
        padding:1rem 2rem 1.3rem 2rem;
        font-size:.85rem;
        color:#6b7280;
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:.75rem;
    }
</style>

<div class="food-show-wrapper">
    <div class="container">

        <div class="card food-show-card">

            {{-- HEADER --}}
            <div class="food-show-header d-flex justify-content-between align-items-start gap-3">
                <div>
                    <div class="food-show-title">
                        {{ $post->title }}
                    </div>

                    @if($post->category)
                        <span class="badge bg-light text-dark small me-2">
                            Category: {{ $post->category }}
                        </span>
                    @endif

                    @php
                        $status = $post->status ?? 'available';
                    @endphp

                    @if($status === 'available')
                        <span class="food-show-badge">Available</span>
                    @elseif($status === 'reserved')
                        <span class="food-show-badge" style="background:rgba(250,204,21,.25);">
                            Reserved
                        </span>
                    @elseif($status === 'completed')
                        <span class="food-show-badge" style="background:rgba(59,130,246,.25);">
                            Completed
                        </span>
                    @else
                        <span class="food-show-badge" style="background:rgba(248,113,113,.25);">
                            {{ ucfirst($status) }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- BODY --}}
            <div class="detail-row">
                <div class="row g-4">
                    {{-- Quantity --}}
                    <div class="col-md-4">
                        <div class="detail-label">Quantity</div>
                        <div class="detail-value">
                            @if($post->quantity)
                                {{ $post->quantity }} {{ $post->unit }}
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    {{-- Cooked at --}}
                    <div class="col-md-4">
                        <div class="detail-label">Cooked at</div>
                        <div class="detail-value">
                            {{ $post->cooked_at
                                ? Carbon::parse($post->cooked_at)->format('d M Y, h:i A')
                                : '—' }}
                        </div>
                    </div>

                    {{-- Best before --}}
                    <div class="col-md-4">
                        <div class="detail-label">Best before</div>
                        <div class="detail-value">
                            {{ $post->expiry_time
                                ? Carbon::parse($post->expiry_time)->format('d M Y, h:i A')
                                : '—' }}
                        </div>
                    </div>
                </div>

                <div class="divider-line"></div>

                {{-- Pickup address --}}
                <div class="mb-3">
                    <div class="detail-label">Pickup address</div>
                    <div class="detail-value">
                        {{ $post->pickup_address ?: '—' }}
                    </div>
                </div>

                {{-- Pickup time range --}}
                <div class="mb-3">
                    <div class="detail-label">Pickup time</div>
                    <div class="detail-value">
                        @if($post->pickup_time_from || $post->pickup_time_to)
                            {{ $post->pickup_time_from
                                ? Carbon::parse($post->pickup_time_from)->format('d M Y, h:i A')
                                : '—' }}
                            –
                            {{ $post->pickup_time_to
                                ? Carbon::parse($post->pickup_time_to)->format('d M Y, h:i A')
                                : '—' }}
                        @else
                            —
                        @endif
                    </div>
                </div>

                {{-- Description / Notes --}}
                <div class="mb-3">
                    <div class="detail-label">Description / notes</div>
                    <div class="detail-value">
                        {{ $post->description ?: '—' }}
                    </div>
                </div>

                {{-- Image থাকলে --}}
                @if($post->image_path)
                    <div class="mb-3">
                        <div class="detail-label">Food image</div>
                        <div class="detail-value">
                            <img src="{{ asset('storage/'.$post->image_path) }}"
                                 alt="Food image"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height:260px;object-fit:cover;">
                        </div>
                    </div>
                @endif
            </div>


    {{-- FOOTER --}}
    <div class="posted-footer">
    <div>
        <strong>Posted at:</strong>
        {{ $post->created_at
            ? $post->created_at->format('d M Y, h:i A')
            : '' }}
        <span class="detail-value-muted ms-1">
            ({{ $post->created_at ? $post->created_at->diffForHumans() : '' }})
        </span>
    </div>

    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="{{ route('donor.donations') }}" class="btn btn-outline-secondary btn-sm">
            ← Back to My Donations
        </a>

        @php $status = $post->status ?? 'available'; @endphp

        {{-- Mark Available --}}
        @if($status !== 'available')
            <form method="POST" action="{{ route('donor.food.updateStatus', $post->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="available">
                <button type="submit" class="btn btn-sm btn-success">
                    Mark as Available
                </button>
            </form>
        @endif

        {{-- Mark Completed --}}
        @if($status !== 'completed')
            <form method="POST" action="{{ route('donor.food.updateStatus', $post->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="completed">
                <button type="submit" class="btn btn-sm btn-primary">
                    Mark as Completed
                </button>
            </form>
        @endif

        {{-- Cancel --}}
        @if($status !== 'cancelled')
            <form method="POST" action="{{ route('donor.food.updateStatus', $post->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    Cancel Post
                </button>
            </form>
        @endif
    </div>
</div>


        </div>
    </div>
</div>
@endsection
