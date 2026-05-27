@extends('layouts.auth')

@section('title', __('Verify Email'))

@section('content')
<div>
    <div class="text-center mb-4">
        <h2 class="fs-28 fw-bold mb-1">{{ __('Verify Email') }}</h2>
        <p class="text-muted">{{ __('Please verify your email address by clicking on the link we just emailed to you.') }}</p>
    </div>

    @if (session('status') === 'verification-link-sent')
        <div class="alert alert-success text-center py-2 px-3 mb-4 fs-14 fw-semibold" role="alert">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="d-flex flex-column align-items-center gap-3">
        <form action="{{ route('admin.verification.send') }}" method="POST" class="w-100">
            @csrf
            <button type="submit" class="btn btn-primary w-100 py-2 fs-16 fw-semibold">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form action="{{ route('admin.logout') }}" method="POST" class="w-100">
            @csrf
            <button type="submit" class="btn btn-link text-muted fs-14 w-100 text-center text-decoration-underline">
                {{ __('Log out') }}
            </button>
        </form>
    </div>
</div>
@endsection
