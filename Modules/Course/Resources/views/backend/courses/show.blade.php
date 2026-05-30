@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs :title="__($module_title)">
    <x-backend.breadcrumb-item route="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</x-backend.breadcrumb-item>
    <x-backend.breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend.breadcrumb-item>
    <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@php
    // Type → Tabler icon (same mapping used in the student portal).
    $contentIcons = [
        'video'   => 'ti ti-player-play',
        'reel'    => 'ti ti-movie',
        'audio'   => 'ti ti-volume',
        'pdf'     => 'ti ti-file-text',
        'ppt'     => 'ti ti-presentation',
        'mindmap' => 'ti ti-sitemap',
        'notes'   => 'ti ti-file-text',
    ];

    $humanSize = function ($bytes) {
        if (! $bytes) {
            return '—';
        }
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = (int) floor(log($bytes, 1024));
        $i = min($i, count($units) - 1);

        return round($bytes / (1024 ** $i), 1).' '.$units[$i];
    };
@endphp

@section('content')
<div class="card">
    <x-backend.section-header>
        <i class="{{ $module_icon }}"></i>
        {{ $course->title }}
        <small class="text-muted">{{ __($module_action) }}</small>

        <x-slot name="toolbar">
            <x-backend.buttons.return-back :small="true" />
            @can('edit_' . $module_name)
                <x-backend.buttons.edit route='{{ route("backend.$module_name.edit", $course->id) }}'
                    title="{{ __('Edit') }} {{ __($module_title) }}" :small="true" />
            @endcan
        </x-slot>
    </x-backend.section-header>

    <div class="card-body">
        {{-- ── Course summary ─────────────────────────────────────── --}}
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label text-muted">@lang('course::text.slug')</label>
                <p class="form-control-plaintext">{{ $course->slug }}</p>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <label class="form-label text-muted">@lang('course::text.duration_weeks')</label>
                <p class="form-control-plaintext">{{ $course->duration_weeks }}</p>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <label class="form-label text-muted">@lang('course::text.status')</label>
                <p class="form-control-plaintext">
                    @if($course->status == 1)
                        <span class="badge bg-success">@lang('course::text.active')</span>
                    @else
                        <span class="badge bg-secondary">@lang('course::text.inactive')</span>
                    @endif
                </p>
            </div>
        </div>

        @if($course->summary)
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label text-muted">@lang('course::text.summary')</label>
                    <p class="form-control-plaintext">{{ $course->summary }}</p>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ── Modules & Content ──────────────────────────────────────────── --}}
<div class="card mt-3">
    <x-backend.section-header>
        <i class="ti ti-list-check"></i>
        @lang('course::text.modules_and_content')

        <x-slot name="toolbar">
            <button class="btn btn-success btn-sm" type="button"
                    data-bs-toggle="collapse" data-bs-target="#add-module-form">
                <i class="ti ti-plus"></i> @lang('course::text.add_module')
            </button>
        </x-slot>
    </x-backend.section-header>

    <div class="card-body">

        {{-- Add module --}}
        <div class="collapse mb-4" id="add-module-form">
            <div class="border rounded p-3 bg-light">
                <form action="{{ route('backend.courses.modules.store', $course->id) }}" method="POST">
                    @csrf
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-5">
                            <label class="form-label">@lang('course::text.module_title')</label>
                            {!! field_required('required') !!}
                            <input type="text" name="title" class="form-control" required
                                   value="{{ old('title') }}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label">@lang('course::text.kind')</label>
                            <select name="kind" class="form-select">
                                <option value="theory">@lang('course::text.kind_theory')</option>
                                <option value="practical">@lang('course::text.kind_practical')</option>
                                <option value="live">@lang('course::text.kind_live')</option>
                                <option value="assessment">@lang('course::text.kind_assessment')</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">@lang('course::text.module_summary')</label>
                            <input type="text" name="summary" class="form-control" value="{{ old('summary') }}">
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="requires_trainer_approval"
                                       id="requires_trainer_approval" value="1">
                                <label class="form-check-label" for="requires_trainer_approval">
                                    @lang('course::text.requires_trainer_approval')
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="ti ti-device-floppy"></i> @lang('course::text.add_module')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Module list --}}
        @forelse($course->modules as $courseModule)
            <div class="border rounded mb-3">
                <div class="d-flex justify-content-between align-items-center p-3 bg-light">
                    <div>
                        <strong>{{ $courseModule->position }}. {{ $courseModule->title }}</strong>
                        <span class="badge bg-info ms-2">{{ ucfirst($courseModule->kind) }}</span>
                        @if($courseModule->summary)
                            <div class="small text-muted">{{ $courseModule->summary }}</div>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-success btn-sm" type="button"
                                data-bs-toggle="collapse" data-bs-target="#add-content-{{ $courseModule->id }}">
                            <i class="ti ti-plus"></i> @lang('course::text.add_content')
                        </button>
                        <form action="{{ route('backend.courses.modules.destroy', [$course->id, $courseModule->id]) }}"
                              method="POST" onsubmit="return confirm('{{ __('course::text.confirm_delete_module') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Add content to this module --}}
                <div class="collapse" id="add-content-{{ $courseModule->id }}">
                    <div class="p-3 border-bottom">
                        <form action="{{ route('backend.courses.modules.contents.store', [$course->id, $courseModule->id]) }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-2 align-items-end">
                                <div class="col-12 col-md-4">
                                    <label class="form-label">@lang('course::text.content_title')</label>
                                    {!! field_required('required') !!}
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label">@lang('course::text.type')</label>
                                    {!! field_required('required') !!}
                                    <select name="type" class="form-select content-type-select" required>
                                        <option value="video">@lang('course::text.type_video')</option>
                                        <option value="reel">@lang('course::text.type_reel')</option>
                                        <option value="audio">@lang('course::text.type_audio')</option>
                                        <option value="pdf">@lang('course::text.type_pdf')</option>
                                        <option value="ppt">@lang('course::text.type_ppt')</option>
                                        <option value="mindmap">@lang('course::text.type_mindmap')</option>
                                        <option value="notes">@lang('course::text.type_notes')</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-2 content-source-wrap">
                                    <label class="form-label">@lang('course::text.source')</label>
                                    {!! field_required('required') !!}
                                    <select name="source" class="form-select content-source-select" required>
                                        <option value="upload">@lang('course::text.source_upload')</option>
                                        <option value="vimeo">@lang('course::text.source_vimeo')</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-5 content-file-wrap">
                                    <label class="form-label">@lang('course::text.file')</label>
                                    {!! field_required('required') !!}
                                    <input type="file" name="file" class="form-control content-file-input" required>
                                </div>
                                <div class="col-12 col-md-5 content-vimeo-wrap" style="display:none;">
                                    <label class="form-label">@lang('course::text.vimeo_url')</label>
                                    {!! field_required('required') !!}
                                    <input type="text" name="vimeo_url" class="form-control content-vimeo-input"
                                           placeholder="https://vimeo.com/123456789" disabled>
                                    <small class="text-muted">@lang('course::text.vimeo_hint')</small>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label">@lang('course::text.release_day')</label>
                                    <input type="number" name="release_day" class="form-control" min="1" value="1">
                                </div>
                                <div class="col-6 col-md-3 d-flex align-items-end">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" name="downloadable"
                                               id="downloadable-{{ $courseModule->id }}" value="1">
                                        <label class="form-check-label" for="downloadable-{{ $courseModule->id }}">
                                            @lang('course::text.downloadable')
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="ti ti-upload"></i> @lang('course::text.upload_content')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Content list --}}
                <div class="p-3">
                    @forelse($courseModule->contents as $content)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ ! $loop->last ? 'border-bottom' : '' }}">
                            <div>
                                <i class="{{ $contentIcons[$content->type] ?? 'ti ti-file' }}"></i>
                                <strong class="ms-1">{{ $content->title }}</strong>
                                <span class="badge bg-secondary ms-2">{{ ucfirst($content->type) }}</span>
                                @if($content->source === 'vimeo')
                                    <span class="badge bg-primary ms-2"><i class="ti ti-brand-vimeo"></i> @lang('course::text.source_vimeo')</span>
                                @endif
                                <small class="text-muted ms-2">
                                    @lang('course::text.release_day'): {{ $content->release_day }}
                                    @if($content->source === 'vimeo')
                                        · <a href="{{ $content->external_url }}" target="_blank" rel="noopener">@lang('course::text.vimeo_url')</a>
                                    @else
                                        · {{ $humanSize($content->size_bytes) }}
                                    @endif
                                    @if($content->downloadable)
                                        · <span class="badge bg-success">@lang('course::text.downloadable')</span>
                                    @endif
                                </small>
                            </div>
                            <form action="{{ route('backend.courses.modules.contents.destroy', [$course->id, $courseModule->id, $content->id]) }}"
                                  method="POST" onsubmit="return confirm('{{ __('course::text.confirm_delete_content') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-muted mb-0">@lang('course::text.no_content')</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="alert alert-info mb-0">
                <i class="ti ti-info-circle"></i> @lang('course::text.no_modules')
            </div>
        @endforelse

    </div>
</div>

{{-- Toggle between file-upload and Vimeo-link inputs per content form.
     Vimeo is only offered for video / reel types. --}}
<script>
    (function () {
        document.querySelectorAll('form .content-type-select').forEach(function (typeSelect) {
            var form       = typeSelect.closest('form');
            var sourceWrap = form.querySelector('.content-source-wrap');
            var source     = form.querySelector('.content-source-select');
            var fileWrap   = form.querySelector('.content-file-wrap');
            var fileInput  = form.querySelector('.content-file-input');
            var vimeoWrap  = form.querySelector('.content-vimeo-wrap');
            var vimeoInput = form.querySelector('.content-vimeo-input');

            function sync() {
                var isVideo = ['video', 'reel'].includes(typeSelect.value);

                // Vimeo source only makes sense for playable video.
                sourceWrap.style.display = isVideo ? '' : 'none';
                if (!isVideo) {
                    source.value = 'upload';
                }

                var useVimeo = isVideo && source.value === 'vimeo';

                fileWrap.style.display = useVimeo ? 'none' : '';
                fileInput.disabled     = useVimeo;
                fileInput.required     = !useVimeo;

                vimeoWrap.style.display = useVimeo ? '' : 'none';
                vimeoInput.disabled     = !useVimeo;
                vimeoInput.required     = useVimeo;
            }

            typeSelect.addEventListener('change', sync);
            source.addEventListener('change', sync);
            sync();
        });
    })();
</script>
@endsection