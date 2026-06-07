<nav class="site-nav" x-data="{ mobileOpen: false }" :class="{ 'scrolled': $store.nav.scrolled }" x-effect="document.body.style.overflow = mobileOpen ? 'hidden' : ''">
    <div class="nav-inner">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="nav-logo">
            <img src="{{ asset('assets/brand/logo-main.png') }}" alt="Redis Solution" class="logo-light">
            <img src="{{ asset('assets/brand/logo-white.png') }}" alt="Redis Solution" class="logo-dark">
        </a>

        {{-- Desktop links --}}
        <ul class="nav-links" role="list">
            <li><a href="{{ route('home') }}"         class="{{ isActive('home') }}">Home</a></li>
            <li><a href="{{ route('about') }}"        class="{{ isActive('about') }}">About</a></li>
            <li><a href="{{ route('services') }}"     class="{{ isActive('services') }}">Services</a></li>
            <li><a href="{{ route('portfolio') }}"    class="{{ isActive('portfolio') }}">Projects</a></li>
            <li><a href="{{ route('faqs') }}"         class="{{ isActive('faqs') }}">FAQs</a></li>
            <li><a href="{{ route('contact') }}"      class="{{ isActive('contact') }}">Contact</a></li>
        </ul>

        {{-- Right side --}}
        <div class="nav-actions">
            <a href="{{ route('free-consultation') }}" class="btn-primary nav-cta-btn">
                Free Consultation
            </a>

            {{-- Mobile hamburger --}}
            <button @click="mobileOpen = !mobileOpen" class="nav-hamburger" aria-label="Toggle menu">
                <span :class="mobileOpen ? 'open' : ''"></span>
            </button>
        </div>

    </div>

    {{-- Mobile menu --}}
    <div class="nav-mobile" x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display:none">
        <ul class="nav-mobile__links" role="list">
            <li><a href="{{ route('home') }}"              class="{{ isActive('home') }}">Home</a></li>
            <li><a href="{{ route('about') }}"             class="{{ isActive('about') }}">About</a></li>
            <li><a href="{{ route('services') }}"          class="{{ isActive('services') }}">Services</a></li>
            <li><a href="{{ route('portfolio') }}"         class="{{ isActive('portfolio') }}">Projects</a></li>
            <li><a href="{{ route('faqs') }}"              class="{{ isActive('faqs') }}">FAQs</a></li>
            <li><a href="{{ route('contact') }}"           class="{{ isActive('contact') }}">Contact</a></li>
            <li><a href="{{ route('free-audit') }}"        class="{{ isActive('free-audit') }}">Free SEO Audit</a></li>
        </ul>
        <div style="margin-top:1.5rem;display:flex;flex-direction:column;gap:0.75rem">
            <a href="{{ route('free-consultation') }}" class="btn-primary" style="display:inline-flex;justify-content:center">
                Free Consultation
            </a>
            <a href="{{ route('contact') }}" class="btn-outline" style="display:inline-flex;justify-content:center">
                Get a Quote
            </a>
        </div>
    </div>
</nav>
