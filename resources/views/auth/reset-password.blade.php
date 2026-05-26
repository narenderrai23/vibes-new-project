@extends('layouts.auth')

@section('title', __('Reset Password'))

@section('content')
<form action="{{ route('password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="text-center mb-4">
        <h2 class="fs-28 fw-bold mb-1">{{ __('Reset password') }}</h2>
        <p class="text-muted">{{ __('Please enter your new password below') }}</p>

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
            <input type="email" name="email" id="email" value="{{ old('email', $email) }}" class="form-control border-end-0 @error('email') is-invalid @enderror" required autofocus>
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

    <div class="mb-3">
        <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
        <div class="pass-group">
            <input type="password" name="password_confirmation" id="password_confirmation" class="pass-input form-control @error('password_confirmation') is-invalid @enderror" required>
            <span class="ti toggle-password ti-eye-off"></span>
        </div>
        @error('password_confirmation')
            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-16 fw-semibold">{{ __('Reset password') }}</button>
    </div>
</form>
@endsection
