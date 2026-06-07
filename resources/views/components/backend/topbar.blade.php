<header class="crm-topbar" :style="{ left: collapsed ? '72px' : '260px' }">

    {{-- Left: toggle + page title --}}
    <div class="crm-topbar__left">

        {{-- Mobile hamburger (shows on mobile only) --}}
        <button @click="open = !open" class="crm-topbar__hamburger" aria-label="Open menu">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
        </button>

        {{-- Desktop sidebar toggle (shows on desktop only) --}}
        <button @click="toggle()" class="crm-topbar__collapse-btn" aria-label="Toggle sidebar">
            <template x-if="!collapsed">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" /></svg>
            </template>
            <template x-if="collapsed">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" /></svg>
            </template>
        </button>

        <h1 class="crm-topbar__title">{{ $title ?? config('app.name') }}</h1>
    </div>

    {{-- Right: notification bell + user dropdown --}}
    <div class="crm-topbar__right">

        @auth
        @livewire('backend.notification-bell')
        @endauth

        {{-- User dropdown --}}
        <div x-data="{ userOpen: false }" style="position:relative">
            <button @click="userOpen = !userOpen" @click.away="userOpen = false" class="crm-topbar__user-btn">
                <div class="crm-topbar__avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <span class="crm-topbar__username">{{ Auth::user()->name ?? 'User' }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;opacity:0.4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
            </button>

            <div x-show="userOpen" x-transition style="display:none;position:absolute;right:0;top:calc(100% + 8px);min-width:190px;background:var(--crm-card);border:1px solid var(--crm-border);border-radius:10px;padding:0.5rem;z-index:60;box-shadow:var(--crm-shadow)">
                <a href="{{ route('profile.edit') }}" class="crm-dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="crm-dropdown-item crm-dropdown-item--danger">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                        Sign out
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>
