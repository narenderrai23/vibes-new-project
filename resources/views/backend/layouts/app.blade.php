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
        <link rel="preload" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/light/style.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
        <noscript><link href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/light/style.css" rel="stylesheet" /></noscript>

        <!-- CDNs for JS — moved to defer, loaded after HTML parse -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.0.0/dist/js/coreui.bundle.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/simplebar@6.2.5/dist/simplebar.min.js" defer></script>

        @vite(["resources/sass/app-backend.scss"])

        {{-- Google Fonts — preconnect to reduce latency --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
        <noscript><link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"></noscript>
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
@stack("after-scripts")
        <!-- / Scripts -->
    </body>
</html>
