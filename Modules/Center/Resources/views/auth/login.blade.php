@extends('layouts.auth')

@section('title', __('Center Login'))

{{-- Center — amber/orange gradient panel --}}
@section('panel-bg', 'linear-gradient(135deg, #7c3a00 0%, #e07b00 100%)')
@section('btn-color', '#e07b00')
@section('link-color', '#e07b00')

@section('panel-content')
    <div class="text-center mb-3">
        <span style="font-size:4rem;">🏥</span>
    </div>
    <h1 class="text-white fs-36 fw-bold text-center">
        Serve. Care.<br>Excel.
    </h1>
    <div class="my-4 mx-auto authen-overlay-img">
        <img src="{{ asset('assets/img/bg/authentication-bg-01.png') }}" alt="">
    </div>
    <p class="text-white fs-18 fw-semibold text-center">
        Manage appointments,<br>staff &amp; daily operations<br>from one place.
    </p>
@endsection

@section('content')
<form method="POST" action="{{ route('center.login') }}">
    @csrf

    <div class="text-center mb-4">
        <span class="badge px-3 py-2 mb-2 fw-semibold fs-13"
              style="background:#fff3e0; color:#e07b00; border-radius:20px;">
            <i class="ti ti-building-hospital me-1"></i>Center Portal
        </span>
        <h2 class="fs-28 fw-bold mb-1">{{ __('Welcome Back') }}</h2>
        <p class="text-muted">{{ __('Sign in to your center account') }}</p>
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
        <div class="input-group">
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                   class="form-control border-end-0 @error('email') is-invalid @enderror"
                   placeholder="center@example.com" required autofocus>
            <span class="input-group-text border-start-0">
                <i class="ti ti-mail"></i>
            </span>
        </div>
        @error('email')
            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label" for="password">{{ __('Password') }}</label>
        <div class="pass-group">
            <input type="password" name="password" id="password"
                   class="pass-input form-control @error('password') is-invalid @enderror" required>
            <span class="ti toggle-password ti-eye-off"></span>
        </div>
        @error('password')
            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-check form-check-md mb-4">
        <input class="form-check-input" id="remember_me" name="remember" type="checkbox"
               {{ old('remember') ? 'checked' : '' }}>
        <label for="remember_me" class="form-check-label mt-0">{{ __('Remember Me') }}</label>
    </div>

    <div class="mb-3">
        <button type="submit"
                class="portal-btn btn w-100 py-2 fs-16 fw-semibold text-white">
            <i class="ti ti-login me-1"></i>{{ __('Sign In') }}
        </button>
    </div>

    <div class="text-center mb-3">
        <a href="{{ route('center.login.otp.request') }}" class="portal-link text-decoration-none fs-13">{{ __('Sign in with Email or SMS OTP') }}</a>
    </div>

    <div class="text-center">
        <a href="{{ route('admin.login') }}" class="portal-link text-decoration-none fs-13">
            <i class="ti ti-arrow-left me-1"></i>Back to Admin Login
        </a>
    </div>
</form>
@endsection
