@props(['item', 'optimized' => false])

@php
    if (!$optimized) {
        $permissions = [];
        if ($item->permissions && is_array($item->permissions)) {
            $permissions = $item->permissions;
        } elseif ($item->permissions && is_string($item->permissions)) {
            $permissions = [$item->permissions];
        }

        $canSee = true;
        if (!empty($permissions)) {
            $canSee = false;
            foreach ($permissions as $permission) {
                if (auth()->check() && auth()->user()->can($permission)) {
                    $canSee = true;
                    break;
                }
            }
        }

        if (empty($permissions) && $item->roles && is_array($item->roles) && !empty($item->roles)) {
            $canSee = false;
            if (auth()->check()) {
                foreach ($item->roles as $role) {
                    if (auth()->user()->hasRole($role)) {
                        $canSee = true;
                        break;
                    }
                }
            }
        }

        if ($item->is_public) {
            $canSee = true;
        }

        if (!$canSee) {
            return;
        }
    }

    $url = '#';
    if ($item->route_name && \Illuminate\Support\Facades\Route::has($item->route_name)) {
        try {
            $url = route($item->route_name, $item->route_parameters ?? []);
        } catch (\Exception $e) {
            $url = $item->url ?? '#';
        }
    } elseif ($item->url) {
        $url = $item->url;
    }

    $icon = $item->icon ?? 'ti ti-link';
    $text = $item->name;
    $hasChildren = isset($item->children) && $item->children instanceof \Illuminate\Support\Collection && $item->children->isNotEmpty();
    $isActive = $item->route_name && request()->routeIs($item->route_name);
@endphp

@if ($hasChildren)
    <li class="nav-group" @if ($isActive) data-coreui-show="true" @endif>
        <a class="nav-link nav-group-toggle" href="#">
            <i class="nav-icon {{ $icon }}" aria-hidden="true"></i>
            &nbsp;{{ $text }}
        </a>
        <ul class="nav-group-items compact">
            @foreach (($item->children ?? collect()) as $child)
                @include('components.backend.dynamic-menu-item', ['item' => $child, 'optimized' => $optimized])
            @endforeach
        </ul>
    </li>
@elseif ($item->type === 'divider')
    <li class="nav-divider"></li>
@elseif ($item->type === 'heading')
    <li class="nav-title">{{ $text }}</li>
@else
    <li class="nav-item">
        <a
            class="nav-link @if ($isActive) active @endif"
            href="{{ $url }}"
            @if ($item->target ?? $item->opens_new_tab) target="_blank" @endif
            @if ($item->description) title="{{ $item->description }}" @endif
        >
            <i class="nav-icon {{ $icon }}" aria-hidden="true"></i>
            &nbsp;{{ $text }}

            @if ($item->route_name === 'backend.notifications.index')
                @php
                    static $cachedNotificationCount = null;
                    if ($cachedNotificationCount === null) {
                        $notifications = optional(auth()->user())->unreadNotifications;
                        $cachedNotificationCount = optional($notifications)->count() ?: 0;
                    }
                @endphp
                @if ($cachedNotificationCount > 0)
                    &nbsp;<span class="badge badge-sm bg-info ms-auto">{{ $cachedNotificationCount }}</span>
                @endif
            @elseif ($item->badge_text)
                &nbsp;<span class="badge badge-sm bg-{{ $item->badge_color ?? 'info' }} ms-auto">{{ $item->badge_text }}</span>
            @endif
        </a>
    </li>
@endif
