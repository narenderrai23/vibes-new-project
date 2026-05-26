@extends('backend.layouts.app-new')

@section('content')
@php $user = Auth::guard('web')->user(); @endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-shield-halved me-2"></i>Admin Dashboard
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
