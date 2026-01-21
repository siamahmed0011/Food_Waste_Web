@extends('layouts.main')

@section('title', 'Login')

@section('content')
<style>
    .auth-container {
        max-width: 450px;
        margin: 60px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;

        /* Light Blue Gradient Shadow */
        box-shadow: 0 4px 20px rgba(0, 120, 255, 0.18);
    }

    .auth-title {
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 10px;

        /* Light Blue Title */
        color: #0a3d75;
    }

    .auth-subtitle {
        text-align: center;
        color: #4e6e94;
        margin-bottom: 25px;
        font-size: 1rem;
    }

    .auth-field label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: #244a73;
    }

    .auth-field input {
        width: 100%;
        padding: 12px;
        border: 1px solid #9bbde0;
        border-radius: 8px;
        font-size: 1rem;
        outline: none;
        transition: 0.2s;

        /* Light blue input background */
        background: #f5f9ff;
    }

    .auth-field input:focus {
        border-color: #5da7ff;
        box-shadow: 0 0 6px rgba(93, 167, 255, 0.45);
    }

    .auth-btn {
        width: 100%;
        padding: 12px;

        /* Light gradient blue button */
        background: linear-gradient(135deg, #57a7ff, #2f80ed);

        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        margin-top: 10px;
        cursor: pointer;
        transition: 0.25s;
    }

    .auth-btn:hover {
        background: linear-gradient(135deg, #2f80ed, #1b63c6);
    }

    .auth-bottom {
        text-align: center;
        margin-top: 18px;
        font-size: 1rem;
        color: #2f4d72;
    }

    .auth-bottom a {
        color: #2f80ed;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }

    .auth-bottom a:hover {
        text-decoration: underline;
    }
</style>



<div class="auth-container">

    <h2 class="auth-title">Login</h2>
    <p class="auth-subtitle">Welcome back! Please sign in to continue.</p>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="auth-field">
            <label for="email">Email</label>
            <input type="email" name="email" required value="{{ old('email') }}">
        </div>

        <div class="auth-field" style="margin-top: 15px;">
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>

        <button class="auth-btn">Login</button>
    </form>

    <p class="auth-bottom">
        New here? <a href="{{ route('register.donor') }}">Create an account</a>
    </p>

</div>
@endsection
