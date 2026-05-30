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

        <div class="card-body p-0">
            <div class="custom-datatable-filter table-responsive">
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('student::text.name')</th>
                            <th>@lang('student::text.email')</th>
                            <th>@lang('student::text.mobile')</th>
                            <th>@lang('student::text.enrollment_number')</th>
                            <th>@lang('student::text.course')</th>
                            <th>@lang('student::text.status')</th>
                            <th>@lang('student::text.updated_at')</th>
                            <th class="text-end">@lang('student::text.action')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <script type="module" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
    <script type="module">
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route("backend.$module_name.index_data") }}',
            order: [[0, 'desc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'mobile', name: 'mobile' },
                { data: 'enrollment_number', name: 'enrollment_number' },
                { data: 'course', name: 'course' },
                { data: 'status_label', name: 'status', searchable: false },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    </script>
@endpush
