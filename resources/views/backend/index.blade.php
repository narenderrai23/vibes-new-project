@extends('backend.layouts.app')

@section("title")
    @lang("Dashboard")
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs :title="__('Dashboard')">
        <x-backend.breadcrumb-item type="active">{{ __('Dashboard') }}</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section("content")
    {{-- Demo content --}}
    @include("backend.includes.dashboard_demo_data")
@endsection
