@extends('layouts.frontend')

@section('title', $module_name_singular->name)

@section('content')
<div>
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-4 px-4 py-10 sm:grid-cols-3 sm:px-6">
        <div class="col-span-1">
            <div class="mb-8 text-center md:mb-0">
                <img
                    class="mx-auto -mb-24 h-48 w-48 rounded-lg object-cover"
                    src="{{ asset($module_name_singular->avatar) }}"
                    alt="{{ $module_name_singular->name }}"
                />
                <div class="rounded-lg bg-white px-8 pt-32 pb-10 text-gray-400 shadow-lg dark:bg-gray-100">
                    <h3 class="font-title mb-3 text-xl text-gray-800">{{ $module_name_singular->name }}</h3>
                    <p>{{ $module_name_singular->address }}</p>

                    @if ($module_name_singular->url_website)
                        <a class="text-blue-800 hover:text-gray-800" href="{{ $module_name_singular->url_website }}" target="_blank">
                            {{ $module_name_singular->url_website }}
                        </a>
                    @endif

                    @auth
                        @if (auth()->user()->id == $module_name_singular->id)
                            <div class="mt-8">
                                <a href="{{ route('frontend.users.profileEdit') }}">
                                    <div class="w-full rounded-sm border-2 border-gray-900 px-6 py-2 text-sm text-gray-500 transition duration-200 ease-in hover:bg-gray-800 hover:text-white focus:outline-hidden">
                                        Edit Profile
                                    </div>
                                </a>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('frontend.users.changePassword') }}">
                                    <div class="w-full rounded-sm border-2 border-gray-900 px-6 py-2 text-sm text-gray-500 transition duration-200 ease-in hover:bg-gray-800 hover:text-white focus:outline-hidden">
                                        Change Password
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="col-span-2">
            <div class="mb-8 rounded-lg border bg-white p-6 shadow-lg dark:bg-gray-100">
                <h3 class="text-xl font-semibold">Profile</h3>

                <div class="flex justify-between p-4">
                    <div><span class="font-semibold">{{ label_case('first_name') }}:</span> {{ $module_name_singular->first_name }}</div>
                    <div><span class="font-semibold">{{ label_case('last_name') }}:</span> {{ $module_name_singular->last_name }}</div>
                </div>

                @auth
                    @if (auth()->user()->id == $module_name_singular->id)
                        <div class="flex justify-between p-4">
                            <div><span class="font-semibold">{{ label_case('email') }}:</span> {{ $module_name_singular->email }}</div>
                            <div><span class="font-semibold">{{ label_case('mobile') }}:</span> {{ $module_name_singular->mobile }}</div>
                        </div>
                        <div class="flex justify-between p-4">
                            <div>
                                <span class="font-semibold">{{ label_case('date_of_birth') }}:</span>
                                {{ optional($module_name_singular->date_of_birth)->toFormattedDateString() }}
                            </div>
                            <div><span class="font-semibold">{{ label_case('gender') }}:</span> {{ $module_name_singular->gender }}</div>
                        </div>
                    @endif
                @endauth

                <div class="flex flex-col justify-between p-4">
                    <div class="font-semibold">{{ label_case('bio') }}</div>
                    <div>{{ $module_name_singular->bio }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
