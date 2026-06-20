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

        {{-- Impersonation banner --}}
        @if(session('impersonator_id'))
            <div style="background:#FF6400;color:#fff;padding:0.5rem 1.5rem;font-size:0.82rem;font-weight:600;display:flex;align-items:center;justify-content:center;gap:1rem;flex-wrap:wrap">
                <span style="display:flex;align-items:center;gap:0.4rem">
                    <i class="ri-spy-line"></i>
                    Viewing as <strong>{{ auth()->user()->name }}</strong>
                </span>
                <form method="POST" action="{{ route('admin.impersonate.stop') }}" style="margin:0">
                    @csrf
                    <button type="submit" style="background:rgba(0,0,0,0.2);border:1px solid rgba(255,255,255,0.35);color:#fff;padding:0.2rem 0.8rem;border-radius:6px;font-size:0.78rem;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:0.3rem">
                        <i class="ri-arrow-go-back-line"></i> Return to Admin
                    </button>
                </form>
            </div>
        @endif

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

@livewireScripts

{{-- Flash session → SweetAlert toast --}}
@if(session('success') || session('error') || session('warning') || session('info'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            window.toast?.fire({ icon: 'success', title: @json(session('success')) });
        @endif
        @if(session('error'))
            window.toast?.fire({ icon: 'error', title: @json(session('error')) });
        @endif
        @if(session('warning'))
            window.toast?.fire({ icon: 'warning', title: @json(session('warning')) });
        @endif
        @if(session('info'))
            window.toast?.fire({ icon: 'info', title: @json(session('info')) });
        @endif
    });
</script>
@endif

</body>
</html>
