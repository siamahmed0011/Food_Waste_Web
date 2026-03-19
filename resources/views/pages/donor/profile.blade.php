{{-- resources/views/pages/donor/profile.blade.php --}}
@extends('layouts.main')

@section('title', 'My Profile')

@section('content')
@php
    $timeMap = [
        'morning' => 'Morning (9am - 12pm)',
        'afternoon' => 'Afternoon (12pm - 4pm)',
        'evening' => 'Evening (4pm - 8pm)',
    ];
@endphp

<style>
    /* Keep it clean + compact + professional */
    .profile-wrap{ padding: 14px 0; }

    .p-hero{
        background: linear-gradient(135deg, rgba(34,197,94,.16), rgba(6,182,212,.14));
        border: 1px solid rgba(15,23,42,.06);
        border-radius: 16px;
        padding: 16px 18px;
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:14px;
    }
    .p-kicker{font-size:.78rem;font-weight:800;color:#0f766e;}
    .p-title{margin:2px 0 0;font-weight:900;font-size:26px;line-height:1.15;}
    .p-sub{margin:8px 0 0;color:#475569;font-weight:600;max-width:62ch;}

    .p-stats{display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end;align-items:flex-start;text-align:center;}
    .p-pill{
        background:#fff;
        border:1px solid rgba(15,23,42,.08);
        border-radius:999px;
        padding:8px 10px;
        min-width:110px;
        box-shadow:0 10px 22px rgba(15,23,42,.06);
    }
    .p-pill b{font-size:16px;font-weight:900;color:#0f172a;}
    .p-pill span{display:block;font-size:.72rem;color:#64748b;font-weight:800;margin-top:2px;}
    .p-meta{width:100%;text-align:right;color:#64748b;font-weight:600;font-size:.82rem;margin-top:2px;}

    .p-card{
        background:#fff;
        border:1px solid rgba(15,23,42,.06);
        border-radius:16px;
        padding:18px;
        box-shadow:0 12px 30px rgba(15,23,42,.06);
        margin-top:14px;
    }

    .p-top{display:flex;gap:16px;align-items:center;justify-content:space-between;flex-wrap:wrap;}
    .p-left{display:flex;gap:14px;align-items:center;flex-wrap:wrap;}
    .p-avatar{
        width:64px;height:64px;border-radius:18px;
        display:grid;place-items:center;
        background:rgba(34,197,94,.14);
        color:#14532d;
        font-weight:900;
        font-size:22px;
        overflow:hidden;
        border:1px solid rgba(15,23,42,.06);
    }
    .p-avatar img{width:100%;height:100%;object-fit:cover;display:block;}
    .p-name{font-weight:900;font-size:20px;margin:0;}
    .p-role{display:flex;align-items:center;gap:8px;margin-top:4px;font-weight:800;color:#0f766e;}
    .p-role-dot{width:8px;height:8px;border-radius:999px;background:#22c55e;}
    .p-joined{margin-top:6px;color:#64748b;font-weight:600;font-size:.9rem;}

    .p-actions{display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end;}
    .p-actions .btn{border-radius:999px;font-weight:800;padding:.5rem 1.1rem;}

    /* ✅ ONLY GRID: no bootstrap row/col inside */
    .p-grid{
        margin-top:16px;
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:12px;
        align-items:stretch;
    }
    .p-item{
        border:1px solid rgba(15,23,42,.06);
        border-radius:14px;
        padding:12px;
        background:rgba(15,23,42,.02);
        height:100%;
    }
    .p-item.full{grid-column:1 / -1;}

    .p-label{
        font-size:.72rem;
        text-transform:uppercase;
        letter-spacing:.06em;
        color:#64748b;
        font-weight:900;
    }
    .p-value{
        margin-top:6px;
        font-size:1rem;
        font-weight:700;
        color:#0f172a;
        word-break:break-word;
    }

    .pill-type{
        display:inline-block;
        padding:6px 12px;
        border-radius:999px;
        background:#e0f2fe;
        color:#0369a1;
        font-weight:800;
        font-size:.85rem;
        border:1px solid rgba(3,105,161,.18);
    }

    @media(max-width: 768px){
        .p-hero{flex-direction:column;}
        .p-meta{text-align:left;}
        .p-grid{grid-template-columns:1fr;}
    }
</style>

<div class="profile-wrap">
    <div class="panel-layout">
        <aside class="panel-left">
            @include('pages.donor.sidebar')
        </aside>

        <section class="panel-right">

            {{-- HERO --}}
            <div class="p-hero">
                <div>
                    <div class="p-kicker">Account</div>
                    <h2 class="p-title">My Profile</h2>
                    <p class="p-sub">Manage your personal information and account settings.</p>
                </div>

                <div class="p-stats">
                    <div class="p-pill">
                        <b>{{ $totalPosts }}</b>
                        <span>Total donations</span>
                    </div>
                    <div class="p-pill">
                        <b>{{ $availableCount }}</b>
                        <span>Available</span>
                    </div>
                    <div class="p-pill">
                        <b>{{ $completedCount }}</b>
                        <span>Completed</span>
                    </div>

                    <div class="p-meta">
                        Member since {{ $user->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>

            {{-- MAIN CARD --}}
            <div class="p-card">
                <div class="p-top">
                    <div class="p-left">
                        <div class="p-avatar">
                            @if(!empty($user->image))
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Profile image">
                            @else
                                {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                            @endif
                        </div>

                        <div>
                            <p class="p-name">{{ $user->name }}</p>
                            <div class="p-role">
                                <span class="p-role-dot"></span>
                                {{ strtoupper($user->role) }}
                            </div>
                            <div class="p-joined">Joined: {{ $user->created_at->format('d M Y') }}</div>
                        </div>
                    </div>

                    <div class="p-actions">
                        <a href="{{ route('donor.profile.edit') }}" class="btn btn-success">
                            Edit Profile
                        </a>
                        <a href="{{ route('donor.profile.password') }}" class="btn btn-outline-secondary">
                            Change Password
                        </a>
                    </div>
                </div>

                {{-- ✅ CLEAN GRID (no bootstrap row/col) --}}
                <div class="p-grid">

                    <div class="p-item">
                        <div class="p-label">Email</div>
                        <div class="p-value">{{ $user->email }}</div>
                    </div>

                    @if(!empty($user->phone))
                    <div class="p-item">
                        <div class="p-label">Phone</div>
                        <div class="p-value">{{ $user->phone }}</div>
                    </div>
                    @endif

                    @if(!empty($user->donor_type))
                    <div class="p-item">
                        <div class="p-label">Donor Type</div>
                        <div class="p-value">
                            <span class="pill-type">{{ ucfirst($user->donor_type) }}</span>
                        </div>
                    </div>
                    @endif

                    {{-- ✅ show only ONE time text (mapped) --}}
                    @if(!empty($user->pickup_time))
                    <div class="p-item">
                        <div class="p-label">Preferred Pickup Time</div>
                        <div class="p-value">
                            {{ $timeMap[$user->pickup_time] ?? ucfirst($user->pickup_time) }}
                        </div>
                    </div>
                    @endif

                    @if(($user->donor_type ?? '') !== 'individual' && !empty($user->organization_name))
                    <div class="p-item">
                        <div class="p-label">Organization</div>
                        <div class="p-value">{{ $user->organization_name }}</div>
                    </div>
                    @endif

                    @if(!empty($user->alt_phone))
                    <div class="p-item">
                        <div class="p-label">Alternative Phone</div>
                        <div class="p-value">{{ $user->alt_phone }}</div>
                    </div>
                    @endif

                    @if(!empty($user->pickup_address))
                    <div class="p-item full">
                        <div class="p-label">Pickup Address</div>
                        <div class="p-value">{{ $user->pickup_address }}</div>
                    </div>
                    @endif

                    @if(!empty($user->pickup_notes))
                    <div class="p-item full">
                        <div class="p-label">Pickup Notes</div>
                        <div class="p-value">{{ $user->pickup_notes }}</div>
                    </div>
                    @endif

                    @if(!empty($user->address))
                    <div class="p-item full">
                        <div class="p-label">Address</div>
                        <div class="p-value">{{ $user->address }}</div>
                    </div>
                    @endif

                </div>
            </div>

        </section>
    </div>
</div>
@endsection
