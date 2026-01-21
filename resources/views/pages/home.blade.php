{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.main')

@section('title', 'Food Waste Platform')

@section('content')
<style>
    .hero-wrapper{
        min-height: 82vh;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:3rem 0;
        background:#f3e6f3;
    }
    .hero-card{
        max-width:1200px;
        width:100%;
        background:#000;
        color:#fff;
        border-radius:24px;
        overflow:hidden;
        position:relative;
        box-shadow:0 20px 40px rgba(0,0,0,0.35);
    }
    .hero-bg{
        position:absolute;
        inset:0;
        background:url('{{ asset('images/h2.jpg') }}') center center/cover no-repeat;
        filter:brightness(.45);
    }
    .hero-content{
        position:relative;
        z-index:2;
        padding:5rem 3rem;
        text-align:center;
    }
    @media (min-width: 992px){
        .hero-content{
            padding:6rem 5rem;
        }
    }
    .hero-title{
        font-size: clamp(2.4rem, 4.2vw, 3.8rem);
        font-weight:800;
        margin-bottom:1rem;
    }
    .hero-subtitle{
        font-size:1.05rem;
        max-width:720px;
        margin:0 auto 2.2rem;
    }
    .hero-buttons .btn{
        padding:.8rem 2.5rem;
        border-radius:999px;
        font-weight:600;
        margin:0 .4rem;
        min-width:150px;
    }

    /* section generic */
    .section-heading{
        font-weight:700;
    }
    .icon-circle{
        width:44px;
        height:44px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:1.2rem;
        background:#e6f4ea;
        color:#198754;
    }

    /* stats band */
    .stats-band{
        background:linear-gradient(90deg,#0f766e,#0ea5e9);
        color:#fff;
    }
    .stats-number{
        font-size:1.8rem;
        font-weight:700;
    }
    .stats-label{
        text-transform:uppercase;
        letter-spacing:.08em;
        font-size:.78rem;
        opacity:.9;
    }

    /* contact */
    .contact-card{
        max-width:700px;
        margin:0 auto;
        background:#fff;
        border-radius:12px;
        padding:24px 28px;
        box-shadow:0 10px 25px rgba(15,23,42,0.12);
    }

      /* NAVBAR DESIGN */
    .custom-navbar {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        border-bottom: 2px solid #f5dfff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 14px 0;
    }

    .navbar-brand {
        font-size: 1.45rem;
        font-weight: 800;
        color: #cf81afff !important;
        letter-spacing: .5px;
    }

    /* NAV LINKS */
    .nav-link {
        font-weight: 600;
        color: #dc9ee9ff !important;
        font-size: 1rem;
        padding: 8px 14px !important;
        border-radius: 6px;
        transition: all .25s ease;
    }

    /* Hover effect (No underline, soft highlight) */
    .nav-link:hover {
        background: #f3d9ff;
        color: #6a0099 !important;
    }

    /* Active Page Highlight */
    .nav-link.active {
        background: #e6c4ff;
        color: #4a006e !important;
        font-weight: 700;
    }

    /* USER ROLE BADGE */
    .user-role-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 700;
        background: #00a86b;
        color: #fff;
    }
</style>

{{-- ============ HERO ============ --}}
<section class="hero-wrapper">
    <div class="hero-card">
        <div class="hero-bg"></div>

        <div class="hero-content">
            <h1 class="hero-title">A meal shared is a smile shared</h1>

            <p class="hero-subtitle">
                Welcome to Food Donation, where we bridge the gap between abundance and need
                by connecting surplus food from homes, restaurants and events to nearby NGOs and volunteers.
            </p>

            <div class="hero-buttons mb-3">
                @guest
                    <a href="{{ route('signup.choice') }}" class="btn btn-warning me-2">SignUp</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light">SignIn</a>
                @endguest

               @auth
    @if(auth()->user()->role === 'donor')
        <a href="{{ route('donor.dashboard') }}" class="btn btn-warning">
            Go to Donor Dashboard
        </a>

    @elseif(auth()->user()->role === 'organization')
        <a href="{{ route('ngo.dashboard') }}" class="btn btn-warning">
            Go to NGO Dashboard
        </a>

    @else
        <a href="{{ route('dashboard') }}" class="btn btn-warning">
            Go to Dashboard
        </a>
    @endif
@endauth


            <p class="mb-0 small">
                Over 30% of daily meals served to those in need and 100,000+ meals distributed.
            </p>
        </div>
    </div>
</section>

{{-- ============ ABOUT + HOW IT WORKS ============ --}}
<section id="about" class="py-5 bg-white">
    <div class="container">
        <h2 class="section-heading text-center mb-2">About the platform</h2>
        <p class="text-center text-muted mb-5" style="max-width:800px;margin:0 auto;">
            Our system connects donors with verified NGOs to reduce food waste and ensure that safe surplus food
            reaches people in need quickly and transparently. Here’s how the flow works:
        </p>

        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="h-100 p-4 shadow-sm rounded bg-light">
                    <div class="icon-circle mx-auto mb-3">1</div>
                    <h5>Donor posts surplus food</h5>
                    <p class="small mb-0">
                        Donors share food details, quantity, location and pickup time from their dashboard.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="h-100 p-4 shadow-sm rounded bg-light">
                    <div class="icon-circle mx-auto mb-3">2</div>
                    <h5>NGOs request pickup</h5>
                    <p class="small mb-0">
                        Nearby NGOs browse posts, send pickup requests and receive confirmation in real-time.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="h-100 p-4 shadow-sm rounded bg-light">
                    <div class="icon-circle mx-auto mb-3">3</div>
                    <h5>Food is collected & served</h5>
                    <p class="small mb-0">
                        Verified organizations collect the food, transport it safely and serve vulnerable people.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ STATS BAND ============ --}}
<section class="stats-band py-4">
    <div class="container">
        <div class="row text-center text-md-start g-4 align-items-center">
            
        </div>
    </div>
</section>

{{-- ============ WHO CAN JOIN ============ --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-heading text-center mb-4">Who can join?</h2>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="bg-white shadow-sm rounded p-4 h-100">
                    <h4>For Donors</h4>
                    <p class="small">
                        Restaurants, hotels, caterers, households and event organizers who have
                        safe extra food that would otherwise be wasted.
                    </p>
                    <ul class="small mb-3">
                        <li>Post surplus food in a few clicks</li>
                        <li>Set expiry and pickup time</li>
                        <li>Track your previous donations</li>
                    </ul>
                    <a href="{{ route('register.donor') }}" class="btn btn-success btn-sm">
                        Register as Donor
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-white shadow-sm rounded p-4 h-100">
                    <h4>For Organizations</h4>
                    <p class="small">
                        NGOs, shelters, orphanages and community kitchens who distribute food to people in need.
                    </p>
                    <ul class="small mb-3">
                        <li>View donations near your location</li>
                        <li>Request pickups in real-time</li>
                        <li>Maintain beneficiary and pickup records</li>
                    </ul>
                    <a href="{{ route('register.organization') }}" class="btn btn-primary btn-sm">
                        Register as Organization
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ CONTACT SECTION ============ --}}
<section id="contact" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-heading text-center mb-3">Contact Us</h2>
        <p class="text-center text-muted mb-4" style="max-width:700px;margin:0 auto;">
            Reach out to us anytime. We are here to help donors, NGOs and volunteers.
        </p>

        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm border-0 rounded">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-3">📞 Contact Information</h5>

                        <p class="mb-2">
                            <strong>Email:</strong>  
                            <a href="mailto:info@foodwasteproject.com">info@foodwasteproject.com</a>
                        </p>

                        <p class="mb-2">
                            <strong>Phone:</strong> +880 123 456 789
                        </p>

                        <p class="mb-2">
                            <strong>Fax:</strong> +880 987 654 321
                        </p>

                        <p class="mb-0">
                            <strong>Address:</strong>  
                            Dhaka, Bangladesh
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


{{-- ============ FOOTER SHORT CTA ============ --}}
<section class="py-5">
    <div class="container text-center">
        <h3 class="section-heading mb-3">Ready to share a meal?</h3>
        <p class="text-muted mb-4">
            Join our Food Waste Platform and help make sure that no safe food ends up in the bin
            while people are still hungry.
        </p>

        @guest
            <a href="{{ route('signup.choice') }}" class="btn btn-success px-4">
                Get Started
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-success px-4">
                Go to Dashboard
            </a>
        @endguest
    </div>
</section>

{{-- ================= FOOTER ================= --}}
<footer class="py-4 mt-3">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
        <p class="mb-2 mb-md-0 small">
            © {{ date('Y') }} Food Waste Donor Management System. All rights reserved.
        </p>
        <p class="mb-0 small">
            Contact: <a href="mailto:info@foodwasteproject.com">info@foodwasteproject.com</a>
        </p>
    </div>
</footer>

@endsection

