<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}" dir="{{ language_direction() }}" data-loader="enable">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keywords" content="{{ setting('meta_keyword') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ rtrim(asset(''), '/') }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">

    <!-- DNS prefetch for any external resources -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">

    <!-- Preconnect to asset origin for faster local asset loading -->
    <link rel="preconnect" href="{{ asset('/') }}">

    <!-- Theme Script (must load before CSS to prevent flash) -->
    <script src="{{ asset('assets/js/theme-script.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- VIBES Main CSS — largest file, preload to start download early -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

      <!-- Tabler Icons — preload for faster icon rendering -->
    <link rel="stylesheet" href="{{ asset('assets/css/tabler-icons.min.css') }}">

    @stack('after-styles')
</head>

<body>

    <div id="global-loader">
        <div class="page-loader"></div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include('backend.includes.header-new')
        <!-- /Header -->

        <!-- Sidebar -->
        @include('backend.includes.sidebar-new')
        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        <div class="page-wrapper vh-100 d-flex flex-column justify-content-between">
            <div class="content flex-fill h-100">

                @include('flash::message')
                @include('backend.includes.errors')

                @yield('breadcrumbs')

                <!-- Main content -->
                @yield('content')
                <!-- /Main content -->

            </div>
        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery — loaded first, others depend on it -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

    <!-- VIBES Main Script -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Select2
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    placeholder: '-- Select an option --',
                    width: '100%'
                });
            }

            // Initialize tooltips
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
                new bootstrap.Tooltip(el);
            });
        });
    </script>
@stack('after-scripts')

</body>
</html>
