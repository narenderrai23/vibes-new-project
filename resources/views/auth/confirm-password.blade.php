@extends('layouts.auth')

@section('title', __('Confirm Password'))

@section('content')
<div class="flex flex-col gap-6">
    <x-auth-header
        :title="__('Confirm password')"
        :description="__('This is a secure area of the application. Please confirm your password before continuing.')"
    />

    @if ($errors->any())
        <div class="rounded-md bg-red-50 p-3 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('password.confirm') }}" method="POST" class="flex flex-col gap-6">
        @csrf

        <x-forms.group name="password" label="Password" required>
            <x-forms.input class="w-full" type="password" name="password" required autofocus />
        </x-forms.group>

        <x-ui.button class="w-full" variant="primary" type="submit">
            {{ __('Confirm') }}
        </x-ui.button>
    </form>
</div>
@endsection
