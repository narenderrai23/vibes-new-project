@props(['trackingId' => null])

@php
    $trackingId = $trackingId ?? (function_exists('setting') ? setting('google_analytics') : null);
@endphp

@if ($trackingId)
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $trackingId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', '{{ $trackingId }}');
    </script>
@endif
