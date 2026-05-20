<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}" dir="{{ language_direction() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keywords" content="{{ setting('meta_keyword') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">

    <!-- Theme Script (must load before CSS to prevent flash) -->
    <script src="{{ asset('assets/js/theme-script.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/tabler-icons.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">

    <!-- SmartHR Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    
    @livewireStyles
    @stack('after-styles')
</head>

<body>

    <div id="global-loader" style="display: none;">
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

                <!-- Main content -->
                @yield('content')
                <!-- /Main content -->

            </div>

            <!-- Footer -->
            <div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
                <p class="mb-0">
                    &copy; {{ date('Y') }} {{ app_name() }}.
                    @if (setting('show_credit'))
                        {!! setting('footer_text') !!}
                    @endif
                </p>
                <p class="mb-0">{{ date_today() }}</p>
            </div>
            <!-- /Footer -->
        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    <!-- SmartHR Main Script -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2({
                placeholder: '-- Select an option --',
                width: '100%'
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (el) {
                new bootstrap.Tooltip(el);
            });
        });
    </script>

    @livewireScripts
    @stack('after-scripts')

</body>
</html>
