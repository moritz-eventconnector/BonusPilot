@extends('layouts.app')

@section('content')
<div class="card" style="max-width:480px;margin:0 auto;">
    <h1>{{ __('ui.auth.title') }}</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label>{{ __('ui.auth.email') }}</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div style="color:#dc2626">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>{{ __('ui.auth.password') }}</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label class="remember-option">
                <input type="checkbox" name="remember">
                <span>{{ __('ui.auth.remember') }}</span>
            </label>
        </div>
        <button class="btn" type="submit">{{ __('ui.auth.login') }}</button>
    </form>
</div>
@endsection
