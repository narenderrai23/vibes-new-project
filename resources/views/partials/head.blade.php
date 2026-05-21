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


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- SmartHR Main CSS — largest file, preload to start download early -->
    <link rel="preload" href="{{ asset('assets/css/style.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"></noscript>

      <!-- Tabler Icons — preload for faster icon rendering -->
    <link rel="preload" href="{{ asset('assets/css/tabler-icons.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('assets/css/tabler-icons.min.css') }}"></noscript>

@stack('after-styles')

<!-- Google Analytics -->
<x-google-analytics />
