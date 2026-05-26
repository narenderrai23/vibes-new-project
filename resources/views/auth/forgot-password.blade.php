@extends('layouts.auth')

@section('title', __('Forgot Password'))

@section('content')
<form action="{{ route('password.email') }}" method="POST">
    @csrf

    <div class="text-center mb-4">
        <h2 class="fs-28 fw-bold mb-1">{{ __('Forgot password') }}</h2>
        <p class="text-muted">{{ __('Enter your email to receive a password reset link') }}</p>

        <!-- Session Status -->
        <x-auth-session-status class="text-center mt-2 text-success fw-semibold" :status="session('status')" />
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

    <div class="mb-4">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-16 fw-semibold">{{ __('Email password reset link') }}</button>
    </div>

    <div class="text-center mb-4">
        <h6 class="fw-normal text-dark mb-0">
            {{ __('Or, return to') }}
            <a href="{{ route('login') }}" class="hover-a fw-semibold text-primary ms-1">{{ __('Log in') }}</a>
        </h6>
    </div>
</form>
@endsection
