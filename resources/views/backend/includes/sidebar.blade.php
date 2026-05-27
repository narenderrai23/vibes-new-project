<?php
$user = auth()->user();
$unreadCount = optional($user?->unreadNotifications)->count() ?? 0;

/**
 * Helper: returns 'active' if the current route matches any of the given patterns.
 */
function sidebarActive(string ...$patterns): string
{
    foreach ($patterns as $pattern) {
        if (request()->routeIs($pattern)) {
            return 'active';
        }
    }
    return '';
}

/**
 * Helper: returns true (nav-group open) if any child route is active.
 */
function sidebarGroupOpen(string ...$patterns): bool
{
    foreach ($patterns as $pattern) {
        if (request()->routeIs($pattern)) {
            return true;
        }
    }
    return false;
}
?>

<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">

    {{-- ── Logo ─────────────────────────────────────────────── --}}
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand d-sm-flex justify-content-center">
            <a href="{{ route('backend.home') }}">
                <img class="sidebar-brand-full"
                     src="{{ asset('img/logo-with-text.png') }}"
                     alt="{{ app_name() }}"
                     height="46" />
                <img class="sidebar-brand-narrow"
                     src="{{ asset('img/logo-square.jpg') }}"
                     alt="{{ app_name() }}"
                     height="46" />
            </a>
        </div>
        <button class="btn-close d-lg-none"
                type="button"
                aria-label="Close"
                onclick='coreui.Sidebar.getInstance(document.querySelector("#sidebar")).toggle()'></button>
    </div>

    {{-- ── Navigation ──────────────────────────────────────── --}}
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>

        {{-- Dashboard --}}
        <li class="nav-item">
            <a class="nav-link {{ sidebarActive('backend.home', 'admin.dashboard') }}"
               href="{{ route('backend.home') }}">
                <i class="nav-icon ti ti-layout-grid"></i>
                &nbsp;{{ __('Dashboard') }}
            </a>
        </li>

        {{-- Notifications --}}
        @can('view_backend')
        <li class="nav-item">
            <a class="nav-link {{ sidebarActive('backend.notifications.*') }}"
               href="{{ route('backend.notifications.index') }}">
                <i class="nav-icon ti ti-bell"></i>
                &nbsp;{{ __('Notifications') }}
                @if ($unreadCount > 0)
                    &nbsp;<span class="badge badge-sm bg-info ms-auto">{{ $unreadCount }}</span>
                @endif
            </a>
        </li>
        @endcan

        {{-- ── Center Group ─────────────────────────────────── --}}
        @can('view_backend')
        <li class="nav-group {{ sidebarGroupOpen('backend.centers.*', 'backend.regionals.*', 'backend.countries.*', 'backend.states.*') ? 'show' : '' }}">
            <a class="nav-link nav-group-toggle" href="#">
                <i class="nav-icon ti ti-building"></i>
                &nbsp;{{ __('Center') }}
            </a>
            <ul class="nav-group-items compact">
                <li class="nav-item">
                    <a class="nav-link {{ sidebarActive('backend.centers.*') }}"
                       href="{{ route('backend.centers.index') }}">
                        <i class="nav-icon ti ti-building"></i>
                        &nbsp;{{ __('Centers') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ sidebarActive('backend.regionals.*') }}"
                       href="{{ route('backend.regionals.index') }}">
                        <i class="nav-icon ti ti-map"></i>
                        &nbsp;{{ __('Regionals') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ sidebarActive('backend.countries.*') }}"
                       href="{{ route('backend.countries.index') }}">
                        <i class="nav-icon ti ti-world"></i>
                        &nbsp;{{ __('Countries') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ sidebarActive('backend.states.*') }}"
                       href="{{ route('backend.states.index') }}">
                        <i class="nav-icon ti ti-map-pin"></i>
                        &nbsp;{{ __('States') }}
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        {{-- ── Users & Roles ────────────────────────────────── --}}
        @can('view_users')
        <li class="nav-group {{ sidebarGroupOpen('backend.users.*', 'backend.roles.*') ? 'show' : '' }}">
            <a class="nav-link nav-group-toggle" href="#">
                <i class="nav-icon ti ti-users"></i>
                &nbsp;{{ __('Users') }}
            </a>
            <ul class="nav-group-items compact">
                <li class="nav-item">
                    <a class="nav-link {{ sidebarActive('backend.users.*') }}"
                       href="{{ route('backend.users.index') }}">
                        <i class="nav-icon ti ti-users"></i>
                        &nbsp;{{ __('Users') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ sidebarActive('backend.roles.*') }}"
                       href="{{ route('backend.roles.index') }}">
                        <i class="nav-icon ti ti-shield-check"></i>
                        &nbsp;{{ __('Roles') }}
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        {{-- Menus --}}
        @can('view_backend')
        <li class="nav-item">
            <a class="nav-link {{ sidebarActive('backend.menus.*', 'backend.menuitems.*') }}"
               href="{{ route('backend.menus.index') }}">
                <i class="nav-icon ti ti-list"></i>
                &nbsp;{{ __('Menus') }}
            </a>
        </li>
        @endcan

        {{-- Settings --}}
        @can('edit_settings')
        <li class="nav-item">
            <a class="nav-link {{ sidebarActive('backend.settings.*') }}"
               href="{{ route('backend.settings.index') }}">
                <i class="nav-icon ti ti-settings"></i>
                &nbsp;{{ __('Settings') }}
            </a>
        </li>
        @endcan

        {{-- Backups --}}
        @can('view_backend')
        <li class="nav-item">
            <a class="nav-link {{ sidebarActive('backend.backups.*') }}"
               href="{{ route('backend.backups.index') }}">
                <i class="nav-icon ti ti-archive"></i>
                &nbsp;{{ __('Backups') }}
            </a>
        </li>
        @endcan

        {{-- Log Viewer --}}
        @can('view_backend')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/log-viewer*') ? 'active' : '' }}"
               href="/admin/log-viewer">
                <i class="nav-icon ti ti-file-text"></i>
                &nbsp;{{ __('Log Viewer') }}
            </a>
        </li>
        @endcan

    </ul>
    {{-- ── Sidebar Footer ──────────────────────────────────── --}}
    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" data-coreui-toggle="unfoldable" type="button"></button>
    </div>
</div>
