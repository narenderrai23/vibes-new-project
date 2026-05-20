@props(['route' => '', 'icon' => 'ti ti-plus', 'title' => 'Create', 'small' => '', 'class' => ''])

@if ($route)
    <a
        class="btn btn-success {{ $small == 'true' ? 'btn-sm' : '' }} {{ $class }} m-1"
        data-toggle="tooltip"
        href="{{ $route }}"
        title="{{ __($title) }}"
        aria-label="{{ __($title) }}"
    >
        <i class="{{ $icon }}" aria-hidden="true"></i>
        {!! $slot->isNotEmpty() ? '&nbsp;' . $slot : '' !!}
    </a>
@else
    <button
        class="btn btn-success {{ $small == 'true' ? 'btn-sm' : '' }} {{ $class }} m-1"
        data-toggle="tooltip"
        type="submit"
        title="{{ __($title) }}"
        aria-label="{{ __($title) }}"
    >
        <i class="{{ $icon }}" aria-hidden="true"></i>
        {!! $slot->isNotEmpty() ? '&nbsp;' . $slot : '' !!}
    </button>
@endif
