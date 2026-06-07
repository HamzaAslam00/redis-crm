<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — CRM</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/brand/favicon-white-32.png') }}" sizes="32x32">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body class="auth-body">

<div class="auth-split">

    {{-- ─── Left: Brand Panel ────────────────────────────────────────────── --}}
    <div class="auth-brand">

        {{-- Decorative glows --}}
        <div class="auth-brand__glow auth-brand__glow--1"></div>
        <div class="auth-brand__glow auth-brand__glow--2"></div>
        <div class="auth-brand__grid"></div>

        {{-- Logo --}}
        <div class="auth-brand__logo">
            <img src="{{ asset('assets/brand/logo-white.png') }}" alt="Redis Solution">
        </div>

        {{-- Hero copy --}}
        <div class="auth-brand__hero">
            <span class="auth-brand__eyebrow">Business Operations Center</span>
            <h1 class="auth-brand__headline">
                Run your agency<br>with full<br><em>clarity.</em>
            </h1>
            <p class="auth-brand__sub">
                One unified platform for projects, finances, client vault, and your public website — all in one place.
            </p>

            {{-- Feature list --}}
            <ul class="auth-feat">
                <li class="auth-feat__item">
                    <span class="auth-feat__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3" /></svg>
                    </span>
                    <div>
                        <div class="auth-feat__title">Project & Client Management</div>
                        <div class="auth-feat__desc">Full project lifecycle from quote to delivery</div>
                    </div>
                </li>
                <li class="auth-feat__item">
                    <span class="auth-feat__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                    <div>
                        <div class="auth-feat__title">Budget & Investments</div>
                        <div class="auth-feat__desc">Real-time P&L, expenses, income tracking</div>
                    </div>
                </li>
                <li class="auth-feat__item">
                    <span class="auth-feat__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
                    </span>
                    <div>
                        <div class="auth-feat__title">Encrypted Vault</div>
                        <div class="auth-feat__desc">API keys, credentials & hosting — AES-256 secured</div>
                    </div>
                </li>
                <li class="auth-feat__item">
                    <span class="auth-feat__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253" /></svg>
                    </span>
                    <div>
                        <div class="auth-feat__title">Website CMS</div>
                        <div class="auth-feat__desc">Blog, portfolio, proposals — managed from here</div>
                    </div>
                </li>
            </ul>
        </div>

        {{-- Bottom strip --}}
        <div class="auth-brand__footer">
            <span>Redis Solution Pvt. Ltd.</span>
            <span class="auth-brand__footer-dot">·</span>
            <span>redissolution.com</span>
        </div>

    </div>

    {{-- ─── Right: Form Panel ────────────────────────────────────────────── --}}
    <div class="auth-form-panel">

        {{-- Mobile-only logo --}}
        <div class="auth-form-panel__mobile-logo">
            <img src="{{ asset('assets/brand/logo-white.png') }}" alt="Redis Solution" style="height:32px">
        </div>

        <div class="auth-form-wrap">
            {{ $slot }}
        </div>

        <div class="auth-form-panel__back">
            <a href="{{ url('/') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                Back to website
            </a>
        </div>

    </div>

</div>

</body>
</html>
