{{-- resources/views/pages/donor/food_show.blade.php --}}
@extends('layouts.main')

@section('title', ($post->title ?? 'Food') . ' - Donation Details')

@php
    use Carbon\Carbon;
@endphp

@push('styles')
<style>
  .food-show-wrapper{
    background: var(--bg);
    min-height: 70vh;
    padding: 2rem 0 3rem;
  }

  .food-show-card{
    max-width: 920px;
    margin: 0 auto;
    border-radius: 18px;
    border: 1px solid var(--border);
    overflow: hidden;
    box-shadow: 0 18px 35px rgba(15,23,42,.14);
    background: var(--card);
  }

  .food-show-header{
    background: linear-gradient(135deg, var(--primary), #26A69A);
    color: #fff;
    padding: 1.6rem 2rem;
  }

  .food-show-title{
    font-size: clamp(1.6rem, 2.6vw, 2.1rem);
    font-weight: 800;
    margin: 0;
    letter-spacing: .01em;
  }

  .pill{
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .32rem .75rem;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 700;
    margin-top: .55rem;
  }
  .pill-light{
    background: rgba(255,255,255,.18);
    color: #fff;
  }
  .pill-available{ background: rgba(46,125,50,.22); color:#fff; }
  .pill-reserved{ background: rgba(249,168,37,.25); color:#fff; }
  .pill-completed{ background: rgba(59,130,246,.25); color:#fff; }
  .pill-cancelled{ background: rgba(220,38,38,.25); color:#fff; }

  .food-show-body{ padding: 1.6rem 2rem; }

  .detail-label{
    color: var(--muted);
    font-size: 12px;
    letter-spacing: .08em;
    font-weight: 800;
    text-transform: uppercase;
    margin-bottom: .25rem;
  }
  .detail-value{
    color: var(--text);
    font-weight: 600;
    font-size: .98rem;
  }
  .detail-muted{
    color: var(--muted);
    font-size: .88rem;
    font-weight: 500;
  }

  .divider-line{
    border-top: 1px solid var(--border);
    margin: 1.2rem 0;
  }

  .food-img{
    width: 100%;
    max-height: 300px;
    object-fit: cover;
    border-radius: 14px;
    border: 1px solid var(--border);
  }

  .posted-footer{
    background: rgba(17,24,39,.02);
    border-top: 1px solid var(--border);
    padding: 1rem 2rem 1.2rem;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:.75rem;
  }
</style>
@endpush

@section('content')
<div class="food-show-wrapper">
  <div class="container">

    <div class="card food-show-card">

      {{-- HEADER --}}
      <div class="food-show-header d-flex justify-content-between align-items-start gap-3">
        <div>
          <h1 class="food-show-title">{{ $post->title }}</h1>

          <div class="d-flex flex-wrap gap-2">
            @if($post->category)
              <span class="pill pill-light">Category: {{ $post->category }}</span>
            @endif

            @php $status = strtolower($post->status ?? 'available'); @endphp

            @if($status === 'available')
              <span class="pill pill-available">Available</span>
            @elseif($status === 'reserved')
              <span class="pill pill-reserved">Reserved</span>
            @elseif($status === 'completed')
              <span class="pill pill-completed">Completed</span>
            @elseif($status === 'cancelled')
              <span class="pill pill-cancelled">Cancelled</span>
            @else
              <span class="pill pill-light">{{ ucfirst($status) }}</span>
            @endif
          </div>
        </div>
      </div>

      {{-- BODY --}}
      <div class="food-show-body">
        <div class="row g-4">
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

          <div class="col-md-4">
            <div class="detail-label">Cooked at</div>
            <div class="detail-value">
              {{ $post->cooked_at ? Carbon::parse($post->cooked_at)->format('d M Y, h:i A') : '—' }}
            </div>
          </div>

          <div class="col-md-4">
            <div class="detail-label">Best before</div>
            <div class="detail-value">
              {{ $post->expiry_time ? Carbon::parse($post->expiry_time)->format('d M Y, h:i A') : '—' }}
            </div>
          </div>
        </div>

        <div class="divider-line"></div>

        <div class="mb-3">
          <div class="detail-label">Pickup address</div>
          <div class="detail-value">{{ $post->pickup_address ?: '—' }}</div>
        </div>

        <div class="mb-3">
          <div class="detail-label">Pickup time</div>
          <div class="detail-value">
            @if($post->pickup_time_from || $post->pickup_time_to)
              {{ $post->pickup_time_from ? Carbon::parse($post->pickup_time_from)->format('d M Y, h:i A') : '—' }}
              –
              {{ $post->pickup_time_to ? Carbon::parse($post->pickup_time_to)->format('d M Y, h:i A') : '—' }}
            @else
              —
            @endif
          </div>
        </div>

        <div class="mb-3">
          <div class="detail-label">Description / notes</div>
          <div class="detail-value">{{ $post->description ?: '—' }}</div>
        </div>

        @if($post->image_path)
          <div class="mt-3">
            <div class="detail-label">Food image</div>
            <img src="{{ asset('storage/'.$post->image_path) }}" alt="Food image" class="food-img mt-2">
          </div>
        @endif
      </div>

      {{-- FOOTER --}}
      <div class="posted-footer">
        <div>
          <strong>Posted at:</strong>
          {{ $post->created_at ? $post->created_at->format('d M Y, h:i A') : '' }}
          <span class="detail-muted ms-1">
            ({{ $post->created_at ? $post->created_at->diffForHumans() : '' }})
          </span>
        </div>

        <div class="d-flex flex-wrap gap-2 align-items-center">
          <a href="{{ route('donor.donations') }}" class="btn btn-outline-secondary btn-sm">
            ← Back to My Donations
          </a>

          @php $status = strtolower($post->status ?? 'available'); @endphp

          @if($status !== 'available')
            <form method="POST" action="{{ route('donor.food.updateStatus', $post->id) }}">
              @csrf
              @method('PATCH')
              <input type="hidden" name="status" value="available">
              <button type="submit" class="btn btn-sm btn-success">Mark as Available</button>
            </form>
          @endif

          @if($status !== 'completed')
            <form method="POST" action="{{ route('donor.food.updateStatus', $post->id) }}">
              @csrf
              @method('PATCH')
              <input type="hidden" name="status" value="completed">
              <button type="submit" class="btn btn-sm btn-primary">Mark as Completed</button>
            </form>
          @endif

          @if($status !== 'cancelled')
            <form method="POST" action="{{ route('donor.food.updateStatus', $post->id) }}">
              @csrf
              @method('PATCH')
              <input type="hidden" name="status" value="cancelled">
              <button type="submit" class="btn btn-sm btn-outline-danger">Cancel Post</button>
            </form>
          @endif
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
