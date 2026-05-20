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

    <div class="card">

        <div class="card-body">

            <x-backend.section-header>

                <i class="{{ $module_icon }}"></i>

                {{ __($module_title) }}
                <small class="text-muted">{{ __($module_action) }}</small>

                <x-slot name="toolbar">
                    <x-backend.buttons.return-back :small="true" />
                </x-slot>

            </x-backend.section-header>

            {{-- User Info --}}
            <div class="row mb-3">

                <div class="col">

                    <strong>
                        @lang("Name") :
                    </strong>

                    {{ $$module_name_singular->name }}

                </div>

                <div class="col">

                    <strong>
                        @lang("Email") :
                    </strong>

                    {{ $$module_name_singular->email }}

                </div>

            </div>

            {{-- Password Change Form --}}
            <div class="row mb-4 mt-4">

                <div class="col">

                    <form action="{{ route('backend.users.changePasswordUpdate', $$module_name_singular->id) }}"
                          method="POST"
                          class="form-horizontal">

                        @csrf
                        @method('PATCH')

                        {{-- Password --}}
                        <div class="form-group row mb-3">

                            <label for="password"
                                   id="password-label"
                                   class="col-md-2 form-label">

                                {{ __("labels.backend.users.fields.password") }}

                            </label>

                            <div class="col-md-10">

                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control"
                                       placeholder="{{ __('labels.backend.users.fields.password') }}"
                                       required
                                       aria-labelledby="password-label">

                            </div>

                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group row mb-3">

                            <label for="password_confirmation"
                                   id="password_confirmation-label"
                                   class="col-md-2 form-label">

                                {{ __("labels.backend.users.fields.password_confirmation") }}

                            </label>

                            <div class="col-md-10">

                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="form-control"
                                       placeholder="{{ __('labels.backend.users.fields.password_confirmation') }}"
                                       required
                                       aria-labelledby="password_confirmation-label">

                            </div>

                        </div>

                        {{-- Submit Button --}}
                        <div class="row">

                            <div class="col">
                                <div class="row">

                                    <div class="col-4">

                                        <div class="form-group">

                                            <button type="submit"
                                                    class="btn btn-outline-success">

                                                <i class="ti ti-device-floppy"></i>
                                                Save

                                            </button>

                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <div class="card-footer">

            <x-backend.section-footer>

                @lang("Updated")
                : {{ $$module_name_singular->updated_at->diffForHumans() }},

                @lang("Created at")
                : {{ $$module_name_singular->created_at->isoFormat("LLLL") }}

            </x-backend.section-footer>

        </div>

    </div>

@endsection