@extends("backend.layouts.app-new")

@section("title")
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs>

        <x-backend.breadcrumb-item
            route='{{ route("backend.$module_name.index") }}'
            icon="{{ $module_icon }}">

            {{ __($module_title) }}

        </x-backend.breadcrumb-item>

        <x-backend.breadcrumb-item type="active">
            {{ __($module_action) }}
        </x-backend.breadcrumb-item>

    </x-backend.breadcrumbs>
@endsection

@section("content")

    <x-backend.layouts.create>

        <x-backend.section-header>

            <i class="{{ $module_icon }}"></i>

            {{ __($module_title) }}
            <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="toolbar">
                <x-backend.buttons.return-back :small="true" />
            </x-slot>

        </x-backend.section-header>

        <div class="row mt-4">

            <div class="col">

                <form action="{{ route("backend.$module_name.store") }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    {{-- Avatar --}}
                    <div class="form-group row mb-3">

                        <label for="avatar"
                               id="avatar-label"
                               class="col-md-2 form-label">

                            {{ __("labels.backend.users.fields.avatar") }}

                        </label>

                        <div class="col-md-5 mb-3">

                            <img class="user-profile-image img-fluid img-thumbnail"
                                 src="{{ asset('img/default-avatar.jpg') }}"
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

                        <div class="col-12 col-sm-6 mb-3">

                            <div class="form-group">

                                <label for="first_name"
                                       id="first_name-label"
                                       class="form-label">

                                    {{ label_case('first_name') }}

                                </label>

                                {!! field_required('required') !!}

                                <input type="text"
                                       name="first_name"
                                       id="first_name"
                                       class="form-control"
                                       placeholder="{{ label_case('first_name') }}"
                                       required
                                       aria-labelledby="first_name-label"
                                       value="{{ old('first_name') }}">

                            </div>

                        </div>

                        <div class="col-12 col-sm-6 mb-3">

                            <div class="form-group">

                                <label for="last_name"
                                       id="last_name-label"
                                       class="form-label">

                                    {{ label_case('last_name') }}

                                </label>

                                {!! field_required('required') !!}

                                <input type="text"
                                       name="last_name"
                                       id="last_name"
                                       class="form-control"
                                       placeholder="{{ label_case('last_name') }}"
                                       required
                                       aria-labelledby="last_name-label"
                                       value="{{ old('last_name') }}">

                            </div>

                        </div>

                    </div>

                    {{-- Email / Mobile --}}
                    <div class="row">

                        <div class="col-12 col-sm-6 mb-3">

                            <div class="form-group">

                                <label for="email"
                                       id="email-label"
                                       class="form-label">

                                    {{ label_case('email') }}

                                </label>

                                {!! field_required('required') !!}

                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control"
                                       placeholder="{{ label_case('email') }}"
                                       required
                                       aria-labelledby="email-label"
                                       value="{{ old('email') }}">

                            </div>

                        </div>

                        <div class="col-12 col-sm-6 mb-3">

                            <div class="form-group">

                                <label for="mobile"
                                       id="mobile-label"
                                       class="form-label">

                                    {{ label_case('mobile') }}

                                </label>

                                <input type="text"
                                       name="mobile"
                                       id="mobile"
                                       class="form-control"
                                       placeholder="{{ label_case('mobile') }}"
                                       aria-labelledby="mobile-label"
                                       value="{{ old('mobile') }}">

                            </div>

                        </div>

                    </div>

                    {{-- Password --}}
                    <div class="row">

                        <div class="col-12 col-sm-6 mb-3">

                            <div class="form-group">

                                <label for="password"
                                       id="password-label"
                                       class="form-label">

                                    {{ label_case('password') }}

                                </label>

                                {!! field_required('required') !!}

                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control"
                                       placeholder="{{ label_case('password') }}"
                                       required
                                       aria-labelledby="password-label">

                            </div>

                        </div>

                        <div class="col-12 col-sm-6 mb-3">

                            <div class="form-group">

                                <label for="password_confirmation"
                                       id="password_confirmation-label"
                                       class="form-label">

                                    {{ label_case('password_confirmation') }}

                                </label>

                                {!! field_required('required') !!}

                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="form-control"
                                       placeholder="{{ label_case('password_confirmation') }}"
                                       required
                                       aria-labelledby="password_confirmation-label">

                            </div>

                        </div>

                    </div>

                    {{-- Status --}}
                    <div class="form-group row mb-3">

                        <label for="status"
                               id="status-label"
                               class="col-6 col-sm-2 form-label">

                            {{ __("labels.backend.users.fields.status") }}

                        </label>

                        <div class="col-6 col-sm-10">

                            <input type="checkbox"
                                   name="status"
                                   id="status"
                                   value="1"
                                   checked
                                   aria-labelledby="status-label">

                            @lang("Active")

                        </div>

                    </div>

                    {{-- Confirmed --}}
                    <div class="form-group row mb-3">

                        <label for="confirmed"
                               id="confirmed-label"
                               class="col-6 col-sm-2 form-label">

                            {{ __("labels.backend.users.fields.confirmed") }}

                        </label>

                        <div class="col-6 col-sm-10">

                            <input type="checkbox"
                                   name="confirmed"
                                   id="confirmed"
                                   value="1"
                                   checked
                                   aria-labelledby="confirmed-label">

                            @lang("Email Confirmed")

                        </div>

                    </div>

                    {{-- Email Credentials --}}
                    <div class="form-group row mb-3">

                        <label for="email_credentials"
                               id="email_credentials-label"
                               class="col-6 col-sm-2 form-label">

                            {{ __("labels.backend.users.fields.email_credentials") }}

                        </label>

                        <div class="col-6 col-sm-10">

                            <input type="checkbox"
                                   name="email_credentials"
                                   id="email_credentials"
                                   value="1"
                                   checked
                                   aria-labelledby="email_credentials-label">

                            @lang("Email Credentials")

                        </div>

                    </div>

                    {{-- Roles & Permissions --}}
                    <div class="form-group row mb-3">

                        <label class="col-sm-2 form-label">
                            Abilities
                        </label>

                        <div class="col">

                            <div class="row">

                                {{-- Roles --}}
                                <div class="col-12 col-sm-7 mb-3">

                                    <div class="card card-accent-info">

                                        <div class="card-header">
                                            @lang("Roles")
                                        </div>

                                        <div class="card-body">

                                            @if ($roles->count())

                                                @foreach ($roles as $role)

                                                    <div class="card mb-3">

                                                        <div class="card-header">

                                                            <div class="form-check">

                                                                <input type="checkbox"
                                                                       name="roles[]"
                                                                       id="role-{{ $role->id }}"
                                                                       class="form-check-input"
                                                                       value="{{ $role->name }}"
                                                                       aria-label="{{ ucwords($role->name) }}"
                                                                       {{ old('roles') && in_array($role->name, old('roles')) ? 'checked' : '' }}>

                                                                <label for="role-{{ $role->id }}"
                                                                       class="form-check-label">

                                                                    {{ ucwords($role->name) }}
                                                                    ({{ $role->name }})

                                                                </label>

                                                            </div>

                                                        </div>

                                                        <div class="card-body">

                                                            @if ($role->id != 1)

                                                                @if ($role->permissions->count())

                                                                    @foreach ($role->permissions as $permission)

                                                                        <i class="ti ti-check-circle mr-1"></i>
                                                                        {{ $permission->name }}

                                                                    @endforeach

                                                                @else

                                                                    @lang("None")

                                                                @endif

                                                            @else

                                                                @lang("All Permissions")

                                                            @endif

                                                        </div>

                                                    </div>

                                                @endforeach

                                            @endif

                                        </div>

                                    </div>

                                </div>

                                {{-- Permissions --}}
                                <div class="col-12 col-sm-5 mb-3">

                                    <div class="card card-accent-primary">

                                        <div class="card-header">
                                            @lang("Permissions")
                                        </div>

                                        <div class="card-body">

                                            @if ($permissions->count())

                                                @foreach ($permissions as $permission)

                                                    <div class="form-check">

                                                        <input type="checkbox"
                                                               name="permissions[]"
                                                               id="permission-{{ $permission->id }}"
                                                               class="form-check-input"
                                                               value="{{ $permission->name }}"
                                                               aria-label="{{ $permission->name }}"
                                                               {{ old('permissions') && in_array($permission->name, old('permissions')) ? 'checked' : '' }}>

                                                        <label for="permission-{{ $permission->id }}"
                                                               class="form-check-label">

                                                            {{ $permission->name }}

                                                        </label>

                                                    </div>

                                                @endforeach

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Submit --}}
                    <div class="row">

                        <div class="col-6">

                            <x-backend.buttons.create>
                                Create
                            </x-backend.buttons.create>

                        </div>

                    </div>

                </form>

                {{-- Cancel --}}
                {{-- Cancel button outside the form to prevent accidental form submission --}}
                <div class="row">

                    <div class="col-12 mt-3">

                        <div class="float-end">

                            <x-backend.buttons.cancel />

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </x-backend.layouts.create>

@endsection