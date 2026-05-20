<?php
$user        = auth()->user();
$unreadCount = optional($user?->unreadNotifications)->count() ?? 0;

function sidebar1Active(string ...$patterns): string
{
    foreach ($patterns as $pattern) {
        if (request()->routeIs($pattern)) return 'active';
    }
    return '';
}

function sidebar1Open(string ...$patterns): bool
{
    foreach ($patterns as $pattern) {
        if (request()->routeIs($pattern)) return true;
    }
    return false;
}
?>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">

    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="{{ route('backend.home') }}" class="text-center logo logo-normal">
            <img src="{{ asset('img/logo-with-text-dark.png') }}" alt="{{ app_name() }}" width="100">
        </a>
        <a href="{{ route('backend.home') }}" class="text-center logo-small">
            <img src="{{ asset('img/logo-square.jpg') }}" alt="{{ app_name() }}" >
        </a>
        <a href="{{ route('backend.home') }}" class="text-center dark-logo">
            <img src="{{ asset('img/logo-with-text.png') }}" alt="{{ app_name() }}"  width="100">
        </a>
    </div>
    <!-- /Logo -->

    <!-- Modern Profile (shown in modern sidebar mode) -->
    <div class="modern-profile p-3 pb-0">
        <div class="text-center rounded bg-light p-3 mb-4 user-profile">
            <div class="avatar avatar-lg online mb-3">
                <img src="{{ $user ? asset($user->avatar) : asset('img/default-avatar.jpg') }}"
                     alt="{{ $user?->name }}" class="img-fluid rounded-circle">
            </div>
            <h6 class="fs-12 fw-normal mb-1">{{ $user?->name }}</h6>
            <p class="fs-10">{{ $user?->getRoleNames()->first() ?? 'User' }}</p>
        </div>
        <div class="sidebar-nav mb-3">
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
                <li class="nav-item"><a class="nav-link active border-0" href="#">{{ __('Menu') }}</a></li>
            </ul>
        </div>
    </div>

    <!-- Sidebar Header (shown in default sidebar mode) -->
    <div class="sidebar-header p-3 pb-0 pt-2">
        <div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
            <div class="avatar avatar-md">
                <img src="{{ $user ? asset($user->avatar) : asset('img/default-avatar.jpg') }}"
                     alt="{{ $user?->name }}" class="img-fluid rounded-circle">
            </div>
            <div class="text-start sidebar-profile-info ms-2">
                <h6 class="fs-12 fw-normal mb-1">{{ $user?->name }}</h6>
                <p class="fs-10 mb-0">{{ $user?->getRoleNames()->first() ?? 'User' }}</p>
            </div>
        </div>
        <div class="input-group input-group-flat d-inline-flex mb-4">
            <span class="input-icon-addon">
                <i class="ti ti-search"></i>
            </span>
            <input type="text" class="form-control" placeholder="{{ __('Search...') }}">
            <span class="input-group-text">
                <kbd>CTRL + /</kbd>
            </span>
        </div>
        <div class="d-flex align-items-center justify-content-between menu-item mb-3">
            <div class="me-3">
                <a href="{{ route('backend.home') }}" class="btn btn-menubar">
                    <i class="ti ti-layout-grid-remove"></i>
                </a>
            </div>
            <div class="me-3 notification-item">
                <a href="{{ route('backend.notifications.index') }}"
                   class="btn btn-menubar position-relative me-1">
                    <i class="ti ti-bell"></i>
                    @if ($unreadCount > 0)
                        <span class="notification-status-dot"></span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li class="menu-title"><span>{{ __('MAIN MENU') }}</span></li>

                <li>
                    <ul>

                        {{-- Dashboard --}}
                        <li class="{{ sidebar1Active('backend.home', 'backend.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('backend.home') }}">
                                <i class="ti ti-smart-home"></i>
                                <span>{{ __('Dashboard') }}</span>
                            </a>
                        </li>

                        {{-- Notifications --}}
                        @can('view_backend')
                        <li class="{{ sidebar1Active('backend.notifications.*') ? 'active' : '' }}">
                            <a href="{{ route('backend.notifications.index') }}">
                                <i class="ti ti-bell"></i>
                                <span>{{ __('Notifications') }}</span>
                                @if ($unreadCount > 0)
                                    <span class="badge badge-danger fs-10 fw-medium text-white p-1">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        @endcan

                        {{-- Center Group --}}
                        @can('view_backend')
                        <li class="submenu {{ sidebar1Open('backend.centers.*', 'backend.regionals.*', 'backend.countries.*', 'backend.states.*') ? 'active' : '' }}">
                            <a href="javascript:void(0);">
                                <i class="ti ti-building"></i>
                                <span>{{ __('Center') }}</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li class="{{ sidebar1Active('backend.centers.*') ? 'active' : '' }}">
                                    <a href="{{ route('backend.centers.index') }}">
                                        <i class="ti ti-building"></i>{{ __('Centers') }}
                                    </a>
                                </li>
                                <li class="{{ sidebar1Active('backend.regionals.*') ? 'active' : '' }}">
                                    <a href="{{ route('backend.regionals.index') }}">
                                        <i class="ti ti-map"></i>{{ __('Regionals') }}
                                    </a>
                                </li>
                                <li class="{{ sidebar1Active('backend.countries.*') ? 'active' : '' }}">
                                    <a href="{{ route('backend.countries.index') }}">
                                        <i class="ti ti-world"></i>{{ __('Countries') }}
                                    </a>
                                </li>
                                <li class="{{ sidebar1Active('backend.states.*') ? 'active' : '' }}">
                                    <a href="{{ route('backend.states.index') }}">
                                        <i class="ti ti-map-pin"></i>{{ __('States') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcan

                        {{-- Users & Roles --}}
                        @can('view_users')
                        <li class="submenu {{ sidebar1Open('backend.users.*', 'backend.roles.*') ? 'active' : '' }}">
                            <a href="javascript:void(0);">
                                <i class="ti ti-users"></i>
                                <span>{{ __('Users') }}</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li class="{{ sidebar1Active('backend.users.*') ? 'active' : '' }}">
                                    <a href="{{ route('backend.users.index') }}">
                                        <i class="ti ti-users"></i>{{ __('Users') }}
                                    </a>
                                </li>
                                <li class="{{ sidebar1Active('backend.roles.*') ? 'active' : '' }}">
                                    <a href="{{ route('backend.roles.index') }}">
                                        <i class="ti ti-shield-check"></i>{{ __('Roles') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcan

                    </ul>
                </li>

                <li class="menu-title"><span>{{ __('SYSTEM') }}</span></li>

                <li>
                    <ul>

                        {{-- Menus --}}
                        @can('view_backend')
                        <li class="{{ sidebar1Active('backend.menus.*', 'backend.menuitems.*') ? 'active' : '' }}">
                            <a href="{{ route('backend.menus.index') }}">
                                <i class="ti ti-list"></i>
                                <span>{{ __('Menus') }}</span>
                            </a>
                        </li>
                        @endcan

                        {{-- Settings --}}
                        @can('edit_settings')
                        <li class="{{ sidebar1Active('backend.settings.*') ? 'active' : '' }}">
                            <a href="{{ route('backend.settings.index') }}">
                                <i class="ti ti-settings"></i>
                                <span>{{ __('Settings') }}</span>
                            </a>
                        </li>
                        @endcan

                        {{-- Backups --}}
                        @can('view_backend')
                        <li class="{{ sidebar1Active('backend.backups.*') ? 'active' : '' }}">
                            <a href="{{ route('backend.backups.index') }}">
                                <i class="ti ti-database"></i>
                                <span>{{ __('Backups') }}</span>
                            </a>
                        </li>
                        @endcan

                        {{-- Log Viewer --}}
                        @can('view_backend')
                        <li class="{{ request()->is('admin/log-viewer*') ? 'active' : '' }}">
                            <a href="/admin/log-viewer">
                                <i class="ti ti-file-text"></i>
                                <span>{{ __('Log Viewer') }}</span>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>

            </ul>
        </div>
    </div>
    <!-- /Navigation -->

</div>
<!-- /Sidebar -->
