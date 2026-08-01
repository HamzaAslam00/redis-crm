<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ setting('theme', 'light') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta (managed via admin SEO panel) --}}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! TwitterCard::generate() !!}

    {{-- JSON-LD Schema: use page-specific schema from DB; fallback to minimal WebPage --}}
    @isset($_schemaJson)
        <script type="application/ld+json">{!! $_schemaJson !!}</script>
    @else
        {!! JsonLd::generate() !!}
    @endisset

    {{-- Preload first-party CSS as early as possible --}}
    <link rel="preload" as="style" href="{{ Vite::asset('resources/scss/public.scss') }}">

    {{-- Preconnects --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://api.fontshare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    {{-- Google Fonts: async load to avoid render-blocking --}}
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Space+Grotesk:wght@400;500;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet"></noscript>

    {{-- Clash Display from Fontshare --}}
    <link rel="preload" as="style" href="https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600,700,800&display=swap">
    <link rel="stylesheet" href="https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600,700,800&display=swap" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600,700,800&display=swap"></noscript>

    {{-- Remix Icons --}}
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"></noscript>

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" href="{{ asset('assets/brand/favicon-white-16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ asset('assets/brand/favicon-white-32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('assets/brand/favicon-192.png') }}" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ asset('assets/brand/favicon-apple-white.png') }}">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#FF6400">

    {{-- Website CSS --}}
    @vite(['resources/scss/public.scss', 'resources/js/public.js'])

    {{-- Page-level head injection --}}
    @stack('styles')
</head>
<body>

{{-- Custom cursor --}}
<div class="custom-cursor" aria-hidden="true"></div>

{{-- Navigation --}}
@include('components.frontend.nav')

{{-- Wrapper clips horizontal overflow without affecting fixed nav --}}
<div class="page-wrapper">

    {{-- Page content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    @include('components.frontend.footer')

</div>

{{-- WhatsApp floating bubble --}}
@include('components.whatsapp-bubble')

{{-- Page-level scripts --}}
@stack('scripts')

{{-- Global: disable submit buttons on form submit to prevent double-clicks --}}
<script>
document.addEventListener('submit', function (e) {
    const form = e.target;
    if (form.dataset.noAutoDisable) { return; }
    form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (btn) {
        btn.disabled = true;
        if (btn.dataset.loadingText) { btn.textContent = btn.dataset.loadingText; }
    });
});
</script>

</body>
</html>
