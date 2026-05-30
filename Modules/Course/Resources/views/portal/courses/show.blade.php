@extends('backend.layouts.app')

@section('title', $enrollment->course->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('student.portal.courses.index') }}">My Courses</a></li>
            <li class="breadcrumb-item active">{{ $enrollment->course->name }}</li>
        </ol>
    </nav>

    <h4 class="mb-1">{{ $enrollment->course->name }}</h4>
    <p class="text-muted">{{ $enrollment->course->summary }}</p>

    <h5 class="mt-4 mb-3"><i class="ti ti-list me-2"></i>Modules</h5>

    <div class="list-group">
        @foreach($modules as $module)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-secondary me-2">{{ $module->position }}</span>
                    <strong>{{ $module->title }}</strong>
                    <small class="text-muted ms-2">{{ ucfirst($module->kind) }}</small>
                    @if($module->summary)
                        <div class="small text-muted mt-1">{{ $module->summary }}</div>
                    @endif
                </div>
                <div>
                    @if($module->unlocked)
                        <a href="{{ route('student.portal.courses.module', [$enrollment->course_id, $module->id]) }}" class="btn btn-sm btn-primary">
                            Open <i class="ti ti-arrow-right ms-1"></i>
                        </a>
                    @else
                        <span class="badge bg-warning text-dark">
                            <i class="ti ti-lock me-1"></i>Locked
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
