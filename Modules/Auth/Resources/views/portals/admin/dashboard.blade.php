@extends('backend.layouts.app')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('breadcrumbs')
    <x-backend.breadcrumbs :title="__('Dashboard')">
        <x-backend.breadcrumb-item type="active">{{ __('Dashboard') }}</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section('content')
@php $user = Auth::guard('web')->user(); @endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="ti ti-shield me-2"></i>Admin Dashboard
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-1">Welcome, <strong>{{ $user->name }}</strong></p>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
