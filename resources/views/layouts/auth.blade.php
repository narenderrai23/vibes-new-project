<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ language_direction() }}">

<head>
    @include('partials.head')
    <style>
        .portal-panel { background: @yield('panel-bg', 'linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%)'); }
        .portal-btn   { background: @yield('btn-color', '#0d6efd') !important; border-color: @yield('btn-color', '#0d6efd') !important; }
        .portal-btn:hover { filter: brightness(1.1); }
        .portal-link  { color: @yield('link-color', '#0d6efd') !important; }
    </style>
</head>

<body class="bg-white">

    <div id="global-loader" style="display: none;">
        <div class="page-loader"></div>
    </div>

    <x-selected-theme />

    <div class="main-wrapper">
        <div class="container-fuild">
            <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
                <div class="row">

                    {{-- ── Left decorative panel ── --}}
                    <div class="col-lg-5">
                        <div class="portal-panel login-background position-relative d-lg-flex align-items-center justify-content-center d-none flex-wrap vh-100">
                            <div class="bg-overlay-img">
                                <img src="{{ asset('assets/img/bg/bg-01.png') }}" class="bg-1" alt="">
                                <img src="{{ asset('assets/img/bg/bg-02.png') }}" class="bg-2" alt="">
                                <img src="{{ asset('assets/img/bg/bg-03.png') }}" class="bg-3" alt="">
                            </div>
                            <div class="authentication-card w-100">
                                <div class="authen-overlay-item border w-100">
                                    @yield('panel-content')
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Right form panel ── --}}
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
                            <div class="col-md-7 mx-auto vh-100">
                                <div class="vh-100 d-flex flex-column justify-content-between p-4 pb-0">

                                    <div class="mx-auto mb-5 text-center">
                                        <img src="{{ asset('img/logo-with-text-dark.png') }}" class="img-fluid" alt="{{ config('app.name') }}">
                                    </div>

                                    @yield('content')

                                    <div class="mt-5 pb-4 text-center">
                                        <p class="mb-0 text-gray-9">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @stack('after-scripts')
</body>
</html>
