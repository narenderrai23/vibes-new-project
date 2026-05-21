@extends('layouts.auth')

@section('title', __('Log in'))

@section('content')
<div class="flex flex-col gap-6">
    <x-auth-header
        :title="__('Log in to your account')"
        :description="__('Enter your email and password below to log in')"
    />

    <x-auth-session-status class="text-center" :status="session('status')" />

    @if ($errors->any())
        <div class="rounded-md bg-red-50 p-3 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-6">
        @csrf

        <x-forms.group name="email" label="Email Address" required>
            <x-forms.input class="w-full" type="email" name="email" value="{{ old('email') }}" required autofocus />
        </x-forms.group>

        <x-forms.group name="password" label="Password" required>
            <x-forms.input class="w-full" type="password" name="password" required />
        </x-forms.group>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900">
                <label for="remember" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Remember me') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <x-ui.link class="text-sm" :href="route('password.request')">
                    {{ __('Forgot your password?') }}
                </x-ui.link>
            @endif
        </div>

        <x-ui.button class="w-full" variant="primary" type="submit">
            {{ __('Log in') }}
        </x-ui.button>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 text-center text-sm tracking-widest text-zinc-600 dark:text-zinc-400">
            {{ __("Don't have an account?") }}
            <x-ui.link :href="route('register')">{{ __('Sign up') }}</x-ui.link>
        </div>
    @endif
</div>
@endsection
