@extends('layouts.main')

@section('title', 'Login')

@push('styles')
<style>
  .auth-wrapper{
    min-height: calc(100vh - 90px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding: 60px 16px;
    background:
      radial-gradient(900px 400px at 15% 10%, rgba(34,197,94,.18), transparent 60%),
      radial-gradient(800px 400px at 90% 20%, rgba(14,165,233,.18), transparent 55%),
      linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
  }

  .auth-card{
    width:100%;
    max-width: 420px;
    border-radius: 18px;
    padding: 26px;
    background: rgba(255,255,255,.78);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.6);
    box-shadow: 0 25px 55px rgba(15,23,42,.18);
  }

  .auth-title{
    font-size: 1.9rem;
    font-weight: 800;
    text-align:center;
    margin-bottom: 6px;
    color:#0f172a;
  }

  .auth-subtitle{
    text-align:center;
    color:#64748b;
    font-size: .95rem;
    margin-bottom: 22px;
  }

  .auth-field{
    margin-bottom: 14px;
  }

  .auth-field label{
    font-weight: 600;
    font-size: .9rem;
    color:#334155;
    margin-bottom: 6px;
    display:block;
  }

  .auth-field input{
    width:100%;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
    font-size: .95rem;
    transition: .2s ease;
  }

  .auth-field input:focus{
    outline:none;
    border-color:#22c55e;
    box-shadow: 0 0 0 3px rgba(34,197,94,.18);
    background:#fff;
  }

  .auth-btn{
    width:100%;
    margin-top: 8px;
    padding: 12px;
    border-radius: 12px;
    border:none;
    font-weight: 700;
    font-size: 1rem;
    color:#fff;
    cursor:pointer;
    background: linear-gradient(135deg, #22c55e, #14b8a6);
    transition: .25s ease;
  }

  .auth-btn:hover{
    transform: translateY(-1px);
    box-shadow: 0 12px 25px rgba(20,184,166,.35);
  }

  .auth-divider{
    text-align:center;
    margin: 18px 0 14px;
    font-size:.85rem;
    color:#94a3b8;
  }

  .auth-bottom{
    text-align:center;
    font-size:.95rem;
    color:#475569;
  }

  .auth-bottom a{
    font-weight:700;
    color:#16a34a;
    text-decoration:none;
  }

  .auth-bottom a:hover{
    text-decoration:underline;
  }
</style>
@endpush

@section('content')
<section class="auth-wrapper">

  <div class="auth-card">

    <h2 class="auth-title">Welcome Back 👋</h2>
    <p class="auth-subtitle">
      Sign in to manage donations and pickups
    </p>

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      <div class="auth-field">
        <label>Email address</label>
        <input type="email" name="email" required value="{{ old('email') }}" placeholder="you@example.com">
      </div>

      <div class="auth-field">
        <label>Password</label>
        <input type="password" name="password" required placeholder="••••••••">
      </div>

      <button type="submit" class="auth-btn">
        Sign In
      </button>
    </form>

    <div class="auth-divider">
      Don’t have an account?
    </div>

    <p class="auth-bottom">
      <a href="{{ route('signup.choice') }}">Create a new account</a>
    </p>

  </div>

</section>
@endsection
