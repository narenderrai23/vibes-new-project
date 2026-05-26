<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand fw-bold" href="#">{{ config('app.name') }}</a>
    <div class="ms-auto">
        @yield('nav-actions')
    </div>
</nav>

<main class="py-4">
    @yield('content')
</main>

</body>
</html>
