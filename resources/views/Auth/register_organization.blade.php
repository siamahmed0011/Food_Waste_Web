@extends('layouts.main')

@section('title','Organization Registration')

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
    background: linear-gradient(135deg,#0f172a,#020617);
    color:#fff;
    padding: 34px 28px;
  }

  .auth-left h3{ font-weight:800; }
  .auth-left p{ opacity:.9; }
  .auth-left ul{ padding-left:18px; }

  .auth-right{ padding: 30px 28px; }

  .auth-title{
    font-size: 1.9rem;
    font-weight: 900;
    color:#0f172a;
  }
  .auth-sub{ color:#6b7280; margin-bottom:18px; }

  .form-label{
    font-weight:800;
    color:#0f172a;
  }
  .req{ color:#dc2626; }

  .form-control{
    border-radius:12px;
    padding:11px 12px;
    border:1px solid #e5e7eb;
  }
  .form-control:focus{
    border-color:#22c55e;
    box-shadow:0 0 0 3px rgba(34,197,94,.14);
  }

  /* password eye */
  .pass-wrap{ position:relative; }
  .pass-wrap .form-control{ padding-right:54px; }

  .eye-toggle{
    position:absolute;
    top:50%;
    right:10px;
    transform:translateY(-50%);
    width:38px;height:38px;
    border-radius:10px;
    border:1px solid #e5e7eb;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    color:#16a34a;
  }
  .icon-eye{ width:18px;height:18px; }
  .icon-hide{ display:none; }
  .eye-toggle.active .icon-show{ display:none; }
  .eye-toggle.active .icon-hide{ display:block; }

  .btn-main{
    width:100%;
    margin-top:10px;
    padding:12px;
    border-radius:12px;
    border:0;
    font-weight:900;
    background:linear-gradient(135deg,#22c55e,#14b8a6);
    color:#fff;
  }

  .bottom-links{
    text-align:center;
    margin-top:14px;
    color:#6b7280;
  }
  .bottom-links a{
    color:#16a34a;
    font-weight:800;
    text-decoration:none;
  }
</style>

<div class="auth-wrap">
  <div class="container">
    <div class="auth-shell">
      <div class="row g-0">

        {{-- LEFT --}}
        <div class="col-md-4 auth-left d-flex align-items-center">
          <div>
            <h3>Join as <span style="color:#22c55e;">Organization</span></h3>
            <p>
              Register your NGO or food bank to receive verified surplus food from donors.
            </p>
            <ul class="small">
              <li>View nearby food donations</li>
              <li>Send pickup requests</li>
              <li>Maintain donation history</li>
            </ul>
          </div>
        </div>

        {{-- RIGHT --}}
        <div class="col-md-8 auth-right">
          <div class="auth-title">Organization Registration</div>
          <div class="auth-sub">Create your organization account in 1 minute.</div>

          <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <input type="hidden" name="role" value="organization">

            <div class="row">

              <div class="col-md-6 mb-3">
                <label class="form-label">Organization Name <span class="req">*</span></label>
                <input type="text" name="organization_name" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Owner Name <span class="req">*</span></label>
                <input type="text" name="name" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="+8801XXXXXXXXX">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Email <span class="req">*</span></label>
                <input type="email" name="email" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Organization Type</label>
                <select name="organization_type" class="form-control">
                  <option value="">Select type (optional)</option>
                  <option>NGO</option>
                  <option>Shelter</option>
                  <option>Food Bank</option>
                  <option>Community Kitchen</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Area, City, District">
              </div>

              {{-- Password --}}
              <div class="col-md-6 mb-3">
                <label class="form-label">Password <span class="req">*</span></label>
                <div class="pass-wrap">
                  <input id="org_pass" type="password" name="password" class="form-control" required>
                  <button type="button" class="eye-toggle" data-target="org_pass">
                    <svg class="icon-eye icon-show" viewBox="0 0 24 24" fill="none">
                      <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12Z" stroke="currentColor" stroke-width="2"/>
                      <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <svg class="icon-eye icon-hide" viewBox="0 0 24 24" fill="none">
                      <path d="M3 3l18 18" stroke="currentColor" stroke-width="2"/>
                    </svg>
                  </button>
                </div>
              </div>

              {{-- Confirm --}}
              <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password <span class="req">*</span></label>
                <div class="pass-wrap">
                  <input id="org_pass2" type="password" name="password_confirmation" class="form-control" required>
                  <button type="button" class="eye-toggle" data-target="org_pass2">
                    <svg class="icon-eye icon-show" viewBox="0 0 24 24" fill="none">
                      <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12Z" stroke="currentColor" stroke-width="2"/>
                      <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <svg class="icon-eye icon-hide" viewBox="0 0 24 24" fill="none">
                      <path d="M3 3l18 18" stroke="currentColor" stroke-width="2"/>
                    </svg>
                  </button>
                </div>
              </div>

            </div>

            <button class="btn-main">Register Organization</button>

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
  const input = document.getElementById(btn.dataset.target);
  if(!input) return;

  const show = input.type === "password";
  input.type = show ? "text" : "password";
  btn.classList.toggle("active", show);
});
</script>
@endsection
