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
        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i>
            {{ __($module_title) }}
            <small class="text-muted">{{ __($module_action) }}</small>
            <x-slot name="toolbar">
                <x-backend.buttons.return-back :small="true" />
                <a class="btn btn-secondary btn-sm" href="{{ route('backend.states.index') }}">
                    <i class="ti ti-list-bullets"></i> @lang('List')
                </a>
            </x-slot>
        </x-backend.section-header>
        <div class="card-body">

            <div class="row mt-4">
                <div class="col-12">
                    <p class="text-muted">@lang('States do not support soft delete.')</p>
                </div>
            </div>
        </div>
    </div>
@endsection
