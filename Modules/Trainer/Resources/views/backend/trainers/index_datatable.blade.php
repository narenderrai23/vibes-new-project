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
        <x-backend.section-header
            :module_name="$module_name"
            :module_title="$module_title"
            :module_icon="$module_icon"
            :module_action="$module_action"
        />
        <div class="card-body p-0">
            <div class="custom-datatable-filter table-responsive">
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('trainer::text.name')</th>
                            <th>@lang('trainer::text.email')</th>
                            <th>@lang('trainer::text.mobile')</th>
                            <th>@lang('trainer::text.specialization')</th>
                            <th>@lang('trainer::text.status')</th>
                            <th>@lang('trainer::text.updated_at')</th>
                            <th class="text-end">@lang('trainer::text.action')</th>
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
                { data: 'specialization', name: 'specialization' },
                { data: 'status_label', name: 'status', searchable: false },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    </script>
@endpush
