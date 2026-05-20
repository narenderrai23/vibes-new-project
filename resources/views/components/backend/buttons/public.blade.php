@props(['route' => '', 'icon' => 'ti ti-external-link', 'title' => '', 'small' => '', 'class' => ''])

@if ($route)
    <a
        class="btn btn-success {{ $small == 'true' ? 'btn-sm' : '' }} {{ $class }} ms-1"
        data-toggle="tooltip"
        href="{{ $route }}"
        title="{{ $title }}"
        aria-label="{{ $title }}"
        target="_blank"
        rel="noopener noreferrer"
    >
        <i class="{{ $icon }}" aria-hidden="true"></i>
        {!! $slot->isNotEmpty() ? '&nbsp;' . $slot : '' !!}
    </a>
@endif
