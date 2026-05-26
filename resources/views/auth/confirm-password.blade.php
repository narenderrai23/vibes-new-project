@extends('layouts.auth')

@section('title', __('Confirm Password'))

@section('content')
<form action="{{ route('password.confirm') }}" method="POST">
    @csrf

    <div class="text-center mb-4">
        <h2 class="fs-28 fw-bold mb-1">{{ __('Confirm password') }}</h2>
        <p class="text-muted">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
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
        <label class="form-label" for="password">{{ __('Password') }}</label>
        <div class="pass-group">
            <input type="password" name="password" id="password" class="pass-input form-control @error('password') is-invalid @enderror" required autofocus>
            <span class="ti toggle-password ti-eye-off"></span>
        </div>
        @error('password')
            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <button type="submit" class="btn btn-primary w-100 py-2 fs-16 fw-semibold">{{ __('Confirm') }}</button>
    </div>
</form>
@endsection
