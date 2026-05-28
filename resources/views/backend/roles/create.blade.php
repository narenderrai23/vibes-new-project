@extends('backend.layouts.app')

@section("title")
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item route='{{ route("backend.$module_name.index") }}' icon="{{ $module_icon }}">
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

        <div class="row">
            <div class="col">

                <form action="{{ route('backend.roles.store') }}"
                      method="POST"
                      class="form-horizontal">

                    @csrf

                    {{-- Role Name --}}
                    <div class="row mb-3">

                        <div class="col-12 col-sm-2">
                            <div class="form-group">

                                <label for="name"
                                       id="name-label"
                                       class="form-label">
                                    {{ __("labels.backend.roles.fields.name") }}
                                </label>

                                {!! field_required('required') !!}

                            </div>
                        </div>

                        <div class="col-12 col-sm-10">
                            <div class="form-group">

                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control"
                                       placeholder="{{ __('labels.backend.roles.fields.name') }}"
                                       required
                                       aria-labelledby="name-label"
                                       value="{{ old('name') }}">

                            </div>
                        </div>

                    </div>

                    {{-- Permissions --}}
                    <div class="row mb-3">

                        <div class="col-12 col-sm-2">
                            <div class="form-group">

                                <label class="form-label">
                                    {{ __("Abilities") }}
                                </label>

                            </div>
                        </div>

                        <div class="col-12 col-sm-10">
                            <div class="form-group">

                                {{ __("Select permissions from the list:") }}

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

                    {{-- Submit --}}
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">

                                <x-backend.buttons.create title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}">
                                    {{ __("Create") }}
                                </x-backend.buttons.create>

                            </div>
                        </div>
                    </div>

                </form>

                {{-- Cancel Button --}}
                {{-- Cancel button outside the form to prevent accidental form submission --}}
                <div class="row">
                    <div class="col-12 mt-3">

                        <div class="float-end">
                            <div class="form-group">

                                <x-backend.buttons.cancel />

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </x-backend.layouts.create>
@endsection