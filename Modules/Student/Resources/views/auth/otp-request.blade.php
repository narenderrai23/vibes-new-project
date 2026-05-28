@extends('layouts.auth')

@section('title', __('Student OTP Login'))

{{-- Student — blue gradient panel --}}
@section('panel-bg', 'linear-gradient(135deg, #0f4c81 0%, #1a8fe3 100%)')
@section('btn-color', '#1a8fe3')
@section('link-color', '#1a8fe3')

@section('panel-content')
    <div class="text-center mb-3">
        <span style="font-size:4rem;">🔐</span>
    </div>
    <h1 class="text-white fs-36 fw-bold text-center">
        Passwordless<br>sign in.
    </h1>
    <div class="my-4 mx-auto authen-overlay-img">
        <img src="{{ asset('assets/img/bg/authentication-bg-01.png') }}" alt="">
    </div>
    <p class="text-white fs-18 fw-semibold text-center">
        Choose Email or SMS<br>and receive a one-time<br>code to sign in.
    </p>
@endsection

@section('content')
@php
    $activeMethod = old('method', session('otp_method', 'email'));
@endphp

<div class="text-center mb-4">
    <span class="badge px-3 py-2 mb-2 fw-semibold fs-13"
          style="background:#e8f4fd; color:#1a8fe3; border-radius:20px;">
        <i class="ti ti-shield-lock me-1"></i>Student OTP Login
    </span>
    <h2 class="fs-28 fw-bold mb-1">{{ __('Get a one-time code') }}</h2>
    <p class="text-muted">{{ __('Pick a channel and we will send you a 4-digit code.') }}</p>
    <x-auth-session-status class="text-center mt-2" :status="session('status')" />
</div>

<ul class="nav nav-pills otp-tabs" id="otpMethodTabs" role="tablist">
    <li class="nav-item flex-fill" role="presentation">
        <button class="nav-link w-100 d-flex align-items-center justify-content-center gap-2 {{ $activeMethod === 'email' ? 'active' : '' }}"
                id="tab-email" data-bs-toggle="pill" data-bs-target="#pane-email"
                type="button" role="tab" aria-controls="pane-email"
                aria-selected="{{ $activeMethod === 'email' ? 'true' : 'false' }}">
            <i class="ti ti-mail-filled fs-18"></i>{{ __('Email OTP') }}
        </button>
    </li>
    <li class="nav-item flex-fill" role="presentation">
        <button class="nav-link w-100 d-flex align-items-center justify-content-center gap-2 {{ $activeMethod === 'sms' ? 'active' : '' }}"
                id="tab-sms" data-bs-toggle="pill" data-bs-target="#pane-sms"
                type="button" role="tab" aria-controls="pane-sms"
                aria-selected="{{ $activeMethod === 'sms' ? 'true' : 'false' }}">
            <i class="ti ti-device-mobile fs-18"></i>{{ __('SMS OTP') }}
        </button>
    </li>
</ul>

<div class="tab-content">
    {{-- Email tab --}}
    <div class="tab-pane fade {{ $activeMethod === 'email' ? 'show active' : '' }}"
         id="pane-email" role="tabpanel" aria-labelledby="tab-email">
        <form method="POST" action="{{ route($sendOtpRoute) }}">
            @csrf
            <input type="hidden" name="method" value="email">

            @if ($errors->any() && $activeMethod === 'email')
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
                    <input type="email" name="email" id="email"
                           value="{{ old('method') === 'email' ? old('email') : '' }}"
                           class="form-control border-end-0 @error('email') is-invalid @enderror"
                           placeholder="student@example.com"
                           {{ $activeMethod === 'email' ? 'required autofocus' : '' }}>
                    <span class="input-group-text border-start-0">
                        <i class="ti ti-mail"></i>
                    </span>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit" class="portal-btn btn w-100 py-2 fs-16 fw-semibold text-white">
                    <i class="ti ti-send me-1"></i>{{ __('Send Email OTP') }}
                </button>
            </div>
        </form>
    </div>

    {{-- SMS tab --}}
    <div class="tab-pane fade {{ $activeMethod === 'sms' ? 'show active' : '' }}"
         id="pane-sms" role="tabpanel" aria-labelledby="tab-sms">
        <form method="POST" action="{{ route($sendOtpRoute) }}">
            @csrf
            <input type="hidden" name="method" value="sms">

            @if ($errors->any() && $activeMethod === 'sms')
                <div class="alert alert-danger py-2 px-3 mb-4 fs-14" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label" for="mobile">{{ __('Mobile Number') }}</label>
                <div class="input-group">
                    <input type="tel" name="mobile" id="mobile"
                           value="{{ old('method') === 'sms' ? old('mobile') : '' }}"
                           class="form-control border-end-0 @error('mobile') is-invalid @enderror"
                           placeholder="+91 9876543210"
                           inputmode="tel" pattern="[0-9+\s\-]*"
                           {{ $activeMethod === 'sms' ? 'required autofocus' : '' }}>
                    <span class="input-group-text border-start-0">
                        <i class="ti ti-phone"></i>
                    </span>
                </div>
                @error('mobile')
                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit" class="portal-btn btn w-100 py-2 fs-16 fw-semibold text-white">
                    <i class="ti ti-send me-1"></i>{{ __('Send SMS OTP') }}
                </button>
            </div>
        </form>
    </div>
</div>

<div class="text-center mt-2">
    <a href="{{ route($loginRoute) }}" class="portal-link text-decoration-none fs-13">
        <i class="ti ti-arrow-left me-1"></i>{{ __('Back to password login') }}
    </a>
</div>

@push('styles')
<style>
    .otp-tabs {
        background: #f1f5f9;
        padding: 4px;
        border-radius: 12px;
        gap: 4px;
    }
    .otp-tabs .nav-link {
        color: #64748b;
        border-radius: 8px;
        font-weight: 600;
        padding: .55rem .75rem;
        background: transparent;
        border: none;
    }
    .otp-tabs .nav-link:hover {
        color: #1a8fe3;
    }
    .otp-tabs .nav-link.active {
        background: #fff;
        color: #0f4c81;
        box-shadow: 0 1px 3px rgba(15,76,129,.12);
    }
</style>
@endpush
@endsection
