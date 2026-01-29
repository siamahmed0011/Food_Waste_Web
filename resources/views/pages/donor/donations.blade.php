{{-- resources/views/pages/donor/donations.blade.php --}}
@extends('layouts.main')

@section('title', 'My Donations')

@section('content')

    {{-- Page-specific: keep minimal (only what truly unique) --}}
    <style>
        /* Keep wrapper very light; global theme handles bg */
        .donations-wrapper{ padding: 24px 0; }

        /* Hero card: toned-down, brand-consistent */
        .donor-hero-card{
            background: linear-gradient(135deg, var(--primary), #26A69A);
            border-radius: 18px;
            color:#fff;
            padding: 1.6rem 1.8rem;
            box-shadow: 0 14px 30px rgba(17,24,39,.16);
        }
        .donor-hero-title{
            font-size: clamp(1.8rem, 3vw, 2.2rem);
            font-weight: 800;
            letter-spacing: .01em;
        }
        .donor-hero-subtitle{ font-size: .95rem; opacity: .92; }

        /* Pills */
        .hero-stat-pill{
            border-radius:999px;
            background: rgba(255,255,255,.14);
            padding:.38rem .85rem;
            font-size:.82rem;
            display:inline-flex;
            align-items:center;
            gap:.35rem;
        }
        .hero-stat-number{ font-weight:800; font-size:1rem; }

        /* Table feel */
        .mydon-table thead{
            background: rgba(17,24,39,.02);
            font-size:.78rem;
            text-transform:uppercase;
            letter-spacing:.08em;
        }
        .mydon-table tbody tr{
            transition: background .15s ease, transform .15s ease;
        }
        .mydon-table tbody tr:hover{
            background: rgba(17,24,39,.02);
            transform: translateY(-1px);
        }

        /* Title cell */
        .donation-title{ font-weight: 700; font-size: .98rem; }
        .donation-category{ font-size: .82rem; color: var(--muted); }

        .donation-title a{ color: inherit; text-decoration: none; }
        .donation-title a:hover{ text-decoration: underline; }

        /* Use global badges when possible */
        .status-badge{
            border-radius:999px;
            padding:.28rem .75rem;
            font-size:.78rem;
            font-weight:700;
            display:inline-flex;
        }

        /* Empty state (no bootstrap icons dependency) */
        .empty-state-icon{
            width:56px; height:56px;
            border-radius:50%;
            background: rgba(38,161,168,.10);
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 1rem;
            color:#26A69A;
            font-size:1.6rem;
            font-weight:800;
        }

        /* Actions */
        .mydon-actions .btn{
            font-size:.75rem;
            padding:.30rem .65rem;
        }
    </style>

    <div class="donations-wrapper">
        <div class="container">

            {{-- ======== HERO ======== --}}
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

                        {{-- CTA: make it stand out but clean --}}
                        <a href="{{ route('donor.food.create') }}" class="btn btn-light btn-sm fw-semibold px-3">
                            + Post New Food
                        </a>
                    </div>
                </div>

                {{-- ======== FILTER + SEARCH ======== --}}
                <form method="GET" action="{{ route('donor.donations') }}" class="row g-2 mt-3">
                    <div class="col-12 col-md-5">
                        <input type="text"
                               name="q"
                               class="form-control form-control-sm"
                               placeholder="Search by title..."
                               value="{{ $searchTerm }}">
                    </div>

                    <div class="col-6 col-md-3">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All status</option>
                            <option value="available" {{ $filterStatus === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="reserved"  {{ $filterStatus === 'reserved'  ? 'selected' : '' }}>Reserved</option>
                            <option value="completed" {{ $filterStatus === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $filterStatus === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="col-6 col-md-2 d-grid">
                        <button class="btn btn-sm btn-light fw-semibold" type="submit">Apply</button>
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
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="empty-state-icon">✓</div>
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
                <div class="card">
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
                                            $status = strtolower($post->status ?? 'available');

                                            $statusClass = match($status){
                                                'available' => 'badge badge-available',
                                                'reserved'  => 'badge badge-pending',
                                                'completed' => 'badge badge-done',
                                                default     => 'badge badge-done',
                                            };

                                            $statusText = ucfirst($status);
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

                                            {{-- Status --}}
                                            <td>
                                                <span class="status-badge {{ $statusClass }}">
                                                    {{ $statusText }}
                                                </span>
                                            </td>

                                            {{-- Posted time --}}
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $post->created_at->format('d M Y, h:i A') }}
                                                </div>
                                                <div class="text-muted small">
                                                    {{ $post->created_at->diffForHumans() }}
                                                </div>
                                            </td>

                                            {{-- Actions --}}
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
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">
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
