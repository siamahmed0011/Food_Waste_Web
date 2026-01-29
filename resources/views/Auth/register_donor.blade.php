@extends('layouts.main')

@section('title','Donor Registration')

@section('content')
<style>
  .auth-wrap{
    padding: 56px 0;
    background: linear-gradient(180deg, #f5f7fa 0%, #ffffff 55%, #f5f7fa 100%);
  }

  .auth-shell{
    max-width: 980px;
    margin: 0 auto;
    box-shadow: 0 18px 45px rgba(15,23,42,.12);
    border-radius: 18px;
    overflow: hidden;
    background: #fff;
  }

  .auth-left{
    background: linear-gradient(135deg,#166534,#0f766e);
    color:#fff;
    padding: 34px 28px;
    position: relative;
  }
  .auth-left:after{
    content:"";
    position:absolute;
    inset:-40px -60px auto auto;
    width:240px;height:240px;
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,.18), rgba(255,255,255,0) 60%);
    filter: blur(2px);
  }
  .auth-left h3{ font-weight:800; line-height:1.15; }
  .auth-left p{ opacity:.92; }
  .auth-left ul{ margin: 0; padding-left: 18px; opacity:.95; }
  .auth-left li{ margin: 8px 0; }

  .auth-right{ padding: 30px 28px; }
  .auth-title{
    font-weight: 900;
    font-size: 1.9rem;
    margin-bottom: 4px;
    color:#0f172a;
  }
  .auth-sub{
    color:#6b7280;
    margin-bottom: 18px;
  }
  .req{ color:#dc2626; font-weight:900; }

  .form-label{
    font-weight: 800;
    color:#0f172a;
    margin-bottom: 6px;
  }
  .form-control{
    border-radius: 12px;
    padding: 11px 12px;
    border: 1px solid #e5e7eb;
    background: #fff;
  }
  .form-control:focus{
    border-color:#22c55e;
    box-shadow: 0 0 0 3px rgba(34,197,94,.14);
  }

  /* password with eye */
  .pass-wrap{
    position: relative;
    width: 100%;
  }
  .pass-wrap .form-control{
    padding-right: 54px; /* eye button space */
  }
  .eye-toggle{
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    background: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #16a34a;
    transition: .15s ease;
  }
  .eye-toggle:hover{
    border-color:#22c55e;
    box-shadow: 0 0 0 3px rgba(34,197,94,.10);
  }
  .icon-eye{ width: 18px; height: 18px; }
  .icon-hide{ display:none; }
  .eye-toggle.active .icon-show{ display:none; }
  .eye-toggle.active .icon-hide{ display:block; }

  .btn-main{
    width:100%;
    border-radius: 12px;
    padding: 12px 14px;
    font-weight: 900;
    border: 0;
    background: linear-gradient(135deg,#22c55e,#14b8a6);
    color:#fff;
    box-shadow: 0 12px 24px rgba(20,184,166,.18);
  }
  .btn-main:hover{ filter: brightness(.98); }

  .bottom-links{
    margin-top: 14px;
    text-align:center;
    color:#6b7280;
  }
  .bottom-links a{
    color:#16a34a;
    font-weight:900;
    text-decoration:none;
  }
  .bottom-links a:hover{ text-decoration:underline; }

  @media (max-width: 767.98px){
    .auth-left{ padding: 26px 20px; }
    .auth-right{ padding: 22px 18px; }
  }
</style>

<div class="auth-wrap">
  <div class="container">
    <div class="auth-shell">
      <div class="row g-0">

        <div class="col-md-4 auth-left d-flex align-items-center">
          <div>
            <h3 class="mb-3">Become a <span style="color:#bbf7d0;">Donor</span></h3>
            <p class="mb-3">
              Share your surplus food with nearby NGOs and volunteers.
              Your small contribution can bring a big smile to someone in need.
            </p>

            <ul class="small">
              <li>Safe & quick pickup</li>
              <li>Location based matching</li>
              <li>Track your donations</li>
            </ul>

            <div class="mt-4 small" style="opacity:.9;">
              Tip: Use a reachable phone number so NGOs can contact you quickly.
            </div>
          </div>
        </div>

        <div class="col-md-8 auth-right">
          <div class="auth-title">Donor Registration</div>
          <div class="auth-sub">Create your donor account in 1 minute.</div>

          @if ($errors->any())
            <div class="alert alert-danger rounded-3">
              <strong>Please fix the highlighted fields.</strong>
            </div>
          @endif

          <form method="POST" action="{{ route('register.post') }}" novalidate>
            @csrf
            <input type="hidden" name="role" value="donor">

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Donor Name <span class="req">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+8801XXXXXXXXX">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Email <span class="req">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">District</label>
                <input type="text" name="district" class="form-control" value="{{ old('district') }}" placeholder="e.g., Dhaka">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="e.g., Mirpur">
              </div>

              <div class="col-md-3 mb-3">
                <label class="form-label">Road No.</label>
                <input type="text" name="road_no" class="form-control" value="{{ old('road_no') }}">
              </div>

              <div class="col-md-3 mb-3">
                <label class="form-label">House No.</label>
                <input type="text" name="house_no" class="form-control" value="{{ old('house_no') }}">
              </div>

              {{-- Password --}}
              <div class="col-md-6 mb-3">
                <label class="form-label">Password <span class="req">*</span></label>
                <div class="pass-wrap">
                  <input
                    id="donor_password"
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="••••••••"
                    required
                  >

                  <button type="button" class="eye-toggle" data-target="donor_password" aria-label="Toggle password">
                    <svg class="icon-eye icon-show" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <svg class="icon-eye icon-hide" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M3 3l18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                      <path d="M10.58 10.58A2 2 0 0 0 12 14a2 2 0 0 0 1.42-.58" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M9.88 5.09A10.53 10.53 0 0 1 12 5c6.5 0 10 7 10 7a18.43 18.43 0 0 1-4.2 5.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M6.2 6.2C3.8 8.2 2 12 2 12s3.5 7 10 7c1.13 0 2.2-.17 3.2-.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </button>
                </div>
              </div>

              {{-- Confirm Password --}}
              <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password <span class="req">*</span></label>
                <div class="pass-wrap">
                  <input
                    id="donor_password2"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="••••••••"
                    required
                  >

                  <button type="button" class="eye-toggle" data-target="donor_password2" aria-label="Toggle password">
                    <svg class="icon-eye icon-show" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <svg class="icon-eye icon-hide" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M3 3l18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                      <path d="M10.58 10.58A2 2 0 0 0 12 14a2 2 0 0 0 1.42-.58" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M9.88 5.09A10.53 10.53 0 0 1 12 5c6.5 0 10 7 10 7a18.43 18.43 0 0 1-4.2 5.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M6.2 6.2C3.8 8.2 2 12 2 12s3.5 7 10 7c1.13 0 2.2-.17 3.2-.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <button class="btn-main mt-2" type="submit">Sign Up as Donor</button>

            <div class="bottom-links">
              Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("click", function(e){
    const btn = e.target.closest(".eye-toggle");
    if(!btn) return;

    // data-target always WITHOUT '#'
    const id = btn.getAttribute("data-target");
    const input = document.getElementById(id);
    if(!input) return;

    const toText = (input.type === "password");
    input.type = toText ? "text" : "password";
    btn.classList.toggle("active", toText);
  });
</script>
@endsection
