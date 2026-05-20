<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="{{ setting('meta_description') }}" />
<meta name="keyword" content="{{ setting('meta_keyword') }}" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>@yield('title', $title ?? '') | {{ config('app.name') }}</title>

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicon.png') }}" />
<link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />
<link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" />
<link rel="icon" type="image/ico" href="{{ asset('img/favicon.png') }}" />

<!-- Meta Includes -->
@include('frontend.includes.meta')

<!-- Styles -->
@livewireStyles
<!-- CDNs for CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/light/style.css" rel="stylesheet" />

<!-- CDNs for JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmxc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

@vite(['resources/css/app-frontend.css', 'resources/js/app-frontend.js'])
@stack('after-styles')

<!-- Google Analytics -->
<x-google-analytics />
