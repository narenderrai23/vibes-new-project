@extends('backend.layouts.app')

@section('title', 'Student Dashboard')

@section('content')
@php $user = Auth::guard('student')->user(); @endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="ti ti-school me-2"></i>Student Dashboard
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-1">Welcome, <strong>{{ $user->name }}</strong></p>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Enrollment No.</small>
                                <strong>{{ $user->enrollment_number ?? '—' }}</strong>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Course</small>
                                <strong>{{ $user->course ?? '—' }}</strong>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Batch</small>
                                <strong>{{ $user->batch ?? '—' }}</strong>
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
