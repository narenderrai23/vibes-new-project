@extends('layouts.frontend')

@section('title', __('Change Password'))

@section('content')
<div class="container mx-auto max-w-7xl px-4 py-10 sm:px-6">

    @include('frontend.includes.messages')

    <div class="mb-10 md:grid md:grid-cols-3 md:gap-6">
        <div class="sm:col-span-1">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">@lang('Change Password')</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                @lang('Use the following form to change your account password!')
            </p>
            <div class="pt-4 text-center">
                <a href="{{ route('frontend.users.profile') }}">
                    <div class="w-full rounded-sm border-2 border-gray-900 px-6 py-2 text-sm font-semibold text-gray-500 transition hover:bg-gray-800 hover:text-white">
                        @lang('View Profile')
                    </div>
                </a>
            </div>
        </div>

        <div class="mt-5 sm:col-span-2 md:mt-0">
            <form action="{{ route('frontend.users.changePasswordUpdate') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="mb-8 rounded-lg border bg-white p-6 shadow-lg dark:bg-gray-100">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6 sm:col-span-3">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                @lang('Password') <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" id="password" required
                                class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                            @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                @lang('Confirm Password') <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                            @error('password_confirmation') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 text-end">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @lang('Update Password')
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
