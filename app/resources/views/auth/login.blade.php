@extends('layouts.app')

@section('content')
<div class="card" style="max-width:480px;margin:0 auto;">
    <h1>Admin Login</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div style="color:#dc2626">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
        <button class="btn" type="submit">Login</button>
    </form>
</div>
@endsection
