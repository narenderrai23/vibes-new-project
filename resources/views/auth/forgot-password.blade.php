@extends('layouts.auth')

@section('title', __('Forgot Password'))

@section('content')
<div class="flex flex-col gap-6">
    <x-auth-header
        :title="__('Forgot password')"
        :description="__('Enter your email to receive a password reset link')"
    />

    <x-auth-session-status class="text-center" :status="session('status')" />

    @if ($errors->any())
        <div class="rounded-md bg-red-50 p-3 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST" class="flex flex-col gap-6">
        @csrf

        <x-forms.group name="email" label="Email Address" required>
            <x-forms.input class="w-full" type="email" name="email" value="{{ old('email') }}" required autofocus />
        </x-forms.group>

        <x-ui.button class="w-full" variant="primary" type="submit">
            {{ __('Email password reset link') }}
        </x-ui.button>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600">
        {{ __('Or, return to') }}
        <x-ui.link class="text-sm" :href="route('login')">{{ __('log in') }}</x-ui.link>
    </div>
</div>
@endsection
