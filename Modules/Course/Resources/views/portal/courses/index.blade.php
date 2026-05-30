@extends('backend.layouts.app')

@section('title', 'My Courses')

@section('content')
<div class="container">
    <h4 class="mb-3"><i class="ti ti-book me-2"></i>My Courses</h4>

    @if($enrollments->isEmpty())
        <div class="alert alert-info">You are not enrolled in any active courses yet.</div>
    @else
        <div class="row g-3">
            @foreach($enrollments as $enrollment)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        @if($enrollment->course->cover_image)
                            <img src="{{ asset($enrollment->course->cover_image) }}" class="card-img-top" alt="">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $enrollment->course->name }}</h5>
                            <p class="text-muted small mb-2">{{ $enrollment->course->summary }}</p>
                            <ul class="list-unstyled small mb-3">
                                <li><strong>Duration:</strong> {{ $enrollment->course->duration_weeks }} weeks</li>
                                <li><strong>Started:</strong> {{ optional($enrollment->started_at)->format('d M Y') ?? '—' }}</li>
                                <li><strong>Expires:</strong> {{ optional($enrollment->expires_at)->format('d M Y') ?? '—' }}</li>
                            </ul>
                            <a href="{{ route('student.portal.courses.show', $enrollment->course_id) }}" class="btn btn-primary btn-sm">
                                Open course <i class="ti ti-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
