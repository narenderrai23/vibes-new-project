@extends('layouts.auth')

@section('title', __('Register'))

@section('content')
<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <x-auth-session-status class="text-center" :status="session('status')" />

    @if ($errors->any())
        <div class="rounded-md bg-red-50 p-3 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-6">
        @csrf

        <x-forms.group name="name" label="Full Name" required>
            <x-forms.input class="w-full" type="text" name="name" value="{{ old('name') }}" required autofocus />
        </x-forms.group>

        <x-forms.group name="email" label="Email Address" required>
            <x-forms.input class="w-full" type="email" name="email" value="{{ old('email') }}" required />
        </x-forms.group>

        <x-forms.group name="password" label="Password" required>
            <x-forms.input class="w-full" type="password" name="password" required />
        </x-forms.group>

        <x-forms.group name="password_confirmation" label="Confirm Password" required>
            <x-forms.input class="w-full" type="password" name="password_confirmation" required />
        </x-forms.group>

        <x-ui.button class="w-full" variant="primary" type="submit">
            {{ __('Create account') }}
        </x-ui.button>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 tracking-widest dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <x-ui.link class="text-sm" :href="route('login')">{{ __('Log in') }}</x-ui.link>
    </div>
</div>
@endsection
