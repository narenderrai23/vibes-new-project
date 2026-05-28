@extends('layouts.auth')

@section('title', __('Verify OTP'))

@section('panel-bg', 'linear-gradient(135deg, #1a1f36 0%, #2d3561 100%)')
@section('btn-color', '#4f46e5')
@section('link-color', '#4f46e5')

@section('panel-content')
    <div class="text-center mb-3">
        <span style="font-size:4rem;">✅</span>
    </div>
    <h1 class="text-white fs-36 fw-bold text-center">
        Verify your code<br>and sign in.
    </h1>
    <div class="my-4 mx-auto authen-overlay-img">
        <img src="{{ asset('assets/img/bg/authentication-bg-01.png') }}" alt="">
    </div>
    <p class="text-white fs-18 fw-semibold text-center">
        Enter the 4-digit code we<br>just sent to complete<br>your secure sign in.
    </p>
@endsection

@section('content')
@php
    $channelLabel = $method === 'sms' ? __('SMS') : __('Email');
    $maskedTarget = $method === 'sms'
        ? preg_replace('/.(?=.{4})/', '•', $identifier)
        : (function ($e) {
            [$user, $domain] = array_pad(explode('@', $e, 2), 2, '');
            $maskedUser = strlen($user) <= 2 ? $user : substr($user, 0, 2) . str_repeat('•', max(strlen($user) - 2, 1));
            return $maskedUser . ($domain !== '' ? '@' . $domain : '');
        })($identifier);
@endphp

<form method="POST" action="{{ route($authenticateOtpRoute) }}" id="otpVerifyForm">
    @csrf

    <div class="text-center mb-4">
        <h2 class="fs-28 fw-bold mb-1">{{ __('Enter your code') }}</h2>
        <p class="text-muted mb-1">
            {{ __('We sent a 4-digit code via') }} <strong>{{ $channelLabel }}</strong> {{ __('to') }}
        </p>
        <p class="fw-semibold text-dark mb-0">{{ $maskedTarget }}</p>
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

    <input type="hidden" name="identifier" value="{{ $identifier }}">
    <input type="hidden" name="method" value="{{ $method }}">
    <input type="hidden" name="otp_code" id="otp_code" value="{{ old('otp_code') }}">

    <div class="mb-4">
        <label class="form-label d-block text-center mb-3">{{ __('One-Time Code') }}</label>
        <div class="otp-input-group digit-group d-flex justify-content-center gap-2" data-autosubmit="true">
            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" id="digit1"
                   class="otp-digit form-control text-center @error('otp_code') is-invalid @enderror"
                   data-otp-index="0" autocomplete="one-time-code" autofocus data-next="digit2">
            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" id="digit2"
                   class="otp-digit form-control text-center @error('otp_code') is-invalid @enderror"
                   data-otp-index="1" autocomplete="one-time-code" data-previous="digit1" data-next="digit3">
            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" id="digit3"
                   class="otp-digit form-control text-center @error('otp_code') is-invalid @enderror"
                   data-otp-index="2" autocomplete="one-time-code" data-previous="digit2" data-next="digit4">
            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" id="digit4"
                   class="otp-digit form-control text-center @error('otp_code') is-invalid @enderror"
                   data-otp-index="3" autocomplete="one-time-code" data-previous="digit3">
        </div>
        @error('otp_code')
            <div class="invalid-feedback d-block mt-2 text-center">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-16 fw-semibold">{{ __('Verify Code') }}</button>
    </div>

    <div class="text-center">
        <a href="{{ route($loginRoute) }}" class="text-decoration-none fw-semibold">{{ __('Back to login') }}</a>
    </div>
</form>

@push('styles')
<style>
    .otp-digit {
        width: 56px;
        height: 56px;
        font-size: 24px;
        font-weight: 600;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        transition: all .15s ease;
        padding: 0;
    }
    .otp-digit:focus {
        border-color: #4f46e5;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, .18);
        outline: none;
    }
    .otp-digit.filled,
    .otp-digit.active {
        border-color: #4f46e5;
        background: #ede9fe;
        color: #4f46e5;
    }
    @media (max-width: 380px) {
        .otp-digit { width: 48px; height: 48px; font-size: 20px; }
    }
</style>
@endpush

@push('after-scripts')
<script src="{{ asset('assets/js/otp.js') }}"></script>

<script>
(function () {
    const digits = document.querySelectorAll('.otp-digit');
    const hidden = document.getElementById('otp_code');

    const sync = () => {
        const value = Array.from(digits).map(d => d.value).join('');
        hidden.value = value;
    };

    digits.forEach((input) => {
        input.addEventListener('input', () => {
            sync();
        });
    });
})();
</script>
@endpush
@endsection
