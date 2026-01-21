@extends('layouts.main') {{-- layout name adjust kore nao --}}

@section('title', 'NGO Dashboard')

@section('content')
    <div class="container">
        <h1>Add New NGO</h1>

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ngos.store') }}" method="POST">
            @csrf

            <div>
                <label>Name:</label><br>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div>
                <label>Email:</label><br>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label>Phone:</label><br>
                <input type="text" name="phone" value="{{ old('phone') }}">
            </div>

            <div>
                <label>Address:</label><br>
                <textarea name="address">{{ old('address') }}</textarea>
            </div>

            <div>
                <label>Status:</label><br>
                <select name="status" required>
                    <option value="pending" selected>Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <br>
            <button type="submit">Save NGO</button>
        </form>
    </div>
@endsection
