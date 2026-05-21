@extends('layouts.frontend')

@section('title', __('Edit Profile'))

@section('content')
<div class="container mx-auto max-w-7xl px-4 py-10 sm:px-6">

    @include('frontend.includes.messages')

    {{-- Email Verification Alert --}}
    @if (Auth::user() && Auth::user()->email_verified_at === null)
        <div class="mb-6 rounded-lg border-2 border-yellow-400 bg-yellow-50 p-4">
            <h3 class="text-sm font-medium text-yellow-800">@lang('Email Not Verified')</h3>
            <p class="mt-1 text-sm text-yellow-700">
                @lang('Your email address has not been verified. Please check your inbox.')
            </p>
            <form action="{{ route('frontend.users.resendEmailConfirmation') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="rounded-md bg-yellow-50 px-3 py-2 text-sm font-medium text-yellow-800 hover:bg-yellow-100">
                    @lang('Resend Verification Email')
                </button>
            </form>
        </div>
    @endif

    <div class="mb-10 sm:grid sm:grid-cols-3 sm:gap-6">
        <div class="sm:col-span-1">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">@lang('Edit Profile')</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                @lang('This information will be displayed publicly so be careful what you share.')
            </p>
            <div class="pt-4 text-center">
                <a href="{{ route('frontend.users.profile') }}">
                    <div class="w-full rounded-sm border-2 border-gray-900 px-6 py-2 text-sm font-semibold text-gray-500 transition hover:bg-gray-800 hover:text-white">
                        @lang('View Profile')
                    </div>
                </a>
            </div>
        </div>

        <div class="mt-5 sm:col-span-2 sm:mt-0">
            <form action="{{ route('frontend.users.profileUpdate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="mb-8 rounded-lg border border-gray-400 bg-white p-6 shadow-lg dark:bg-gray-100">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6 sm:col-span-3">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">@lang('First Name') <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" required
                                class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                            @error('first_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">@lang('Last Name') <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" required
                                class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                            @error('last_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="mobile" class="block text-sm font-medium text-gray-700">@lang('Mobile')</label>
                            <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $user->mobile) }}"
                                class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                            @error('mobile') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">@lang('Date Of Birth')</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                                class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                            @error('date_of_birth') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6">
                            <label for="address" class="block text-sm font-medium text-gray-700">@lang('Address')</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                                class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                            @error('address') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6">
                            <label for="bio" class="block text-sm font-medium text-gray-700">@lang('Bio')</label>
                            <textarea name="bio" id="bio" rows="3"
                                class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="gender" class="block text-sm font-medium text-gray-700">@lang('Gender')</label>
                            <select name="gender" id="gender"
                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-3 shadow-sm focus:outline-none focus:ring-blue-500 text-sm">
                                <option value="">-- Select --</option>
                                <option value="Female" {{ old('gender', $user->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Male" {{ old('gender', $user->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Other" {{ old('gender', $user->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="avatar" class="block text-sm font-medium text-gray-700">@lang('Avatar')</label>
                            <input type="file" name="avatar" id="avatar" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:me-3 file:rounded-sm file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100">
                            @error('avatar') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <div class="mt-6 text-end">
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @lang('Save')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Connected Accounts --}}
    @if ($user->providers && $user->providers->count() > 0)
        <div class="mb-10 mt-10 sm:mt-0">
            <div class="sm:grid sm:grid-cols-3 sm:gap-6">
                <div class="sm:col-span-1">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Connected Accounts</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage your social authentication providers.</p>
                </div>
                <div class="mt-5 sm:col-span-2 sm:mt-0">
                    <div class="mb-8 rounded-lg border border-gray-400 bg-white p-6 shadow-lg dark:bg-gray-100">
                        <div class="space-y-4">
                            @foreach ($user->providers as $provider)
                                <div class="flex items-center justify-between rounded-md border border-gray-200 p-4">
                                    <div class="flex items-center">
                                        <div class="shrink-0">
                                            @if ($provider->provider === 'github') <i class="ti ti-brand-github text-2xl text-gray-800"></i>
                                            @elseif ($provider->provider === 'google') <i class="ti ti-brand-google text-2xl text-red-500"></i>
                                            @elseif ($provider->provider === 'facebook') <i class="ti ti-brand-facebook text-2xl text-blue-600"></i>
                                            @elseif ($provider->provider === 'twitter') <i class="ti ti-brand-twitter text-2xl text-blue-400"></i>
                                            @else <i class="ti ti-link text-2xl text-gray-500"></i>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ ucfirst($provider->provider) }}</p>
                                            <p class="text-xs text-gray-500">Connected on {{ $provider->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('frontend.users.unlinkProvider') }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to unlink {{ $provider->provider }}?')">
                                        @csrf
                                        <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                                        <button type="submit"
                                            class="inline-flex items-center rounded-md border border-red-600 bg-white px-3 py-2 text-sm font-semibold text-red-600 shadow-sm hover:bg-red-50">
                                            <i class="ti ti-link-off me-1"></i> @lang('Unlink')
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
