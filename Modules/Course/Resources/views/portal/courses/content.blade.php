@extends('backend.layouts.app')

@section('title', $content->title)

@php
    $student = Auth::guard('student')->user();
    $streamUrl = \Modules\Course\Http\Controllers\Portal\ContentStreamController::signedUrl($content, 600);
    $watermark = ($student->name ?? 'Student') . ' Â· ' . ($student->enrollment_number ?? $student->email);
@endphp

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('student.portal.courses.index') }}">My Courses</a></li>
            <li class="breadcrumb-item"><a href="{{ route('student.portal.courses.show', $enrollment->course_id) }}">{{ $enrollment->course->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('student.portal.courses.module', [$enrollment->course_id, $module->id]) }}">{{ $module->title }}</a></li>
            <li class="breadcrumb-item active">{{ $content->title }}</li>
        </ol>
    </nav>

    <h4 class="mb-3">{{ $content->title }}</h4>

    <div class="protected-viewer position-relative border rounded bg-dark"
         oncontextmenu="return false"
         onselectstart="return false"
         ondragstart="return false"
         style="overflow:hidden;">

        <div class="watermark" aria-hidden="true">{{ $watermark }}</div>

        @switch($content->type)
            @case('video')
            @case('reel')
                @if($content->source === 'vimeo' && $content->vimeoEmbedUrl())
                    <div style="position:relative;padding-top:56.25%;background:#000;">
                        <iframe
                            src="{{ $content->vimeoEmbedUrl() }}"
                            style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                            allow="autoplay; fullscreen; picture-in-picture"
                            allowfullscreen
                        ></iframe>
                    </div>
                @else
                    <video
                        class="w-100 d-block"
                        src="{{ $streamUrl }}"
                        controls
                        controlslist="nodownload noremoteplayback"
                        disablepictureinpicture
                        playsinline
                        style="max-height:70vh;background:#000;"
                    ></video>
                @endif
                @break

            @case('audio')
                <audio class="w-100 d-block" src="{{ $streamUrl }}" controls controlslist="nodownload"></audio>
                @break

            @case('pdf')
            @case('ppt')
            @case('mindmap')
            @case('notes')
                <iframe
                    src="{{ $streamUrl }}#toolbar=0&navpanes=0&scrollbar=0"
                    style="width:100%;height:75vh;border:0;background:#fff;"
                    sandbox="allow-same-origin allow-scripts"
                ></iframe>
                @break

            @default
                <div class="p-4 text-light">Unsupported content type.</div>
        @endswitch
    </div>

    @if($content->summary)
        <div class="mt-3">
            <p class="text-muted">{{ $content->summary }}</p>
        </div>
    @endif
</div>

<style>
    .protected-viewer { user-select: none; -webkit-user-select: none; }
    .protected-viewer .watermark {
        position: absolute;
        top: 12px; right: 16px;
        z-index: 10;
        padding: 4px 10px;
        font-size: 12px;
        color: rgba(255,255,255,0.65);
        background: rgba(0,0,0,0.25);
        border-radius: 4px;
        pointer-events: none;
        text-shadow: 0 0 4px rgba(0,0,0,0.6);
    }
    .protected-viewer video::-webkit-media-controls-download-button { display:none; }
    .protected-viewer video::-internal-media-controls-download-button { display:none; }
</style>

<script>
    (function () {
        document.addEventListener('keydown', function (e) {
            const k = (e.key || '').toLowerCase();
            if ((e.ctrlKey || e.metaKey) && ['s','u','p'].includes(k)) {
                e.preventDefault();
            }
            if (k === 'printscreen') {
                e.preventDefault();
            }
        });
    })();
</script>
@endsection
