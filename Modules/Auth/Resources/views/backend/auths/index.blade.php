@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section('breadcrumbs')
    <x-backend.breadcrumbs :title="__($module_title)">
        <x-backend.breadcrumb-item route="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</x-backend.breadcrumb-item>
        <x-backend.breadcrumb-item type="active"
            icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section('content')
    <div class="card">
        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i>
            {{ __($module_title) }}
            <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="toolbar">
                <x-backend.buttons.return-back :small="true" />
                @can('add_' . $module_name)
                    <x-backend.buttons.create route='{{ route("backend.$module_name.create") }}'
                        title="{{ __(ucwords(Str::singular($module_name))) }} {{ __('Create') }}" :small="true" />
                @endcan
            </x-slot>
        </x-backend.section-header>
        <div class="card-body">
            <div class="row mt-4">
                <div class="col">
                    <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    @lang('auth::text.name')
                                </th>
                                <th>
                                    @lang('auth::text.slug')
                                </th>
                                <th>
                                    @lang('auth::text.updated_at')
                                </th>
                                <th>
                                    @lang('auth::text.created_by')
                                </th>
                                <th class="text-end">
                                    @lang('auth::text.action')
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($$module_name as $module_name_singular)
                                <tr>
                                    <td>
                                        {{ $module_name_singular->id }}
                                    </td>
                                    <td>
                                        <a
                                            href="{{ url("admin/$module_name", $module_name_singular->id) }}">{{ $module_name_singular->name }}</a>
                                    </td>
                                    <td>
                                        {{ $module_name_singular->slug }}
                                    </td>
                                    <td>
                                        {{ $module_name_singular->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        {{ $module_name_singular->created_by }}
                                    </td>
                                    <td class="text-end">
                                        <a href='{!! route("backend.$module_name.edit", $module_name_singular) !!}' class='btn btn-sm btn-primary mt-1'
                                            data-toggle="tooltip"
                                            title="Edit {{ ucwords(Str::singular($module_name)) }}"><i
                                                class="ti ti-tool"></i></a>
                                        <a href='{!! route("backend.$module_name.show", $module_name_singular) !!}' class='btn btn-sm btn-success mt-1'
                                            data-toggle="tooltip"
                                            title="Show {{ ucwords(Str::singular($module_name)) }}"><i
                                                class="ti ti-device-desktop"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        Total {{ $$module_name->total() }} {{ ucwords($module_name) }}
                    </div>
                </div>
                <div class="col-5">
                    <div class="float-end">
                        {!! $$module_name->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
