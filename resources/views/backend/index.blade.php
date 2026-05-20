@extends("backend.layouts.app-new")

@section("title")
    @lang("Dashboard")
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs />
@endsection

@section("content")
    {{-- Demo content --}}
    @include("backend.includes.dashboard_demo_data")
@endsection
