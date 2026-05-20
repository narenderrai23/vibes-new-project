@props(['route' => '#', 'icon' => '', 'title' => '', 'type' => ''])

@if ($type)
    <li class="breadcrumb-item active" aria-current="page">
        <span>
            @if ($icon)
                <i class="{{ $icon }}" aria-hidden="true"></i>
            @endif
            {{ $slot }}
        </span>
    </li>
@else
    <li class="breadcrumb-item">
        <a href="{{ $route }}">
            @if ($icon)
                <i class="{{ $icon }}" aria-hidden="true"></i>
            @endif
            {{ $slot }}
        </a>
    </li>
@endif
