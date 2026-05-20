@props(['url' => '/', 'icon' => 'ti ti-box', 'text' => 'Menu', 'permission' => 'view_backend'])

@can($permission)
    <li class="nav-item">
        <a class="nav-link" href="{{ $url }}">
            <i class="nav-icon {{ $icon }}" aria-hidden="true"></i>
            &nbsp;{{ $text }}
        </a>
    </li>
@endcan
