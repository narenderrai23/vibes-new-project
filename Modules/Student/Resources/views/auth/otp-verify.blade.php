@extends('layouts.auth')

@section('title', __('Verify Student OTP'))

{{-- Student — blue gradient panel --}}
@section('panel-bg', 'linear-gradient(135deg, #0f4c81 0%, #1a8fe3 100%)')
@section('btn-color', '#1a8fe3')
@section('link-color', '#1a8fe3')

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
        <span class="badge px-3 py-2 mb-2 fw-semibold fs-13"
              style="background:#e8f4fd; color:#1a8fe3; border-radius:20px;">
            <i class="ti ti-shield-check me-1"></i>{{ $channelLabel }} OTP
        </span>
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
        <div class="otp-input-group d-flex justify-content-center gap-2">
            @for ($i = 0; $i < 4; $i++)
                <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1"
                       class="otp-digit form-control text-center @error('otp_code') is-invalid @enderror"
                       data-otp-index="{{ $i }}" autocomplete="one-time-code"
                       {{ $i === 0 ? 'autofocus' : '' }}>
            @endfor
        </div>
        @error('otp_code')
            <div class="invalid-feedback d-block mt-2 text-center">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <button type="submit" class="portal-btn btn w-100 py-2 fs-16 fw-semibold text-white">
            <i class="ti ti-login me-1"></i>{{ __('Verify & Sign In') }}
        </button>
    </div>

    <div class="text-center mb-2">
        <span class="text-muted fs-13">{{ __("Didn't receive the code?") }}</span>
        <a href="{{ route('student.login.otp.request') }}" class="portal-link text-decoration-none fs-13 ms-1">
            {{ __('Resend') }}
        </a>
    </div>

    <div class="text-center">
        <a href="{{ route($loginRoute) }}" class="portal-link text-decoration-none fs-13">
            <i class="ti ti-arrow-left me-1"></i>{{ __('Back to login') }}
        </a>
    </div>
</form>

@push('styles')
<style>
    .otp-digit {
        width: 48px;
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
        border-color: #1a8fe3;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(26,143,227,.18);
        outline: none;
    }
    .otp-digit.filled {
        border-color: #1a8fe3;
        background: #e8f4fd;
        color: #0f4c81;
    }
    @media (max-width: 380px) {
        .otp-digit { width: 40px; height: 48px; font-size: 20px; }
    }
</style>
@endpush

@push('after-scripts')
	<script src="{{ asset('assets/js/otp.js') }}"></script>

<script>
(function () {
    const digits = document.querySelectorAll('.otp-digit');
    const hidden = document.getElementById('otp_code');
    const form   = document.getElementById('otpVerifyForm');

    const sync = () => {
        const value = Array.from(digits).map(d => d.value).join('');
        hidden.value = value;
        digits.forEach(d => d.classList.toggle('filled', d.value !== ''));
        return value;
    };

    const prefill = (hidden.value || '').toString().slice(0, digits.length);
    if (prefill) {
        prefill.split('').forEach((ch, i) => { if (digits[i]) digits[i].value = ch; });
        sync();
    }

    digits.forEach((input, idx) => {
        input.addEventListener('input', (e) => {
            const v = e.target.value.replace(/\D/g, '');
            e.target.value = v.slice(-1);
            if (e.target.value && idx < digits.length - 1) digits[idx + 1].focus();
            if (sync().length === digits.length) form.submit();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && idx > 0) {
                digits[idx - 1].focus();
                digits[idx - 1].value = '';
                sync();
            }
            if (e.key === 'ArrowLeft' && idx > 0) digits[idx - 1].focus();
            if (e.key === 'ArrowRight' && idx < digits.length - 1) digits[idx + 1].focus();
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, digits.length);
            if (!text) return;
            text.split('').forEach((ch, i) => { if (digits[i]) digits[i].value = ch; });
            const next = Math.min(text.length, digits.length - 1);
            digits[next].focus();
            if (sync().length === digits.length) form.submit();
        });
    });
})();
</script>
@endpush
@endsection
