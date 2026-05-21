@extends('layouts.auth')

@section('title', __('Verify Email'))

@section('content')
<div class="mt-4 flex flex-col gap-6">
    <div class="text-center">
        {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
    </div>

    @if (session('status') === 'verification-link-sent')
        <div class="text-center font-medium text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <form action="{{ route('verification.send') }}" method="POST" class="w-full">
            @csrf
            <x-ui.button class="w-full" variant="primary" type="submit">
                {{ __('Resend Verification Email') }}
            </x-ui.button>
        </form>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm text-zinc-600 underline hover:text-zinc-900 dark:text-zinc-400">
                {{ __('Log out') }}
            </button>
        </form>
    </div>
</div>
@endsection
