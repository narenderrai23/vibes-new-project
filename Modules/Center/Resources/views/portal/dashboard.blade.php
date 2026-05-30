@extends('backend.layouts.app')

@section('title', 'Center Dashboard')

@section('content')
@php $user = Auth::guard('center')->user(); @endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="ti ti-building me-2"></i>Center Dashboard
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-1">Welcome, <strong>{{ $user->name }}</strong></p>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Center</small>
                                <strong>{{ $user->center?->name ?? '—' }}</strong>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Role</small>
                                <span class="badge bg-warning text-dark">{{ ucfirst($user->role) }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Mobile</small>
                                <strong>{{ $user->mobile ?? '—' }}</strong>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Status</small>
                                <span class="badge bg-{{ $user->status === 1 ? 'success' : 'danger' }}">
                                    {{ $user->status === 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
