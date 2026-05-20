@props(['route' => '', 'icon' => 'ti ti-device-desktop', 'title' => '', 'small' => '', 'class' => ''])

@if ($route)
    <a
        class="btn btn-info {{ $small == 'true' ? 'btn-sm' : '' }} {{ $class }} m-1"
        data-toggle="tooltip"
        href="{{ $route }}"
        title="{{ $title }}"
        aria-label="{{ $title }}"
    >
        <i class="{{ $icon }}" aria-hidden="true"></i>
        {!! $slot->isNotEmpty() ? '&nbsp;' . $slot : '' !!}
    </a>
@else
    <button
        class="btn btn-info {{ $small == 'true' ? 'btn-sm' : '' }} {{ $class }} m-1"
        data-toggle="tooltip"
        type="submit"
        title="{{ $title }}"
        aria-label="{{ $title }}"
    >
        <i class="{{ $icon }}" aria-hidden="true"></i>
        {!! $slot->isNotEmpty() ? '&nbsp;' . $slot : '' !!}
    </button>
@endif
