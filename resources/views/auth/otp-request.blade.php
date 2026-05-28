@extends('layouts.auth')

@section('title', __('OTP Login'))

@section('panel-bg', 'linear-gradient(135deg, #1a1f36 0%, #2d3561 100%)')
@section('btn-color', '#4f46e5')
@section('link-color', '#4f46e5')

@section('panel-content')
    <h1 class="text-white fs-40 fw-bold">
        Secure sign in<br>with a one-time code.
    </h1>
    <p class="text-white fs-20 fw-semibold text-center">
        Choose Gmail OTP or SMS OTP to sign in quickly without a password.
    </p>
@endsection

@section('content')
<form method="POST" action="{{ route($sendOtpRoute) }}">
    @csrf

    <div class="text-center mb-4">
        <h2 class="fs-28 fw-bold mb-1">{{ __('OTP Login') }}</h2>
        <p class="text-muted">{{ __('Enter your email and choose how you want to receive a one-time login code.') }}</p>
        <x-auth-session-status class="text-center mt-2" :status="session('status')" />
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2 px-3 mb-4 fs-14" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <label class="form-label" for="email">{{ __('Email Address') }}</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
        @error('email')
            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('Send code via') }}</label>
        <div class="d-flex gap-3">
            <label class="btn btn-outline-light flex-fill">
                <input type="radio" name="method" value="email" class="btn-check" autocomplete="off" {{ old('method', 'email') === 'email' ? 'checked' : '' }}>
                {{ __('Email OTP') }}
            </label>
            <label class="btn btn-outline-light flex-fill">
                <input type="radio" name="method" value="sms" class="btn-check" autocomplete="off" {{ old('method') === 'sms' ? 'checked' : '' }}>
                {{ __('SMS OTP') }}
            </label>
        </div>
        @error('method')
            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-16 fw-semibold">{{ __('Send OTP Code') }}</button>
    </div>

    <div class="text-center">
        <a href="{{ route($loginRoute) }}" class="text-decoration-none fw-semibold">{{ __('Back to login') }}</a>
    </div>
</form>
@endsection
