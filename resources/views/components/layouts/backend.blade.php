<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ setting('theme', 'dark') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }} — CRM</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/brand/favicon-white-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('assets/brand/favicon-apple-white.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">

    {{-- Tailwind 4 + App SCSS --}}
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    {{-- Page-level head injection --}}
    @stack('styles')

    @livewireStyles
</head>
<body class="antialiased">

<div class="crm-wrapper" x-data="sidebar">

    {{-- Sidebar --}}
    @include('components.backend.sidebar')

    {{-- Mobile overlay --}}
    <div
        x-show="open"
        x-transition.opacity.duration.200ms
        @click="open = false"
        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:40"
    ></div>

    {{-- Main content area --}}
    <div class="crm-main" :class="{ 'sidebar-collapsed': collapsed }">

        {{-- Topbar --}}
        @include('components.backend.topbar')

        {{-- Page content --}}
        <main class="crm-content">
            @include('components.backend.breadcrumb')

            {{ $slot }}
        </main>

    </div>

</div>

{{-- Common CRM scripts (delete confirm, toasts, etc.) --}}
<script src="{{ asset('assets/js/common.js') }}"></script>

{{-- Register sidebar Alpine data before Livewire starts Alpine --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('sidebar', () => ({
        open: false,
        collapsed: localStorage.getItem('sidebar_collapsed') === 'true',
        toggle() {
            if (window.innerWidth >= 1024) {
                this.collapsed = !this.collapsed;
                localStorage.setItem('sidebar_collapsed', this.collapsed);
            } else {
                this.open = !this.open;
            }
        }
    }));
});
</script>

{{-- Page-level scripts --}}
@stack('scripts')

@livewireScripts

</body>
</html>
