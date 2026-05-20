<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->currentLocale()) }}" dir="{{ language_direction() }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
        <link type="image/png" href="{{ asset("img/favicon.png") }}" rel="icon" />
        <link href="{{ asset("img/favicon.png") }}" rel="apple-touch-icon" sizes="76x76" />
        <meta name="keyword" content="{{ setting("meta_keyword") }}" />
        <meta name="description" content="{{ setting("meta_description") }}" />

        <!-- Shortcut Icon -->
        <link href="{{ asset("img/favicon.png") }}" rel="shortcut icon" />
        <link type="image/ico" href="{{ asset("img/favicon.png") }}" rel="icon" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield("title") | {{ config("app.name") }}</title>

        <!-- CDNs for CSS -->
        <link href="https://cdn.jsdelivr.net/npm/simplebar@6.2.5/dist/simplebar.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.0.0/dist/css/coreui.min.css" rel="stylesheet" />
        <link href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/light/style.css" rel="stylesheet" />

        <!-- CDNs for JS -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.0.0/dist/js/coreui.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simplebar@6.2.5/dist/simplebar.min.js"></script>

        @vite(["resources/sass/app-backend.scss"])

        {{-- Use Roboto font --}}
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Roboto', sans-serif;
            }

            :lang(bn),
            [lang^="bn"] {
                font-family: 'Noto Sans Bengali', Arial, Helvetica, sans-serif;
            }

            ul.nav-group-items.compact {
                margin-left: 10px;
            }
        </style>

        @stack("after-styles")

        @livewireStyles
    </head>

    <body>
        <x-selected-theme />

        <!-- Sidebar -->
        @include("backend.includes.sidebar")
        <!-- /Sidebar -->

        <div class="wrapper d-flex flex-column min-vh-100">
            {{-- header --}}
            @include("backend.includes.header")

            <div class="body flex grow">
                <div class="container-lg px-4 py-2">
                    @include("flash::message")

                    <!-- Errors block -->
                    @include("backend.includes.errors")
                    <!-- / Errors block -->

                    <!-- Main content block -->
                    @yield("content")
                    <!-- / Main content block -->
                </div>
            </div>

            {{-- Footer block --}}
            <x-backend.includes.footer />
        </div>

        <!-- Scripts -->
        @livewireScripts

        @stack("after-scripts")
        <!-- / Scripts -->
    </body>
</html>
