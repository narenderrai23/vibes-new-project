@extends('backend.layouts.app')

@section("title")
    {{ $$module_name_singular->name }} - {{ __($module_action) }} - {{ __($module_title) }}
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

    <div class="card">

        <div class="card-body">

            <x-backend.section-header>

                <i class="{{ $module_icon }}"></i>

                {{ __($module_title) }}
                <small class="text-muted">{{ __($module_action) }}</small>

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

            <div class="row">
                <div class="col">

                    <form action="{{ route("backend.$module_name.update", $$module_name_singular->id) }}"
                          method="POST"
                          class="form-horizontal">

                        @csrf
                        @method('PATCH')

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
                                           value="{{ old('name', $$module_name_singular->name) }}">

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
                                                       {{
                                                            in_array(
                                                                $permission->name,
                                                                old(
                                                                    'permissions',
                                                                    $$module_name_singular->permissions->pluck('name')->all()
                                                                )
                                                            )
                                                            ? 'checked'
                                                            : ''
                                                       }}>

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

                        {{-- Action Buttons --}}
                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">

                                    <x-backend.buttons.save />

                                </div>
                            </div>

                            <div class="col-8">

                                <div class="float-end">

                                    @can("delete_" . $module_name)

                                        <a class="btn btn-outline-danger"
                                           data-method="DELETE"
                                           data-token="{{ csrf_token() }}"
                                           data-toggle="tooltip"
                                           href="{{ route("backend.$module_name.destroy", $$module_name_singular) }}"
                                           title="{{ __('labels.backend.delete') }}">

                                            <i class="ti ti-trash"></i>

                                        </a>

                                    @endcan

                                </div>

                            </div>

                        </div>

                    </form>

                    {{-- Cancel Button --}}
                    {{-- Cancel button outside the form to prevent accidental form submission --}}
                    <div class="row">
                        <div class="col-12 mt-3">

                            <div class="float-end">

                                <x-backend.buttons.return-back>
                                    Cancel
                                </x-backend.buttons.return-back>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="card-footer">

            <div class="row">
                <div class="col">

                    <small class="text-muted float-end">

                        Updated:
                        {{ $$module_name_singular->updated_at->diffForHumans() }},

                        Created at:
                        {{ $$module_name_singular->created_at->isoFormat("LLLL") }}

                    </small>

                </div>
            </div>

        </div>

    </div>

@endsection