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

                @php
                    $projects = [
                        [
                            'category' => 'web',
                            'label'    => 'Web Development',
                            'title'    => 'PakBazar E-Commerce',
                            'desc'     => 'Multi-vendor marketplace with 10K+ SKUs, seller onboarding, real-time inventory and Stripe payment integration.',
                            'img'      => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=700&q=80&auto=format&fit=crop',
                            'tags'     => ['Laravel', 'Vue.js', 'MySQL', 'Stripe'],
                        ],
                        [
                            'category' => 'mobile',
                            'label'    => 'Mobile App',
                            'title'    => 'RideFlow Ride-Hailing',
                            'desc'     => 'Flutter ride-hailing app with live driver tracking, Firebase real-time updates and in-app payment.',
                            'img'      => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=700&q=80&auto=format&fit=crop',
                            'tags'     => ['Flutter', 'Firebase', 'Google Maps'],
                        ],
                        [
                            'category' => 'erp',
                            'label'    => 'ERP Solution',
                            'title'    => 'TechManage ERP',
                            'desc'     => 'Complete factory ERP covering inventory management, HR & payroll, procurement and financial reporting.',
                            'img'      => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=700&q=80&auto=format&fit=crop',
                            'tags'     => ['Laravel', 'MySQL', 'Redis'],
                        ],
                        [
                            'category' => 'marketing',
                            'label'    => 'Digital Marketing',
                            'title'    => 'SEO Campaign — Retail Brand',
                            'desc'     => 'Took a retail brand from page 5 to #1 position for 15 high-intent keywords in 6 months.',
                            'img'      => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=700&q=80&auto=format&fit=crop',
                            'tags'     => ['SEO', 'Google Ads', 'Analytics'],
                        ],
                        [
                            'category' => 'mobile',
                            'label'    => 'Mobile App',
                            'title'    => 'MediBook Healthcare App',
                            'desc'     => 'Patient appointment booking for a 12-clinic chain with real-time slot management.',
                            'img'      => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=700&q=80&auto=format&fit=crop',
                            'tags'     => ['Flutter', 'Firebase', 'REST API'],
                        ],
                        [
                            'category' => 'ai',
                            'label'    => 'AI Application',
                            'title'    => 'AI Content Platform',
                            'desc'     => 'LLM-powered content generation tool for marketing agencies — SEO-ready articles, ads and social copy at scale.',
                            'img'      => 'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=700&q=80&auto=format&fit=crop',
                            'tags'     => ['Python', 'OpenAI', 'FastAPI'],
                        ],
                        [
                            'category' => 'web',
                            'label'    => 'Web Development',
                            'title'    => 'Zindagi Restaurant Website',
                            'desc'     => 'Beautiful menu site with online ordering, table booking and admin dashboard for reservations.',
                            'img'      => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=700&q=80&auto=format&fit=crop',
                            'tags'     => ['Next.js', 'TailwindCSS', 'Stripe'],
                        ],
                        [
                            'category' => 'web',
                            'label'    => 'Web / IoT',
                            'title'    => 'SolarTrack IoT Dashboard',
                            'desc'     => 'Real-time solar panel monitoring SaaS with MQTT data ingestion, alerts and historical analytics.',
                            'img'      => 'https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?w=700&q=80&auto=format&fit=crop',
                            'tags'     => ['Laravel', 'Vue', 'MQTT', 'IoT'],
                        ],
                        [
                            'category' => 'marketing',
                            'label'    => 'Digital Marketing',
                            'title'    => 'Meta Ads — Fashion Brand',
                            'desc'     => '340% ROAS improvement over 90 days via creative testing, audience segmentation and funnel optimisation.',
                            'img'      => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=700&q=80&auto=format&fit=crop',
                            'tags'     => ['Meta Ads', 'Creatives', 'A/B Testing'],
                        ],
                    ];
                @endphp

                @foreach($projects as $project)
                    <div class="portfolio-card" data-category="{{ $project['category'] }}">

                        {{-- Thumb --}}
                        <div class="portfolio-card__thumb">
                            <img
                                src="{{ $project['img'] }}"
                                alt="{{ $project['title'] }}"
                                class="img-cover"
                                loading="lazy"
                            >
                            <div class="portfolio-card__overlay">
                                <span class="portfolio-card__category">{{ $project['label'] }}</span>
                                <h3 style="font-size:1rem;font-weight:700;color:#fff;margin:0.2rem 0">{{ $project['title'] }}</h3>
                            </div>
                        </div>

                        {{-- Meta --}}
                        <div class="portfolio-card__meta">
                            <span class="portfolio-card__category">{{ $project['label'] }}</span>
                            <h3 class="portfolio-card__title">{{ $project['title'] }}</h3>
                            <p class="portfolio-card__desc">{{ $project['desc'] }}</p>
                            <div class="portfolio-card__tags">
                                @foreach($project['tags'] as $tag)
                                    <span class="portfolio-card__tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>

                    </div>
                @endforeach

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
