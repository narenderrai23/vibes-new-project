@php
    // Resolve the authenticated user from whichever guard is active.
    // Portal guards (student, trainer, center) don't have web-guard Users,
    // so we check each guard in priority order.
    $activeGuard = collect(['web', 'student', 'trainer', 'center'])
        ->first(fn ($g) => Auth::guard($g)->check());

    $authUser   = $activeGuard ? Auth::guard($activeGuard)->user() : null;
    $isWebUser  = $activeGuard === 'web';   // only web users have backend profile/notifications
    $avatar     = $authUser && !empty($authUser->avatar)
                    ? asset($authUser->avatar)
                    : asset('img/default-avatar.jpg');

    // Notifications are only available for web-guard users (App\Models\User)
    $notifications        = $isWebUser ? optional($authUser)->unreadNotifications : collect();
    $notifications_count  = $notifications->count();
    $notifications_latest = $notifications->take(5);

    // Logout route per guard
    $logoutRoute = match($activeGuard) {
        'student' => 'student.logout',
        'trainer' => 'trainer.logout',
        'center'  => 'center.logout',
        default   => 'logout',
    };
@endphp

<!-- Header -->
<div class="header">
    <div class="main-header">

        <div class="header-left">
            <a href="{{ route('backend.home') }}" class="logo">
                <img src="{{ asset('img/logo-with-text.png') }}" alt="{{ app_name() }}" height="40">
            </a>
            <a href="{{ route('backend.home') }}" class="dark-logo">
                <img src="{{ asset('img/default_logo.jpg') }}" alt="{{ app_name() }}" height="40">
            </a>
        </div>

        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>

        <div class="header-user">
            <div class="nav user-menu nav-list">

                <div class="me-auto d-flex align-items-center" id="header-search">
                    <a id="toggle_btn" href="javascript:void(0);" class="btn btn-menubar me-2">
                        <i class="ti ti-arrow-bar-to-left"></i>
                    </a>
                    <!-- Search -->
                    <div class="input-group input-group-flat d-inline-flex me-2">
                        <input type="text" class="form-control" placeholder="{{ __('Search...') }}">
                        <span class="input-group-text">
                            <kbd>CTRL + /</kbd>
                        </span>
                    </div>
                    <!-- /Search -->
                </div>

                <div class="d-flex align-items-center">

                    <!-- Fullscreen -->
                    <div class="me-2">
                        <a href="#" class="btn btn-menubar btnFullscreen">
                            <i class="ti ti-maximize"></i>
                        </a>
                    </div>

                    <!-- Language -->
                    @if (setting('show_language_dropdown'))
                        <div class="dropdown me-2">
                            <a href="#" class="btn btn-menubar" data-bs-toggle="dropdown">
                                <i class="ti ti-world"></i>&nbsp;{{ strtoupper(App::getLocale()) }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @foreach (config('app.available_locales', []) as $code => $name)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('language.switch', $code) }}">
                                            {{ $name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Notifications -->
                    <div class="me-2 notification_item">
                        <a href="#" class="btn btn-menubar position-relative me-1"
                           id="notification_popup" data-bs-toggle="dropdown">
                            <i class="ti ti-bell"></i>
                            @if ($notifications_count > 0)
                                <span class="notification-status-dot"></span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end notification-dropdown p-4">
                            <div class="d-flex align-items-center justify-content-between border-bottom p-0 pb-3 mb-3">
                                <h4 class="notification-title">
                                    {{ __('Notifications') }} ({{ $notifications_count }})
                                </h4>
                                @if ($isWebUser)
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('backend.notifications.index') }}"
                                       class="text-primary fs-15 me-3 lh-1">
                                        {{ __('View all') }}
                                    </a>
                                </div>
                                @endif
                            </div>
                            <div class="noti-content">
                                <div class="d-flex flex-column">
                                    @forelse ($notifications_latest ?? [] as $notification)
                                        @php
                                            $notification_text = $notification->data['title']
                                                ?? $notification->data['module']
                                                ?? $notification->data['message']
                                                ?? __('Notification');
                                        @endphp
                                        <div class="border-bottom mb-3 pb-3">
                                            <a href="{{ route('backend.notifications.show', $notification) }}">
                                                <div class="d-flex">
                                                    <span class="avatar avatar-lg me-2 flex-shrink-0">
                                                        <img src="{{ asset('img/default-avatar.jpg') }}" alt="Notification">
                                                    </span>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-1">{{ $notification_text }}</p>
                                                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <p class="text-muted text-center mb-0">{{ __('No new notifications') }}</p>
                                    @endforelse
                                </div>
                            </div>
                            @if ($isWebUser)
                            <div class="d-flex p-0 mt-3">
                                <a href="{{ route('backend.notifications.index') }}"
                                   class="btn btn-primary w-100">{{ __('View All') }}</a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="dropdown profile-dropdown">
                        <a href="javascript:void(0);"
                           class="dropdown-toggle d-flex align-items-center"
                           data-bs-toggle="dropdown">
                            <span class="avatar avatar-md online">
                                <img src="{{ $avatar }}" alt="{{ $authUser?->name }}"
                                     class="img-fluid rounded-circle">
                            </span>
                        </a>
                        <div class="dropdown-menu shadow-none">
                            <div class="card mb-0">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-lg me-2 avatar-rounded">
                                            <img src="{{ $avatar }}" alt="{{ $authUser?->name }}">
                                        </span>
                                        <div>
                                            <h5 class="mb-0">{{ $authUser?->name }}</h5>
                                            <p class="fs-12 fw-medium mb-0">{{ $authUser?->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($isWebUser)
                                    <a class="dropdown-item d-inline-flex align-items-center p-0 py-2"
                                       href="{{ route('backend.users.show', $authUser?->id) }}">
                                        <i class="ti ti-user-circle me-1"></i>{{ __('My Profile') }}
                                    </a>
                                    <a class="dropdown-item d-inline-flex align-items-center p-0 py-2"
                                       href="{{ route('backend.settings.index') }}">
                                        <i class="ti ti-settings me-1"></i>{{ __('Settings') }}
                                    </a>
                                    <a class="dropdown-item d-inline-flex align-items-center p-0 py-2"
                                       href="{{ route('backend.notifications.index') }}">
                                        <i class="ti ti-bell me-1"></i>{{ __('Notifications') }}
                                        @if ($notifications_count > 0)
                                            <span class="badge bg-danger ms-2">{{ $notifications_count }}</span>
                                        @endif
                                    </a>
                                    @else
                                    <p class="mb-0 text-muted small">
                                        <i class="ti ti-shield me-1"></i>
                                        {{ ucfirst($activeGuard) }} Portal
                                    </p>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <a class="dropdown-item d-inline-flex align-items-center p-0 py-2"
                                       href="{{ route($logoutRoute) }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form-h1').submit();">
                                        <i class="ti ti-login me-2"></i>{{ __('Logout') }}
                                    </a>
                                    <form id="logout-form-h1" action="{{ route($logoutRoute) }}"
                                          method="POST" style="display:none;">@csrf</form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle"
               data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti ti-dots-vertical"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                @if ($isWebUser)
                <a class="dropdown-item" href="{{ route('backend.users.show', $authUser?->id) }}">
                    {{ __('My Profile') }}
                </a>
                <a class="dropdown-item" href="{{ route('backend.settings.index') }}">
                    {{ __('Settings') }}
                </a>
                @endif
                <a class="dropdown-item" href="{{ route($logoutRoute) }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form-h1').submit();">
                    {{ __('Logout') }}
                </a>
            </div>
        </div>
        <!-- /Mobile Menu -->

    </div>
</div>
<!-- /Header -->
