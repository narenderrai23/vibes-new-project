@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section('breadcrumbs')
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item type="active"
            icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section('content')
    <div class="card">
        <x-backend.section-header :module_name="$module_name" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action" />
        <div class="card-body">

            <div class="row mt-4">
                <div class="col">
                    <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('center::text.name')</th>
                                <th>ISO2</th>
                                <th>ISO3</th>
                                <th>Phone Code</th>
                                <th>Currency</th>
                                <th>@lang('center::text.updated_at')</th>
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
            ajax: '{{ route('backend.countries.index_data') }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'iso2',
                    name: 'iso2'
                },
                {
                    data: 'iso3',
                    name: 'iso3'
                },
                {
                    data: 'phonecode',
                    name: 'phonecode'
                },
                {
                    data: 'currency',
                    name: 'currency'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    </script>
@endpush
