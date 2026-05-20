{{--
    Button: List (link to index)
    Variables: $route (string), $title (string, optional), $small (bool, optional), $class (string, optional)
--}}
@php
    $btnRoute  = $route  ?? '';
    $btnTitle  = $title  ?? __('List');
    $btnSmall  = ($small ?? false) ? 'btn-sm' : '';
    $btnClass  = $class  ?? '';
@endphp

@if ($btnRoute)
    <a
        class="btn btn-outline-secondary {{ $btnSmall }} {{ $btnClass }} m-1"
        href="{{ $btnRoute }}"
        data-toggle="tooltip"
        title="{{ $btnTitle }}"
        aria-label="{{ $btnTitle }}"
    >
        <i class="ti ti-list-bullets" aria-hidden="true"></i>
        &nbsp;{{ $btnTitle }}
    </a>
@else
    <button
        type="button"
        class="btn btn-outline-secondary {{ $btnSmall }} {{ $btnClass }} m-1"
        data-toggle="tooltip"
        title="{{ $btnTitle }}"
        aria-label="{{ $btnTitle }}"
    >
        <i class="ti ti-list-bullets" aria-hidden="true"></i>
        &nbsp;{{ $btnTitle }}
    </button>
@endif
