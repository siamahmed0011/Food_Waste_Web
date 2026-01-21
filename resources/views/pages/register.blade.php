@extends('layouts.main')

@section('title','Registration')

@section('content')
<section class="py-5" style="background:url('/images/blur-bg.jpg') center/cover no-repeat;">
    <div class="container text-white">

        <h2 class="text-center mb-4">REGISTRATION</h2>

        <div class="row justify-content-center g-4">

            {{-- Organizations card --}}
            <div class="col-md-5">
                <div class="card p-4 text-white" style="background:rgba(0,0,0,.7);">
                    <h3>For <span style="color:#32ff7e;">Organizations</span></h3>
                    <p>
                        Join our food donation platform and make a significant impact
                        in the fight against hunger.
                    </p>
                    <a href="{{ route('register.organization') }}" class="btn btn-warning mt-2">
                        Register
                    </a>
                </div>
            </div>

            {{-- Donors card --}}
            <div class="col-md-5">
                <div class="card p-4 text-white" style="background:rgba(0,0,0,.7);">
                    <h3>For <span style="color:#32ff7e;">Donors</span></h3>
                    <p>
                        Register as a donor and share your surplus food to help those in need.
                    </p>
                    <a href="{{ route('register.donor') }}" class="btn btn-warning mt-2">
                        Register
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
