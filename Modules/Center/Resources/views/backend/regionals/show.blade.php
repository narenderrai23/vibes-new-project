@extends('backend.layouts.app-new')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item route='{{ route("backend.$module_name.index") }}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend.breadcrumb-item>
    <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@section('content')
<x-backend.layouts.show :data="$$module_name_singular" :module_name="$module_name" :module_path="$module_path" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action">

    {{-- Custom show: also list all centers under this regional --}}
    <div class="card-body">
        <x-backend.section-header
            :data="$$module_name_singular"
            :module_name="$module_name"
            :module_title="$module_title"
            :module_icon="$module_icon"
            :module_action="$module_action"
        />

        <div class="row mt-4">
            <div class="col-12">
                <x-backend.section-show-table :data="$$module_name_singular" :module_name="$module_name" />
            </div>
        </div>

        {{-- Centers belonging to this regional --}}
        @if ($$module_name_singular->centers->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <h5 class="mb-3">
                    <i class="ti ti-building me-1"></i>
                    @lang('center::text.centers_in_regional')
                    <span class="badge bg-primary ms-1">{{ $$module_name_singular->centers->count() }}</span>
                </h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>@lang('center::text.name')</th>
                                <th>@lang('center::text.city')</th>
                                <th>@lang('center::text.phone')</th>
                                <th>@lang('center::text.status')</th>
                                <th class="text-end">@lang('center::text.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($$module_name_singular->centers as $center)
                            <tr>
                                <td>{{ $center->id }}</td>
                                <td><strong>{{ $center->name }}</strong></td>
                                <td>{{ $center->city ?? '—' }}</td>
                                <td>{{ $center->phone ?? '—' }}</td>
                                <td>{!! $center->status_label !!}</td>
                                <td class="text-end">
                                    <a href="{{ route('backend.centers.show', $center) }}"
                                       class="btn btn-info btn-sm m-1"
                                       title="@lang('Show Center')">
                                        <i class="ti ti-device-desktop"></i>
                                    </a>
                                    <a href="{{ route('backend.centers.edit', $center) }}"
                                       class="btn btn-outline-primary btn-sm m-1"
                                       title="@lang('Edit Center')">
                                        <i class="ti ti-tool"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

</x-backend.layouts.show>
@endsection
