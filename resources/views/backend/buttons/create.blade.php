{{--
    Button: Create (link or submit)
    Variables: $route (string, optional), $title (string, optional), $small (bool, optional), $class (string, optional)
--}}
@php
    $btnRoute  = $route  ?? '';
    $btnTitle  = $title  ?? __('Create');
    $btnSmall  = ($small ?? false) ? 'btn-sm' : '';
    $btnClass  = $class  ?? '';
@endphp

@if ($btnRoute)
    <a
        class="btn btn-success {{ $btnSmall }} {{ $btnClass }} m-1"
        href="{{ $btnRoute }}"
        data-toggle="tooltip"
        title="{{ $btnTitle }}"
        aria-label="{{ $btnTitle }}"
    >
        <i class="ti ti-plus" aria-hidden="true"></i>
        &nbsp;{{ $btnTitle }}
    </a>
@else
    <button
        type="submit"
        class="btn btn-success {{ $btnSmall }} {{ $btnClass }} m-1"
        data-toggle="tooltip"
        title="{{ $btnTitle }}"
        aria-label="{{ $btnTitle }}"
    >
        <i class="ti ti-plus" aria-hidden="true"></i>
        &nbsp;{{ $btnTitle }}
    </button>
@endif
