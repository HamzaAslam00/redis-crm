<x-layouts.frontend title="Our Portfolio — Redis Solution">

    {{-- ═══════════════════════════════════════════════
         PAGE HERO
    ═══════════════════════════════════════════════ --}}
    <section class="photo-hero">
        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=1600&q=80&auto=format&fit=crop" alt="Our Work" class="photo-hero__img">
        <div class="photo-hero__overlay"></div>
        <div class="container photo-hero__content">
            <p class="photo-hero__eye">Case Studies</p>
            <h1 class="photo-hero__title">Our Work<br><span>Speaks For Itself</span></h1>
            <p class="photo-hero__sub">Real projects, real results. Browse work across web, mobile, marketing and more.</p>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         FILTER TABS + PORTFOLIO GRID
    ═══════════════════════════════════════════════ --}}
    <section class="section">
        <div class="container">

            {{-- Filter tabs --}}
            <div class="filter-tabs" data-gsap-fade>
                <button class="filter-tab active" data-filter="all" aria-pressed="true">All</button>
                <button class="filter-tab" data-filter="web">Web</button>
                <button class="filter-tab" data-filter="mobile">Mobile</button>
                <button class="filter-tab" data-filter="marketing">Digital Marketing</button>
                <button class="filter-tab" data-filter="erp">ERP</button>
                <button class="filter-tab" data-filter="ai">AI</button>
            </div>

            {{-- Portfolio grid --}}
            <div class="portfolio-grid" style="margin-top:2.5rem" data-gsap-stagger id="portfolio-grid">

                @forelse($items as $item)
                    @php $label = \App\Models\PortfolioItem::categoryLabel($item->category); @endphp
                    <div class="portfolio-card" data-category="{{ $item->category }}">

                        {{-- Thumb --}}
                        <div class="portfolio-card__thumb">
                            <img
                                src="{{ $item->featured_image ?: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=700&q=80&auto=format&fit=crop' }}"
                                alt="{{ $item->title }}"
                                class="img-cover"
                                loading="lazy"
                            >
                            <div class="portfolio-card__overlay">
                                <span class="portfolio-card__category">{{ $label }}</span>
                                <h3 style="font-size:1rem;font-weight:700;color:#fff;margin:0.2rem 0">{{ $item->title }}</h3>
                            </div>
                        </div>

                        {{-- Meta --}}
                        <div class="portfolio-card__meta">
                            <span class="portfolio-card__category">{{ $label }}</span>
                            <h3 class="portfolio-card__title">{{ $item->title }}</h3>
                            <p class="portfolio-card__desc">{{ $item->short_desc }}</p>
                            @if($item->tech_stack)
                                <div class="portfolio-card__tags">
                                    @foreach($item->tech_stack as $tag)
                                        <span class="portfolio-card__tag">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                @empty
                    <div style="grid-column:1/-1;text-align:center;padding:4rem 1rem;color:rgba(255,255,255,0.4)">
                        <p style="font-size:1.1rem">Portfolio coming soon — check back shortly.</p>
                    </div>
                @endforelse

            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         CTA BANNER
    ═══════════════════════════════════════════════ --}}
    <section class="section" style="background:var(--fg-surface)">
        <div class="container">
            <div class="cta-banner" data-gsap-fade>
                <div class="cta-banner__glow"></div>
                <p class="cta-banner__title">Have a Project in Mind?</p>
                <p class="cta-banner__sub">
                    Let's add your project to this list. Share your idea and we'll put together a clear plan, timeline and cost estimate — for free.
                </p>
                <div class="cta-banner__actions">
                    <a href="{{ route('contact') }}" class="btn-primary">Get a Quote</a>
                    <a href="{{ route('services') }}" class="btn-outline">View Services</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Filter + sort JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs   = document.querySelectorAll('.filter-tab');
            const cards  = document.querySelectorAll('.portfolio-card');

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    const filter = tab.dataset.filter;

                    tabs.forEach(function (t) { t.setAttribute('aria-pressed', 'false'); });
                    tab.setAttribute('aria-pressed', 'true');

                    cards.forEach(function (card) {
                        const match = filter === 'all' || card.dataset.category === filter;
                        card.style.display        = match ? '' : 'none';
                        card.style.opacity        = match ? '1' : '0';
                        card.style.pointerEvents  = match ? '' : 'none';
                    });
                });
            });
        });
    </script>

</x-layouts.frontend>
