@extends('backend.layouts.app')

@section('title', $module->title)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('student.portal.courses.index') }}">My Courses</a></li>
            <li class="breadcrumb-item"><a href="{{ route('student.portal.courses.show', $enrollment->course_id) }}">{{ $enrollment->course->name }}</a></li>
            <li class="breadcrumb-item active">{{ $module->title }}</li>
        </ol>
    </nav>

    <h4 class="mb-3">{{ $module->title }}</h4>

    <div class="list-group">
        @forelse($contents as $content)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <i class="ti {{ [
                        'video' => 'ti-player-play',
                        'reel'  => 'ti-movie',
                        'pdf'   => 'ti-file-text',
                        'mindmap' => 'ti-sitemap',
                        'ppt'   => 'ti-presentation',
                        'audio' => 'ti-volume',
                        'notes' => 'ti-file-text',
                    ][$content->type] ?? 'ti-file' }} me-2"></i>
                    <strong>{{ $content->title }}</strong>
                    <small class="text-muted ms-2">Day {{ $content->release_day }}</small>
                </div>
                <div>
                    @if($content->released)
                        <a href="{{ route('student.portal.courses.content', [$enrollment->course_id, $module->id, $content->id]) }}" class="btn btn-sm btn-outline-primary">
                            View
                        </a>
                    @else
                        <span class="badge bg-secondary">
                            <i class="ti ti-clock me-1"></i>Releases on day {{ $content->release_day }}
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-info">No content available yet.</div>
        @endforelse
    </div>
</div>
@endsection
