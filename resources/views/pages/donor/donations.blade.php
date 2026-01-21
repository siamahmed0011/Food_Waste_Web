{{-- resources/views/pages/donor/donations.blade.php --}}
@extends('layouts.main')

@section('title', 'My Donations')

@section('content')
    {{-- ======== MY DONATIONS PAGE CSS ======== --}}
    <style>
        .donations-wrapper{
            background: #f8fafc;
        }

        .donor-hero-card{
            background: linear-gradient(135deg,#22c55e,#16a3b8);
            border-radius: 18px;
            color:#fff;
            padding: 1.8rem 2rem;
            box-shadow: 0 18px 35px rgba(15, 23, 42, .25);
        }

        .donor-hero-title{
            font-size: clamp(1.9rem, 3vw, 2.3rem);
            font-weight: 800;
            letter-spacing: .02em;
        }

        .donor-hero-subtitle{
            font-size: .95rem;
            opacity: .94;
        }

        .hero-stat-pill{
            border-radius:999px;
            background: rgba(255,255,255,.12);
            padding:.4rem .9rem;
            font-size:.82rem;
            display:inline-flex;
            align-items:center;
            gap:.35rem;
        }

        .hero-stat-number{
            font-weight:700;
            font-size:1rem;
        }

        .mydon-card{
            border-radius: 14px;
            border:0;
            box-shadow:0 10px 25px rgba(15,23,42,.08);
            overflow:hidden;
        }

        .mydon-table thead{
            background:#f1f5f9;
            font-size:.9rem;
            text-transform:uppercase;
            letter-spacing:.06em;
        }

        .mydon-table tbody tr{
            transition: background .15s ease, transform .15s ease;
        }

        .mydon-table tbody tr:hover{
            background:#f9fafb;
            transform: translateY(-1px);
        }

        .donation-title{
            font-weight:600;
            font-size:.98rem;
        }

        .donation-category{
            font-size:.8rem;
            color:#6b7280;
        }

        /* Title link – clickable but looks like text */
        .donation-title a{
            color: inherit;
            text-decoration: none;
        }
        .donation-title a:hover{
            text-decoration: underline;
        }

        .status-badge{
            border-radius:999px;
            padding:.25rem .8rem;
            font-size:.78rem;
            font-weight:600;
        }

        .status-available{
            background:#dcfce7;
            color:#166534;
        }
        .status-reserved{
            background:#fef9c3;
            color:#854d0e;
        }
        .status-completed{
            background:#dbeafe;
            color:#1d4ed8;
        }
        .status-other{
            background:#fee2e2;
            color:#b91c1c;
        }

        .posted-time-main{
            font-size:.9rem;
            font-weight:500;
        }

        .posted-time-sub{
            font-size:.78rem;
            color:#9ca3af;
        }

        .empty-state-icon{
            width:60px;
            height:60px;
            border-radius:50%;
            background:#e5f6ff;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0 auto 1rem;
            color:#0284c7;
            font-size:1.7rem;
        }

        /* action buttons */
        .mydon-actions .btn{
            font-size:.75rem;
            padding:.25rem .6rem;
        }
    </style>

    <div class="donations-wrapper py-4 py-md-5">
        <div class="container">

            {{-- ======== TOP SUMMARY + BUTTON ======== --}}
            <div class="donor-hero-card mb-4 mb-md-5">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h2 class="donor-hero-title mb-1">My Donations</h2>
                        <p class="donor-hero-subtitle mb-0">
                            A quick overview of all the meals you’ve shared so far.
                            Thank you for helping reduce food waste and hunger.
                        </p>
                    </div>

                    <div class="text-md-end">
                        <div class="mb-2">
                            <span class="hero-stat-pill me-1">
                                <span class="hero-stat-number">{{ $totalPosts }}</span> total posts
                            </span>
                            <span class="hero-stat-pill me-1">
                                <span class="hero-stat-number">{{ $availableCount }}</span> available
                            </span>
                            <span class="hero-stat-pill">
                                <span class="hero-stat-number">{{ $completedCount }}</span> completed
                            </span>
                        </div>

                        <a href="{{ route('donor.food.create') }}" class="btn btn-light btn-sm fw-semibold">
                            + Post New Food
                        </a>
                    </div>
                </div>

                {{-- ======== FILTER + SEARCH FORM ======== --}}
                <form method="GET" action="{{ route('donor.donations') }}" class="row g-2 mt-3">
                    <div class="col-12 col-md-5">
                        <input
                            type="text"
                            name="q"
                            class="form-control form-control-sm"
                            placeholder="Search by title..."
                            value="{{ $searchTerm }}"
                        >
                    </div>

                    <div class="col-6 col-md-3">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All status</option>
                            <option value="available" {{ $filterStatus === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="reserved" {{ $filterStatus === 'reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="completed" {{ $filterStatus === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $filterStatus === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="col-6 col-md-2 d-grid">
                        <button class="btn btn-sm btn-light fw-semibold" type="submit">
                            Apply
                        </button>
                    </div>

                    @if($searchTerm || $filterStatus)
                        <div class="col-12 col-md-2 d-grid">
                            <a href="{{ route('donor.donations') }}" class="btn btn-sm btn-outline-light">
                                Clear
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            {{-- ======== MAIN CONTENT ======== --}}
            @if($posts->isEmpty())
                {{-- Empty state --}}
                <div class="card mydon-card">
                    <div class="card-body text-center py-5">
                        <div class="empty-state-icon">
                            <i class="bi bi-emoji-smile"></i>
                        </div>
                        <h5 class="fw-semibold mb-2">No donations found</h5>

                        @if($searchTerm || $filterStatus)
                            <p class="text-muted mb-3">
                                Try clearing the filters or searching with a different title.
                            </p>
                            <a href="{{ route('donor.donations') }}" class="btn btn-outline-secondary btn-sm">
                                Reset Filters
                            </a>
                        @else
                            <p class="text-muted mb-3">
                                Start by posting your first surplus meal so nearby NGOs can request it.
                            </p>
                            <a href="{{ route('donor.food.create') }}" class="btn btn-success px-4">
                                Post Food Now
                            </a>
                        @endif
                    </div>
                </div>
            @else
                {{-- Table card --}}
                <div class="card mydon-card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mydon-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 34%">Title</th>
                                        <th style="width: 14%">Quantity</th>
                                        <th style="width: 14%">Status</th>
                                        <th style="width: 24%">Posted at</th>
                                        <th style="width: 14%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $post)
                                        @php
                                            $status = $post->status ?? 'available';
                                        @endphp

                                        <tr>
                                            {{-- Title + category --}}
                                            <td>
                                                <div class="donation-title">
                                                    <a href="{{ route('donor.food.show', $post->id) }}">
                                                        {{ $post->title }}
                                                    </a>
                                                </div>
                                                @if(!empty($post->category))
                                                    <div class="donation-category">
                                                        Category: {{ $post->category }}
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- Quantity --}}
                                            <td>
                                                @if($post->quantity)
                                                    {{ $post->quantity }} {{ $post->unit }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>

                                            {{-- Status badges --}}
                                            <td>
                                                @if($status === 'available')
                                                    <span class="status-badge status-available">Available</span>
                                                @elseif($status === 'reserved')
                                                    <span class="status-badge status-reserved">Reserved</span>
                                                @elseif($status === 'completed')
                                                    <span class="status-badge status-completed">Completed</span>
                                                @else
                                                    <span class="status-badge status-other">{{ ucfirst($status) }}</span>
                                                @endif
                                            </td>

                                            {{-- Posted time --}}
                                            <td>
                                                <div class="posted-time-main">
                                                    {{ $post->created_at->format('d M Y, h:i A') }}
                                                </div>
                                                <div class="posted-time-sub">
                                                    {{ $post->created_at->diffForHumans() }}
                                                </div>
                                            </td>

                                            {{-- Actions: View / Edit / Delete --}}
                                            <td>
                                                <div class="mydon-actions d-flex flex-wrap gap-1">
                                                    <a href="{{ route('donor.food.show', $post->id) }}"
                                                       class="btn btn-outline-secondary btn-sm">
                                                        View
                                                    </a>

                                                    <a href="{{ route('donor.food.edit', $post->id) }}"
                                                       class="btn btn-outline-primary btn-sm">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('donor.food.destroy', $post->id) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-outline-danger btn-sm">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

