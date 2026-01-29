@extends('layouts.main')

@section('title','Registration')

@push('styles')
<style>
  .reg-hero{
    min-height: calc(100vh - 90px);
    display:flex;
    align-items:center;
    padding: 56px 0;
    background:
      radial-gradient(1200px 500px at 20% 10%, rgba(34,197,94,.18), transparent 60%),
      radial-gradient(900px 450px at 90% 20%, rgba(14,165,233,.18), transparent 55%),
      linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
  }

  .reg-wrap{
    max-width: 980px;
    margin: 0 auto;
  }

  .reg-title{
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
    color:#0f172a;
    text-align:center;
    margin-bottom: 8px;
  }

  .reg-subtitle{
    text-align:center;
    color:#64748b;
    max-width: 720px;
    margin: 0 auto 26px;
    line-height: 1.6;
  }

  .reg-grid{
    display:grid;
    grid-template-columns: 1fr;
    gap: 18px;
  }

  @media (min-width: 992px){
    .reg-grid{ grid-template-columns: 1fr 1fr; gap: 22px; }
  }

  .reg-card{
    position:relative;
    overflow:hidden;
    border-radius: 18px;
    border: 1px solid rgba(255,255,255,.6);
    background: rgba(255,255,255,.72);
    backdrop-filter: blur(10px);
    box-shadow: 0 18px 45px rgba(15,23,42,.12);
    padding: 22px 22px;
    transition: transform .18s ease, box-shadow .18s ease;
  }

  .reg-card:hover{
    transform: translateY(-4px);
    box-shadow: 0 24px 60px rgba(15,23,42,.18);
  }

  .reg-card::before{
    content:"";
    position:absolute;
    inset:-2px;
    background: linear-gradient(135deg, rgba(34,197,94,.35), rgba(14,165,233,.28), rgba(249,168,37,.18));
    opacity:.55;
    filter: blur(18px);
    z-index:0;
  }

  .reg-card-inner{
    position:relative;
    z-index:1;
    background: rgba(255,255,255,.78);
    border: 1px solid rgba(255,255,255,.55);
    border-radius: 16px;
    padding: 22px;
  }

  .reg-icon{
    width:52px; height:52px;
    border-radius: 14px;
    display:flex; align-items:center; justify-content:center;
    font-size: 22px;
    background: rgba(34,197,94,.12);
    color: #166534;
    margin-bottom: 14px;
  }

  .reg-card.org .reg-icon{
    background: rgba(14,165,233,.12);
    color:#075985;
  }

  .reg-card h3{
    font-weight: 800;
    margin: 0 0 8px;
    color:#0f172a;
  }

  .reg-card p{
    margin: 0 0 16px;
    color:#475569;
    line-height: 1.65;
  }

  .reg-bullets{
    padding-left: 18px;
    margin: 0 0 18px;
    color:#475569;
  }

  .reg-bullets li{ margin-bottom: 6px; }

  .reg-actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    align-items:center;
  }

  .btn-reg{
    border-radius: 12px;
    padding: 10px 14px;
    font-weight: 700;
  }

  .btn-org{
    background: #0ea5e9;
    border-color: #0ea5e9;
    color:#fff;
  }
  .btn-org:hover{ background:#0284c7; border-color:#0284c7; }

  .btn-donor{
    background: #16a34a;
    border-color:#16a34a;
    color:#fff;
  }
  .btn-donor:hover{ background:#15803d; border-color:#15803d; }

  .btn-ghost{
    border-radius: 12px;
    padding: 10px 14px;
    font-weight: 700;
    background: transparent;
    border: 1px solid rgba(15,23,42,.12);
    color:#0f172a;
  }
  .btn-ghost:hover{
    background: rgba(15,23,42,.04);
  }

  .reg-note{
    text-align:center;
    margin-top: 16px;
    color:#64748b;
    font-size: .9rem;
  }
</style>
@endpush

@section('content')
<section class="reg-hero">
  <div class="container">
    <div class="reg-wrap">

      <h2 class="reg-title">Registration</h2>
      <p class="reg-subtitle">
        Choose your role to get started. Donors post surplus food, and verified organizations request pickup and distribute safely.
      </p>

      <div class="reg-grid">

        {{-- Organizations --}}
        <div class="reg-card org">
          <div class="reg-card-inner">
            <div class="reg-icon">🏢</div>
            <h3>For Organizations</h3>
            <p>
              Register your NGO / shelter to receive verified donations, request pickups, and keep distribution records.
            </p>

            <ul class="reg-bullets">
              <li>Browse nearby donations</li>
              <li>Request pickup in real-time</li>
              <li>Track pickup & delivery status</li>
            </ul>

            <div class="reg-actions">
              <a href="{{ route('register.organization') }}" class="btn btn-reg btn-org">
                Register Organization →
              </a>
            </div>
          </div>
        </div>

        {{-- Donors --}}
        <div class="reg-card donor">
          <div class="reg-card-inner">
            <div class="reg-icon">🤝</div>
            <h3>For Donors</h3>
            <p>
              Share safe extra food from home, restaurant, or events. Nearby organizations can request pickup before expiry.
            </p>

            <ul class="reg-bullets">
              <li>Post food in under a minute</li>
              <li>Set pickup window & expiry</li>
              <li>Manage your donation history</li>
            </ul>

            <div class="reg-actions">
              <a href="{{ route('register.donor') }}" class="btn btn-reg btn-donor">
                Register as Donor →
              </a>
            </div>
          </div>
        </div>

      </div>

      <div class="reg-note">
        Already have an account? <a href="{{ route('login') }}">Sign In</a>
      </div>

    </div>
  </div>
</section>
@endsection
