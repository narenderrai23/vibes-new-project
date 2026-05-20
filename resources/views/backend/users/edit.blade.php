@extends("backend.layouts.app-new")

@section("title")
    {{ $$module_name_singular->name }} -
    {{ $$module_name_singular->username }} -
    {{ __($module_action) }}
    {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs>

        <x-backend.breadcrumb-item
            route='{{ route("backend.$module_name.index") }}'
            icon="{{ $module_icon }}">

            {{ $$module_name_singular->name }}

        </x-backend.breadcrumb-item>

        <x-backend.breadcrumb-item type="active">

            {{ __($module_title) }}
            {{ __($module_action) }}

        </x-backend.breadcrumb-item>

    </x-backend.breadcrumbs>
@endsection

@section("content")

    <x-backend.layouts.edit :data="$user">

        <x-backend.section-header>

            <i class="{{ $module_icon }}"></i>

            {{ $$module_name_singular->name }}

            <small class="text-muted">
                {{ __($module_title) }} {{ __($module_action) }}
            </small>

            <x-slot name="toolbar">

                <x-backend.buttons.return-back :small="true" />

                <x-backend.buttons.show
                    class="ms-1"
                    title="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
                    route='{!! route("backend.$module_name.show", $$module_name_singular) !!}'
                    :small="true"
                />

            </x-slot>

        </x-backend.section-header>

        <div class="row mt-4">

            <div class="col">

                <form action="{{ route('backend.users.update', $user->id) }}"
                      method="POST"
                      class="form-horizontal"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PATCH')

                    {{-- Avatar --}}
                    <div class="form-group row">

                        <label for="avatar"
                               id="avatar-label"
                               class="col-md-2 form-label">

                            {{ __("labels.backend.users.fields.avatar") }}

                        </label>

                        <div class="col-md-5 mb-3">

                            <img class="user-profile-image img-fluid img-thumbnail"
                                 src="{{ asset($$module_name_singular->avatar) }}"
                                 style="max-height: 200px; max-width: 200px"
                                 aria-labelledby="avatar-label" />

                        </div>

                        <div class="col-md-5 mb-3">

                            <input type="file"
                                   name="avatar"
                                   id="avatar"
                                   aria-labelledby="avatar-label">

                        </div>

                    </div>

                    {{-- First Name / Last Name --}}
                    <div class="row">

                        <div class="col-sm-6 col-12 mb-3">

                            <div class="form-group">

                                <label for="first_name"
                                       id="first_name-label"
                                       class="form-label">

                                    {{ __(label_case('first_name')) }}

                                </label>

                                {!! field_required('required') !!}

                                <input type="text"
                                       name="first_name"
                                       id="first_name"
                                       class="form-control"
                                       placeholder="{{ __(label_case('first_name')) }}"
                                       required
                                       aria-labelledby="first_name-label"
                                       value="{{ old('first_name', $user->first_name) }}">

                            </div>

                        </div>

                        <div class="col-sm-6 col-12 mb-3">

                            <div class="form-group">

                                <label for="last_name"
                                       id="last_name-label"
                                       class="form-label">

                                    {{ __(label_case('last_name')) }}

                                </label>

                                {!! field_required('required') !!}

                                <input type="text"
                                       name="last_name"
                                       id="last_name"
                                       class="form-control"
                                       placeholder="{{ __(label_case('last_name')) }}"
                                       required
                                       aria-labelledby="last_name-label"
                                       value="{{ old('last_name', $user->last_name) }}">

                            </div>

                        </div>

                        <div class="col-sm-6 col-12 mb-3">

                            <div class="form-group">

                                <label for="email"
                                       id="email-label"
                                       class="form-label">

                                    {{ __(label_case('email')) }}

                                </label>

                                {!! field_required('required') !!}

                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control"
                                       placeholder="{{ __(label_case('email')) }}"
                                       required
                                       aria-labelledby="email-label"
                                       value="{{ old('email', $user->email) }}">

                            </div>

                        </div>

                        <div class="col-sm-6 col-12 mb-3">

                            <div class="form-group">

                                <label for="mobile"
                                       id="mobile-label"
                                       class="form-label">

                                    {{ __(label_case('mobile')) }}

                                </label>

                                <input type="text"
                                       name="mobile"
                                       id="mobile"
                                       class="form-control"
                                       placeholder="{{ __(label_case('mobile')) }}"
                                       aria-labelledby="mobile-label"
                                       value="{{ old('mobile', $user->mobile) }}">

                            </div>

                        </div>

                    </div>

                    {{-- Gender / DOB --}}
                    <div class="row">

                        <div class="col-sm-6 col-12 mb-3">

                            <div class="form-group">

                                <label for="gender"
                                       id="gender-label"
                                       class="form-label">

                                    {{ __(label_case('gender')) }}

                                </label>

                                <select name="gender"
                                        id="gender"
                                        class="form-select select2"
                                        aria-labelledby="gender-label">

                                    <option value="">
                                        -- Select an option --
                                    </option>

                                    <option value="Female"
                                        {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>
                                        Female
                                    </option>

                                    <option value="Male"
                                        {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>
                                        Male
                                    </option>

                                    <option value="Other"
                                        {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>
                                        Other
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-sm-6 col-12 mb-3">

                            <div class="form-group">

                                <label for="date_of_birth"
                                       id="date_of_birth-label"
                                       class="form-label">

                                    {{ __(label_case('date_of_birth')) }}

                                </label>

                                <input type="date"
                                       name="date_of_birth"
                                       id="date_of_birth"
                                       class="form-control"
                                       aria-labelledby="date_of_birth-label"
                                       value="{{ old('date_of_birth', $user->date_of_birth) }}">

                            </div>

                        </div>

                    </div>

                    {{-- Address / Bio --}}
                    <div class="row">

                        <div class="col-sm-6 col-12 mb-3">

                            <div class="form-group">

                                <label for="address"
                                       id="address-label"
                                       class="form-label">

                                    {{ __(label_case('address')) }}

                                </label>

                                <textarea name="address"
                                          id="address"
                                          class="form-control"
                                          aria-labelledby="address-label"
                                          placeholder="{{ __(label_case('address')) }}">{{ old('address', $user->address) }}</textarea>

                            </div>

                        </div>

                        <div class="col-sm-6 col-12 mb-3">

                            <div class="form-group">

                                <label for="bio"
                                       id="bio-label"
                                       class="form-label">

                                    {{ __(label_case('bio')) }}

                                </label>

                                <textarea name="bio"
                                          id="bio"
                                          class="form-control"
                                          aria-labelledby="bio-label"
                                          placeholder="{{ __(label_case('bio')) }}">{{ old('bio', $user->bio) }}</textarea>

                            </div>

                        </div>

                    </div>

                    {{-- Social Profiles --}}
                    <div class="row">

                        @foreach ($$module_name_singular->socialFieldsNames() as $item)

                            <div class="col-sm-6 col-12 mb-3">

                                <div class="form-group">

                                    <label for="social_{{ $item }}"
                                           class="form-label">

                                        {{ label_case($item) }}

                                    </label>

                                    <input type="text"
                                           name="social_profiles[{{ $item }}]"
                                           id="social_{{ $item }}"
                                           class="form-control"
                                           placeholder="{{ label_case($item) }}"
                                           value="{{ old('social_profiles.'.$item, $user->social_profiles[$item] ?? '') }}">

                                </div>

                            </div>

                        @endforeach

                    </div>

                    {{-- Change Password --}}
                    <div class="row mb-3">

                        <div class="col-sm-2 col-12">

                            <label class="form-label">
                                {{ __("labels.backend.users.fields.password") }}
                            </label>

                        </div>

                        <div class="col-sm-10 col-12">

                            <a class="btn btn-outline-primary btn-sm"
                               href="{{ route('backend.users.changePassword', $user->id) }}">

                                <i class="ti ti-key"></i>
                                @lang("Change Password")

                            </a>

                        </div>

                    </div>

                    {{-- Email Verification --}}
                    <div class="row mb-3">

                        <div class="col-sm-2 col-12">

                            <label class="form-label">
                                {{ __("labels.backend.users.fields.confirmed") }}
                            </label>

                        </div>

                        <div class="col-sm-10 col-12">

                            @if ($user->email_verified_at == null)

                                <a class="btn btn-outline-primary btn-sm"
                                   href="{{ route('backend.users.emailConfirmationResend', $user->id) }}">

                                    <i class="ti ti-mail"></i>
                                    Send Confirmation Email

                                </a>

                            @else

                                {!! $user->confirmed_label !!}

                            @endif

                        </div>

                    </div>

                    {{-- Submit --}}
                    <div class="row">

                        <div class="col-4 mb-3">

                            <x-backend.buttons.save />

                        </div>

                        <div class="col-8 mb-3">

                            <div class="float-end">

                                @if ($$module_name_singular->status != 2 && $$module_name_singular->id != 1)

                                    <a class="btn btn-outline-danger"
                                       data-method="PATCH"
                                       data-token="{{ csrf_token() }}"
                                       data-confirm="Are you sure?"
                                       href="{{ route('backend.users.block', $$module_name_singular) }}">

                                        <i class="ti ti-ban"></i>

                                    </a>

                                @endif

                                @if ($$module_name_singular->status == 2)

                                    <a class="btn btn-outline-info"
                                       data-method="PATCH"
                                       data-token="{{ csrf_token() }}"
                                       data-confirm="Are you sure?"
                                       href="{{ route('backend.users.unblock', $$module_name_singular) }}">

                                        <i class="ti ti-check"></i>
                                        Unblock

                                    </a>

                                @endif

                                @can("delete_" . $module_name)

                                    @if ($$module_name_singular->id != 1)

                                        <a class="btn btn-outline-danger"
                                           data-method="DELETE"
                                           data-token="{{ csrf_token() }}"
                                           href="{{ route("backend.$module_name.destroy", $$module_name_singular) }}">

                                            <i class="ti ti-trash"></i>
                                            Delete

                                        </a>

                                    @endif

                                @endcan

                            </div>

                        </div>

                    </div>

                </form>

                {{-- Cancel --}}
                {{-- Cancel button outside the form to prevent accidental form submission --}}
                <div class="row">

                    <div class="col-12 mb-3">

                        <div class="float-end">

                            <x-backend.buttons.return-back>
                                @lang("Cancel")
                            </x-backend.buttons.return-back>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </x-backend.layouts.edit>

@endsection