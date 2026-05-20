@extends('backend.layouts.app-new')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header
            :module_name="$module_name"
            :module_title="$module_title"
            :module_icon="$module_icon"
            :module_action="$module_action"
        />

        <div class="row mt-4">
            <div class="col">
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>@lang('center::text.code')</th>
                            <th>@lang('center::text.city')</th>
                            <th>@lang('center::text.name')</th>
                            <th>@lang('center::text.mobile')</th>
                            <th>@lang('center::text.mobile_alt')</th>
                            <th>@lang('center::text.email')</th>
                            <th>@lang('center::text.address')</th>
                            <th>@lang('center::text.gst_no')</th>
                            <th>@lang('center::text.status')</th>
                            <th class="text-end">@lang('center::text.action')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer"></div>
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
        ajax: '{{ route("backend.centers.index_data") }}',
        columns: [
            { data: 'code',         name: 'code' },
            { data: 'city',         name: 'city' },
            { data: 'name',         name: 'name' },
            { data: 'mobile',       name: 'mobile' },
            { data: 'mobile_alt',   name: 'mobile_alt' },
            { data: 'email',        name: 'email' },
            { data: 'address',      name: 'address' },
            { data: 'gst_no',       name: 'gst_no' },
            { data: 'status_label', name: 'status', searchable: false },
            { data: 'action',       name: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@endpush
