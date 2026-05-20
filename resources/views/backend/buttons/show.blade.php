{{--
    Button: Show / View
    Variables: $route (string), $title (string, optional), $small (bool, optional), $class (string, optional)
--}}
@php
    $btnRoute  = $route  ?? '';
    $btnTitle  = $title  ?? __('Show');
    $btnSmall  = ($small ?? true)  ? 'btn-sm' : '';
    $btnClass  = $class  ?? '';
@endphp

@if ($btnRoute)
    <a
        class="btn btn-info {{ $btnSmall }} {{ $btnClass }} m-1"
        href="{{ $btnRoute }}"
        data-toggle="tooltip"
        title="{{ $btnTitle }}"
        aria-label="{{ $btnTitle }}"
    >
        <i class="ti ti-device-desktop" aria-hidden="true"></i>
        @isset($slot)@if(trim($slot)!='') &nbsp;{!! $slot !!}@endif@endisset
    </a>
@else
    <button
        class="btn btn-info {{ $btnSmall }} {{ $btnClass }} m-1"
        type="submit"
        data-toggle="tooltip"
        title="{{ $btnTitle }}"
        aria-label="{{ $btnTitle }}"
    >
        <i class="ti ti-device-desktop" aria-hidden="true"></i>
    </button>
@endif
