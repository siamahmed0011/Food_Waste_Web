{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.main')

@section('title', 'Food Waste Platform')

@section('content')
<style>
  /* ====== Page Background ====== */
  .home-page{
    background: var(--bg);
  }

  /* ====== HERO ====== */
  .hero-wrap{
    padding: 2.5rem 0 1.8rem;
  }

  .hero-shell{
    position: relative;
    border-radius: 26px;
    overflow: hidden;
    box-shadow: 0 26px 60px rgba(15,23,42,.22);
    background: #0b1220;
  }

  .hero-media{
    position:absolute;
    inset:0;
    background: url('{{ asset('images/h2.jpg') }}') center / cover no-repeat;
    transform: scale(1.02);
  }

  /* overlay for readability */
  .hero-shell::after{
    content:"";
    position:absolute;
    inset:0;
    background: radial-gradient(1200px 500px at 18% 35%, rgba(0,0,0,.25), rgba(0,0,0,.75)),
                linear-gradient(90deg, rgba(0,0,0,.72) 0%, rgba(0,0,0,.55) 45%, rgba(0,0,0,.20) 100%);
    pointer-events:none;
  }

  .hero-inner{
    position: relative;
    z-index: 2;
    padding: 3.2rem 1.4rem;
  }

  @media (min-width: 992px){
    .hero-inner{
      padding: 4.4rem 3.2rem;
    }
  }

  .hero-grid{
    display:grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
    align-items: center;
  }

  @media (min-width: 992px){
    .hero-grid{
      grid-template-columns: 1.1fr .9fr;
      gap: 1.8rem;
    }
  }

  .hero-title{
    font-size: clamp(2.1rem, 4.4vw, 3.6rem);
    font-weight: 900;
    letter-spacing: -0.02em;
    line-height: 1.05;
    color:#fff;
    margin: 0 0 .9rem;
  }

  .hero-subtitle{
    font-size: 1.05rem;
    color: rgba(255,255,255,.88);
    line-height: 1.75;
    margin: 0 0 1.3rem;
    max-width: 58ch;
  }

  .hero-actions{
    display:flex;
    flex-wrap: wrap;
    gap: .75rem;
    align-items:center;
    margin: 1rem 0 1rem;
  }

  .btn-hero{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    padding: .88rem 1.35rem;
    border-radius: 999px;
    font-weight: 800;
    text-decoration:none;
    border: 1px solid transparent;
    transition: transform .12s ease, box-shadow .12s ease, background .12s ease;
    min-width: 165px;
  }
  .btn-hero:active{ transform: translateY(1px); }

  .btn-hero-primary{
    background: var(--primary);
    color:#fff;
    box-shadow: 0 16px 26px rgba(46,125,50,.28);
  }
  .btn-hero-primary:hover{
    background: var(--primary-600);
    box-shadow: 0 18px 32px rgba(46,125,50,.34);
  }

  .btn-hero-outline{
    background: rgba(255,255,255,.08);
    border-color: rgba(255,255,255,.26);
    color: #fff;
    backdrop-filter: blur(8px);
  }
  .btn-hero-outline:hover{
    background: rgba(255,255,255,.12);
  }

  .hero-trust{
    display:flex;
    flex-wrap: wrap;
    gap: .65rem;
    color: rgba(255,255,255,.72);
    font-weight: 600;
    font-size: .92rem;
    margin-top: .7rem;
  }
  .hero-dot{
    opacity:.65;
  }

  /* ====== Stats Card (right side) ====== */
  .hero-stats{
    background: rgba(17,24,39,.55);
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 22px;
    padding: 1.25rem 1.25rem;
    backdrop-filter: blur(10px);
    box-shadow: 0 22px 40px rgba(0,0,0,.22);
    color:#fff;
  }

  .stats-top{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .75rem;
    margin-bottom: .9rem;
  }

  .stat{
    text-align:center;
    padding:.65rem .5rem;
    border-radius: 16px;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.10);
  }

  .stat strong{
    display:block;
    font-size: 1.5rem;
    letter-spacing:-0.02em;
  }

  .stat span{
    display:block;
    margin-top: .2rem;
    font-size: .75rem;
    letter-spacing:.16em;
    text-transform: uppercase;
    opacity:.82;
  }

  .hero-stats p{
    margin:0;
    color: rgba(255,255,255,.82);
    line-height: 1.6;
    font-weight: 600;
  }

  /* ====== Section UI ====== */
  .section{
    padding: 3.2rem 0;
  }
  .section-title{
    font-weight: 900;
    letter-spacing: -0.02em;
    margin: 0 0 .6rem;
  }
  .section-subtitle{
    color: var(--muted);
    max-width: 820px;
    margin: 0 auto 1.8rem;
    line-height: 1.7;
  }

  .step-card{
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 18px;
    box-shadow: 0 14px 28px rgba(15,23,42,.07);
    padding: 1.3rem 1.25rem;
    height: 100%;
    transition: transform .12s ease, box-shadow .12s ease;
  }
  .step-card:hover{
    transform: translateY(-2px);
    box-shadow: 0 18px 34px rgba(15,23,42,.10);
  }

  .step-bubble{
    width: 44px;
    height: 44px;
    border-radius: 999px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight: 900;
    color: var(--primary);
    background: rgba(46,125,50,.12);
    margin: 0 auto .9rem;
  }

  /* ====== Join Cards ====== */
  .join-card{
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 18px;
    box-shadow: 0 14px 28px rgba(15,23,42,.07);
    padding: 1.4rem 1.3rem;
    height: 100%;
  }
  .join-card h4{
    font-weight: 900;
    margin-bottom: .55rem;
  }
  .join-card ul{
    margin: .8rem 0 1.1rem;
    color: var(--muted);
  }
  .join-card li{ margin-bottom: .25rem; }

  .btn-soft{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding: .7rem 1.1rem;
    border-radius: 12px;
    font-weight: 800;
    text-decoration:none;
    border: 1px solid transparent;
  }
  .btn-soft-primary{ background: var(--primary); color:#fff; }
  .btn-soft-primary:hover{ background: var(--primary-600); }
  .btn-soft-outline{ background:#fff; border-color: var(--border); color: var(--text); }
  .btn-soft-outline:hover{ background: #f9fafb; }

  /* ====== Contact ====== */
  .contact-card{
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 18px;
    box-shadow: 0 14px 28px rgba(15,23,42,.07);
  }

  /* ====== Footer CTA ====== */
  .cta-strip{
    border-radius: 22px;
    background: linear-gradient(135deg, rgba(46,125,50,.12), rgba(249,168,37,.14));
    border: 1px solid var(--border);
    box-shadow: 0 14px 28px rgba(15,23,42,.06);
    padding: 2rem 1.5rem;
  }
</style>

<div class="home-page">

  {{-- ============ HERO ============ --}}
  <section class="hero-wrap">
    <div class="container">
      <div class="hero-shell">
        <div class="hero-media"></div>

        <div class="hero-inner">
          <div class="hero-grid">

            {{-- Left --}}
            <div>
              <h1 class="hero-title">A meal shared is a smile shared</h1>

              <p class="hero-subtitle">
                We connect donors with verified NGOs so safe surplus food reaches people in need quickly,
                transparently, and responsibly.
              </p>

              <div class="hero-actions">
                @guest
                  <a href="{{ route('signup.choice') }}" class="btn-hero btn-hero-primary">
                    Sign Up
                  </a>
                  <a href="{{ route('login') }}" class="btn-hero btn-hero-outline">
                    Sign In
                  </a>
                @endguest

                @auth
                  @if(auth()->user()->role === 'donor')
                    <a href="{{ route('donor.dashboard') }}" class="btn-hero btn-hero-primary">
                      Go to Donor Dashboard
                    </a>
                    <a href="{{ route('donor.donations') }}" class="btn-hero btn-hero-outline">
                      My Donations
                    </a>

                  @elseif(auth()->user()->role === 'organization')
                    <a href="{{ route('ngo.dashboard') }}" class="btn-hero btn-hero-primary">
                      Go to NGO Dashboard
                    </a>
                    <a href="{{ route('ngos.public') ?? route('home') }}" class="btn-hero btn-hero-outline">
                      Browse Posts
                    </a>

                  @else
                    <a href="{{ route('dashboard') }}" class="btn-hero btn-hero-primary">
                      Go to Dashboard
                    </a>
                  @endif
                @endauth
              </div>

              <div class="hero-trust">
                <span>Trusted flow</span><span class="hero-dot">•</span>
                <span>Simple posting</span><span class="hero-dot">•</span>
                <span>Fast pickup coordination</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ============ ABOUT + HOW IT WORKS ============ --}}
  <section id="about" class="section">
    <div class="container text-center">
      <h2 class="section-title">About the platform</h2>
      <p class="section-subtitle">
        Our system connects donors with verified NGOs to reduce food waste and ensure that safe surplus food
        reaches people in need quickly and transparently. Here’s how the flow works:
      </p>

      <div class="row g-4 text-start">
        <div class="col-md-4">
          <div class="step-card">
            <div class="step-bubble">1</div>
            <h5 class="fw-bold mb-2">Donor posts surplus food</h5>
            <p class="text-muted mb-0">
              Donors share food details, quantity, location and pickup time from their dashboard.
            </p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="step-card">
            <div class="step-bubble">2</div>
            <h5 class="fw-bold mb-2">NGOs request pickup</h5>
            <p class="text-muted mb-0">
              Nearby NGOs browse posts, send pickup requests and receive confirmation in real-time.
            </p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="step-card">
            <div class="step-bubble">3</div>
            <h5 class="fw-bold mb-2">Food is collected & served</h5>
            <p class="text-muted mb-0">
              Verified organizations collect the food, transport it safely and serve vulnerable people.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ============ WHO CAN JOIN ============ --}}
  <section class="section" style="background:#f8fafc;">
    <div class="container">
      <div class="text-center">
        <h2 class="section-title">Who can join?</h2>
        <p class="section-subtitle">
          Choose your role and start contributing to a cleaner, kinder community.
        </p>
      </div>

      <div class="row g-4">
        <div class="col-md-6">
          <div class="join-card">
            <h4>For Donors</h4>
            <p class="text-muted mb-2">
              Restaurants, hotels, caterers, households and event organizers who have safe extra food that would otherwise be wasted.
            </p>
            <ul class="small">
              <li>Post surplus food in a few clicks</li>
              <li>Set expiry and pickup time</li>
              <li>Track your previous donations</li>
            </ul>

            <a href="{{ route('register.donor') }}" class="btn-soft btn-soft-primary">
              Register as Donor
            </a>
          </div>
        </div>

        <div class="col-md-6">
          <div class="join-card">
            <h4>For Organizations</h4>
            <p class="text-muted mb-2">
              NGOs, shelters, orphanages and community kitchens who distribute food to people in need.
            </p>
            <ul class="small">
              <li>View donations near your location</li>
              <li>Request pickups in real-time</li>
              <li>Maintain pickup records</li>
            </ul>

            <a href="{{ route('register.organization') }}" class="btn-soft btn-soft-outline">
              Register as Organization
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ============ CONTACT SECTION ============ --}}
  <section id="contact" class="section">
    <div class="container">
      <div class="text-center">
        <h2 class="section-title">Contact Us</h2>
        <p class="section-subtitle">
          Reach out anytime. We are here to help donors, NGOs and volunteers.
        </p>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="contact-card">
            <div class="p-4 p-md-4">
              <h5 class="fw-bold mb-3">📞 Contact Information</h5>

              <p class="mb-2">
                <strong>Email:</strong>
                <a href="mailto:info@foodwastereduceproject.com">info@foodwastereduceproject.com</a>
              </p>

              <p class="mb-2"><strong>Phone:</strong> +880 01570267657</p>
              <p class="mb-0"><strong>Address:</strong> Mirpur,Dhaka, Bangladesh</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ============ FOOTER CTA ============ --}}
  <section class="section">
    <div class="container">
      <div class="cta-strip text-center">
        <h3 class="fw-bold mb-2" style="letter-spacing:-0.02em;">Ready to share a meal?</h3>
        <p class="text-muted mb-4" style="max-width:820px;margin:0 auto;">
          Join our Food Waste Platform and help make sure that no safe food ends up in the bin while people are still hungry.
        </p>

        @guest
          <a href="{{ route('signup.choice') }}" class="btn-soft btn-soft-primary" style="padding:.9rem 1.3rem;">
            Get Started
          </a>
        @else
          <a href="{{ route('dashboard') }}" class="btn-soft btn-soft-primary" style="padding:.9rem 1.3rem;">
            Go to Dashboard
          </a>
        @endguest
      </div>
    </div>
  </section>

  {{-- ================= FOOTER ================= --}}
  <footer class="py-4">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
      <p class="mb-2 mb-md-0 small text-muted">
        © {{ date('Y') }} Food Waste Reduce Management System. All rights reserved.
      </p>
      <p class="mb-0 small text-muted">
        Contact: <a href="mailto:info@foodwasteproject.com">info@foodwasteproject.com</a>
      </p>
    </div>
  </footer>

</div>
@endsection
