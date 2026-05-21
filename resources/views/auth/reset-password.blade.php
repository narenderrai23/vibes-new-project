@extends('layouts.auth')

@section('title', __('Reset Password'))

@section('content')
<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

    <x-auth-session-status class="text-center" :status="session('status')" />

    @if ($errors->any())
        <div class="rounded-md bg-red-50 p-3 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST" class="flex flex-col gap-6">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <x-forms.group name="email" label="Email Address" required>
            <x-forms.input class="w-full" type="email" name="email" value="{{ old('email', $email) }}" required autofocus />
        </x-forms.group>

        <x-forms.group name="password" label="Password" required>
            <x-forms.input class="w-full" type="password" name="password" required />
        </x-forms.group>

        <x-forms.group name="password_confirmation" label="Confirm Password" required>
            <x-forms.input class="w-full" type="password" name="password_confirmation" required />
        </x-forms.group>

        <x-ui.button class="w-full" variant="primary" type="submit">
            {{ __('Reset password') }}
        </x-ui.button>
    </form>
</div>
@endsection
