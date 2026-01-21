{{-- resources/views/pages/donor/profile.blade.php --}}
@extends('layouts.main')

@section('title', 'My Profile')

@section('content')
<style>
    .profile-wrapper{
        background:#f8fafc;
    }

    .profile-hero{
        background:linear-gradient(135deg,#22c55e,#16a3b8);
        border-radius:18px;
        color:#fff;
        padding:1.7rem 2rem;
        box-shadow:0 18px 35px rgba(15,23,42,.25);
        margin-bottom:2rem;
    }
    .profile-hero-title{
        font-size:clamp(1.9rem,3vw,2.3rem);
        font-weight:800;
        letter-spacing:.02em;
    }
    .profile-hero-subtitle{
        font-size:.95rem;
        opacity:.94;
    }
    .profile-stat-pill{
        border-radius:999px;
        background:rgba(255,255,255,.12);
        padding:.4rem .9rem;
        font-size:.82rem;
        display:inline-flex;
        align-items:center;
        gap:.35rem;
    }
    .profile-stat-number{
        font-weight:700;
        font-size:1rem;
    }

    .profile-card{
        border-radius:16px;
        border:0;
        box-shadow:0 10px 25px rgba(15,23,42,.08);
        overflow:hidden;
    }

    .avatar-circle{
        width:80px;
        height:80px;
        border-radius:50%;
        background:#dcfce7;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:2.2rem;
        font-weight:700;
        color:#166534;
    }
    .avatar-img{
        width:80px;
        height:80px;
        object-fit:cover;
        border-radius:50%;
        border:3px solid #bbf7d0;
    }

    .profile-label{
        font-size:.8rem;
        text-transform:uppercase;
        letter-spacing:.08em;
        color:#6b7280;
        margin-bottom:0.15rem;
    }

    .profile-value{
    font-size:1.05rem;
    font-weight:500;
    color:#111827;
    }


    .profile-meta{
        font-size:.98rem;
        color:#6b7280;
    }

    @media (max-width: 767.98px){
        .profile-hero{
            padding:1.3rem 1.4rem;
        }
    }
</style>

<div class="profile-wrapper py-4 py-md-5">
    <div class="container">

        {{-- ======== TOP HERO ======== --}}
        <div class="profile-hero d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="profile-hero-title mb-1">My Profile</h2>
                <p class="profile-hero-subtitle mb-0">
                    Manage your personal information and account settings.
                </p>
            </div>

            <div class="text-md-end">
                <div class="mb-2">
                    <span class="profile-stat-pill me-1">
                        <span class="profile-stat-number">{{ $totalPosts }}</span> total donations
                    </span>
                    <span class="profile-stat-pill me-1">
                        <span class="profile-stat-number">{{ $availableCount }}</span> available
                    </span>
                    <span class="profile-stat-pill">
                        <span class="profile-stat-number">{{ $completedCount }}</span> completed
                    </span>
                </div>
                <div class="profile-meta">
                    Member since {{ $user->created_at->format('d M Y') }}
                </div>
            </div>
        </div>

        {{-- ======== MAIN CARD ======== --}}
        <div class="card profile-card">
            <div class="card-body p-4 p-md-5">

                <div class="row g-4">
                    {{-- Left: avatar & basic --}}
                    <div class="col-md-4 border-md-end">
                        <div class="d-flex flex-column align-items-center align-items-md-start gap-3">

                            {{-- avatar --}}
                            @if(!empty($user->image))
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Profile image"
                                     class="avatar-img">
                            @else
                                <div class="avatar-circle">
                                    {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                </div>
                            @endif

                            <div>
                                <div class="profile-label"></div>
                                <div class="profile-value mb-1">{{ $user->name }}</div> <br>

                                <div class="profile-label">Role</div>
                                <div class="profile-value text-success text-uppercase small">
                                    {{ $user->role }}
                                </div>

                                <div class="profile-meta mt-2">
                                    Joined: {{ $user->created_at->format('d M Y') }}
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-md-row gap-2 mt-3">
                                <a href="{{ route('donor.profile.edit') }}" class="btn btn-success btn-sm">
                                    Edit Profile
                                </a>
                                <a href="{{ route('donor.profile.password') }}" class="btn btn-outline-secondary btn-sm">
                                    Change Password
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Right: info fields --}}
                    <div class="col-md-8">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="profile-label">Email</div>
                                <div class="profile-value">{{ $user->email }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-label">Phone</div>
                                <div class="profile-value">
                                    {{ $user->phone ?? '—' }}
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="profile-label">Full Address</div>
                                <div class="profile-value">
                                    {{ $user->address ?? '—' }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
