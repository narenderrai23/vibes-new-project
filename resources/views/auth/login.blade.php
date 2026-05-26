@extends('layouts.auth')

@section('title', __('Log in'))

{{-- Admin — dark navy panel --}}
@section('panel-bg', 'linear-gradient(135deg, #1a1f36 0%, #2d3561 100%)')
@section('btn-color', '#4f46e5')
@section('link-color', '#4f46e5')

@section('panel-content')
    <h1 class="text-white fs-40 fw-bold">
        Manage your<br>organisation<br>with confidence.
    </h1>
    <div class="my-4 mx-auto authen-overlay-img">
        <img src="{{ asset('assets/img/bg/authentication-bg-01.png') }}" alt="">
    </div>
    <p class="text-white fs-20 fw-semibold text-center">
        Full control over users,<br>roles &amp; permissions.
    </p>
@endsection

@section('content')
<form action="{{ route('login') }}" method="POST">
    @csrf

    <div class="text-center mb-4">
        <h2 class="fs-28 fw-bold mb-1">{{ __('Sign In') }}</h2>
        <p class="text-muted">{{ __('Please enter your details to sign in') }}</p>

        <!-- Session Status -->
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
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control border-end-0 @error('email') is-invalid @enderror" required autofocus>
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
            <input type="password" name="password" id="password" class="pass-input form-control @error('password') is-invalid @enderror" required>
            <span class="ti toggle-password ti-eye-off"></span>
        </div>
        @error('password')
            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="form-check form-check-md mb-0">
            <input class="form-check-input" id="remember_me" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember_me" class="form-check-label mt-0">{{ __('Remember Me') }}</label>
        </div>
        @if (Route::has('password.request'))
            <div class="text-end">
                <a href="{{ route('password.request') }}" class="link-danger">{{ __('Forgot Password?') }}</a>
            </div>
        @endif
    </div>

    <div class="mb-4">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-16 fw-semibold">{{ __('Sign In') }}</button>
    </div>

    @if (Route::has('register'))
        <div class="text-center mb-4">
            <h6 class="fw-normal text-dark mb-0">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="hover-a fw-semibold text-primary ms-1">{{ __('Create Account') }}</a>
            </h6>
        </div>
    @endif

    <div class="login-or">
        <span class="span-or">{{ __('Or') }}</span>
    </div>

    <div class="mt-3">
        <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">
            <div class="text-center flex-fill">
                <a href="{{ route('social.login', 'facebook') }}"
                    class="br-10 p-2 btn btn-outline-light border d-flex align-items-center justify-content-center">
                    <img class="img-fluid m-1" src="{{ asset('assets/img/icons/facebook-logo.svg') }}" alt="Facebook" style="height: 20px;">
                </a>
            </div>
            <div class="text-center flex-fill">
                <a href="{{ route('social.login', 'google') }}"
                    class="br-10 p-2 btn btn-outline-light border d-flex align-items-center justify-content-center">
                    <img class="img-fluid m-1" src="{{ asset('assets/img/icons/google-logo.svg') }}" alt="Google" style="height: 20px;">
                </a>
            </div>
            <div class="text-center flex-fill">
                <a href="{{ route('social.login', 'apple') }}"
                    class="bg-dark br-10 p-2 btn btn-dark d-flex align-items-center justify-content-center">
                    <img class="img-fluid m-1" src="{{ asset('assets/img/icons/apple-logo.svg') }}" alt="Apple" style="height: 20px;">
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
