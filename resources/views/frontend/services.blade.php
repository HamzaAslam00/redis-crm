<x-layouts.frontend title="Full-Stack Digital Services — Redis Solution">

    <section class="photo-hero">
        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=1600&q=80&auto=format&fit=crop" alt="Services" class="photo-hero__img">
        <div class="photo-hero__overlay"></div>
        <div class="container photo-hero__content">
            <p class="photo-hero__eye">What We Do</p>
            <h1 class="photo-hero__title">Full-Stack Digital Services<br><span>Built to Scale</span></h1>
            <p class="photo-hero__sub">From concept to launch — we design, build and grow digital products that deliver real business results.</p>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         SERVICE 1 — AI APPLICATIONS (odd = content left)
    ═══════════════════════════════════════════════ --}}
    <section class="section" id="ai-applications" style="scroll-margin-top:80px">
        <div class="container">
            <div class="rg-svc" data-gsap-stagger>

                {{-- Content --}}
                <div>
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem">
                        <div style="display:flex;align-items:center;justify-content:center;width:60px;height:60px;border-radius:14px;background:rgba(236,72,153,0.12);border:1px solid rgba(236,72,153,0.25)">
                            <i class="ri-sparkling-2-line" style="color:#EC4899;font-size:1.75rem"></i>
                        </div>
                        <span style="font-size:3rem;font-weight:800;color:rgba(236,72,153,0.15);font-family:'Clash Display',sans-serif;line-height:1">01</span>
                    </div>
                    <h2 style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:700;color:var(--fg-heading);margin-bottom:0.75rem">AI Applications</h2>
                    <p style="font-size:1.1rem;color:var(--fg-text);font-weight:500;margin-bottom:1rem;line-height:1.6">
                        Practical AI products that automate work and create competitive advantage.
                    </p>
                    <p style="color:var(--fg-text-muted);line-height:1.8;margin-bottom:1.5rem">
                        We build AI-powered applications on top of the latest LLMs, computer vision models and ML pipelines — but we keep our feet on the ground. Every feature we ship solves a concrete business problem: automating document processing, generating content at scale, powering intelligent search, or predicting churn before it happens.
                    </p>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1.75rem">
                        @foreach(['OpenAI API','Claude API','Python','FastAPI','LangChain','Vector DBs','RAG','Fine-tuning'] as $tag)
                            <span style="padding:0.3rem 0.75rem;border-radius:99px;background:rgba(236,72,153,0.1);border:1px solid rgba(236,72,153,0.25);color:#EC4899;font-size:0.78rem;font-weight:600">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('contact') }}?service=AI+Applications" class="btn-primary">Get a Quote</a>
                </div>

                {{-- Included card --}}
                <div class="included-card">
                    <div class="included-card__header">
                        <div class="included-card__icon-wrap"><i class="ri-robot-line"></i></div>
                        <span class="included-card__heading">What's Included</span>
                    </div>
                    <ul class="included-card__list">
                        @foreach([
                            'AI use-case discovery & feasibility assessment',
                            'Prompt engineering & LLM integration (OpenAI, Claude)',
                            'Custom fine-tuning or RAG pipeline development',
                            'Secure API design with rate limiting & auth',
                            'Model evaluation, testing & safety guardrails',
                            'Monitoring dashboards for model performance & costs',
                        ] as $item)
                        <li class="included-card__item">
                            <div class="included-card__check"><i class="ri-check-line"></i></div>
                            <span class="included-card__text">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         SERVICE 2 — WEB DEVELOPMENT (even = content right)
    ═══════════════════════════════════════════════ --}}
    <section class="section" id="web-development" style="background:var(--fg-surface);scroll-margin-top:80px">
        <div class="container">
            <div class="rg-svc" data-gsap-stagger>

                {{-- Included card (left on desktop, below content on mobile) --}}
                <div class="included-card svc-even-card">
                    <div class="included-card__header">
                        <div class="included-card__icon-wrap"><i class="ri-code-s-slash-line"></i></div>
                        <span class="included-card__heading">What's Included</span>
                    </div>
                    <ul class="included-card__list">
                        @foreach([
                            'Custom UI/UX design tailored to your brand',
                            'Fully responsive across all devices & browsers',
                            'SEO-optimised markup, meta & structured data',
                            'CMS integration for effortless content updates',
                            'Performance optimisation & Core Web Vitals audit',
                            '3 months post-launch bug-fix support included',
                        ] as $item)
                        <li class="included-card__item">
                            <div class="included-card__check"><i class="ri-check-line"></i></div>
                            <span class="included-card__text">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Content --}}
                <div>
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem">
                        <div style="display:flex;align-items:center;justify-content:center;width:60px;height:60px;border-radius:14px;background:rgba(255,100,0,0.12);border:1px solid rgba(255,100,0,0.25)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF6400" style="width:30px;height:30px"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" /></svg>
                        </div>
                        <span style="font-size:3rem;font-weight:800;color:rgba(255,100,0,0.15);font-family:'Clash Display',sans-serif;line-height:1">02</span>
                    </div>
                    <h2 style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:700;color:var(--fg-heading);margin-bottom:0.75rem">Web Development</h2>
                    <p style="font-size:1.1rem;color:var(--fg-text);font-weight:500;margin-bottom:1rem;line-height:1.6">
                        Performant, SEO-ready websites and web applications engineered for growth.
                    </p>
                    <p style="color:var(--fg-text-muted);line-height:1.8;margin-bottom:1.5rem">
                        We build everything from marketing landing pages to complex multi-tenant SaaS platforms. Our front-end engineers obsess over Core Web Vitals; our back-end team designs systems that handle millions of requests without breaking a sweat. Every project ships with rigorous QA, staging environments and full handover documentation.
                    </p>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1.75rem">
                        @foreach(['Laravel','React','Vue.js','Next.js','Livewire','TailwindCSS','MySQL','PostgreSQL','Redis'] as $tag)
                            <span style="padding:0.3rem 0.75rem;border-radius:99px;background:rgba(255,100,0,0.1);border:1px solid rgba(255,100,0,0.25);color:#FF6400;font-size:0.78rem;font-weight:600">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('contact') }}?service=Web+Development" class="btn-primary">Get a Quote</a>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         SERVICE 3 — MOBILE APPS (odd = content left)
    ═══════════════════════════════════════════════ --}}
    <section class="section" id="mobile-apps" style="scroll-margin-top:80px">
        <div class="container">
            <div class="rg-svc" data-gsap-stagger>

                {{-- Content --}}
                <div>
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem">
                        <div style="display:flex;align-items:center;justify-content:center;width:60px;height:60px;border-radius:14px;background:rgba(99,102,241,0.12);border:1px solid rgba(99,102,241,0.25)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6366F1" style="width:30px;height:30px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 15.75h3" /></svg>
                        </div>
                        <span style="font-size:3rem;font-weight:800;color:rgba(99,102,241,0.15);font-family:'Clash Display',sans-serif;line-height:1">03</span>
                    </div>
                    <h2 style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:700;color:var(--fg-heading);margin-bottom:0.75rem">Mobile Apps</h2>
                    <p style="font-size:1.1rem;color:var(--fg-text);font-weight:500;margin-bottom:1rem;line-height:1.6">
                        Cross-platform mobile apps that feel native on every device.
                    </p>
                    <p style="color:var(--fg-text-muted);line-height:1.8;margin-bottom:1.5rem">
                        We use Flutter to ship one polished codebase that runs beautifully on both iOS and Android — cutting your time-to-market in half without sacrificing quality. From e-commerce apps and fintech wallets to booking platforms and IoT dashboards, we've shipped apps that users actually love using every day.
                    </p>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1.75rem">
                        @foreach(['Flutter','Dart','Firebase','REST API','GraphQL','Google Maps','Stripe SDK','FCM'] as $tag)
                            <span style="padding:0.3rem 0.75rem;border-radius:99px;background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.25);color:#6366F1;font-size:0.78rem;font-weight:600">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('contact') }}?service=Mobile+Apps" class="btn-primary">Get a Quote</a>
                </div>

                {{-- Included card --}}
                <div class="included-card">
                    <div class="included-card__header">
                        <div class="included-card__icon-wrap"><i class="ri-smartphone-line"></i></div>
                        <span class="included-card__heading">What's Included</span>
                    </div>
                    <ul class="included-card__list">
                        @foreach([
                            'Single codebase for iOS & Android (Flutter)',
                            'User authentication, push notifications & deep links',
                            'Offline-first architecture with local data sync',
                            'Payment gateway & in-app purchase integration',
                            'App Store & Google Play submission handled',
                            'Analytics dashboards and crash reporting setup',
                        ] as $item)
                        <li class="included-card__item">
                            <div class="included-card__check"><i class="ri-check-line"></i></div>
                            <span class="included-card__text">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         SERVICE 4 — DIGITAL MARKETING (even = content right)
    ═══════════════════════════════════════════════ --}}
    <section class="section" id="digital-marketing" style="background:var(--fg-surface);scroll-margin-top:80px">
        <div class="container">
            <div class="rg-svc" data-gsap-stagger>

                {{-- Included card (left on desktop, below content on mobile) --}}
                <div class="included-card svc-even-card">
                    <div class="included-card__header">
                        <div class="included-card__icon-wrap"><i class="ri-bar-chart-line"></i></div>
                        <span class="included-card__heading">What's Included</span>
                    </div>
                    <ul class="included-card__list">
                        @foreach([
                            'Full competitor & keyword research audit',
                            'Google & Meta paid ad campaign setup & management',
                            'Technical SEO — site audit, fixes & on-page optimisation',
                            'Monthly performance reports with actionable insights',
                            'Conversion tracking, pixels & analytics configuration',
                            'A/B testing of ad creatives and landing pages',
                        ] as $item)
                        <li class="included-card__item">
                            <div class="included-card__check"><i class="ri-check-line"></i></div>
                            <span class="included-card__text">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Content --}}
                <div>
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem">
                        <div style="display:flex;align-items:center;justify-content:center;width:60px;height:60px;border-radius:14px;background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.25)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10B981" style="width:30px;height:30px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" /></svg>
                        </div>
                        <span style="font-size:3rem;font-weight:800;color:rgba(16,185,129,0.15);font-family:'Clash Display',sans-serif;line-height:1">04</span>
                    </div>
                    <h2 style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:700;color:var(--fg-heading);margin-bottom:0.75rem">Digital Marketing</h2>
                    <p style="font-size:1.1rem;color:var(--fg-text);font-weight:500;margin-bottom:1rem;line-height:1.6">
                        Data-driven campaigns that turn visibility into revenue.
                    </p>
                    <p style="color:var(--fg-text-muted);line-height:1.8;margin-bottom:1.5rem">
                        We don't just run ads — we build growth systems. Our team combines technical SEO, paid media, conversion rate optimisation and content strategy into one cohesive engine. Every rupee and dollar you spend is tracked, attributed and optimised so you know exactly what's working and why.
                    </p>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1.75rem">
                        @foreach(['Google Ads','Meta Ads','SEO','Analytics','GTM','Email Marketing','CRO','Content Strategy'] as $tag)
                            <span style="padding:0.3rem 0.75rem;border-radius:99px;background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.25);color:#10B981;font-size:0.78rem;font-weight:600">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('contact') }}?service=Digital+Marketing" class="btn-primary">Get a Quote</a>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         SERVICE 5 — ERP & CMS (odd = content left)
    ═══════════════════════════════════════════════ --}}
    <section class="section" id="erp-cms" style="scroll-margin-top:80px">
        <div class="container">
            <div class="rg-svc" data-gsap-stagger>

                {{-- Content --}}
                <div>
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem">
                        <div style="display:flex;align-items:center;justify-content:center;width:60px;height:60px;border-radius:14px;background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.25)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#F59E0B" style="width:30px;height:30px"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" /></svg>
                        </div>
                        <span style="font-size:3rem;font-weight:800;color:rgba(245,158,11,0.15);font-family:'Clash Display',sans-serif;line-height:1">05</span>
                    </div>
                    <h2 style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:700;color:var(--fg-heading);margin-bottom:0.75rem">ERP &amp; CMS Solutions</h2>
                    <p style="font-size:1.1rem;color:var(--fg-text);font-weight:500;margin-bottom:1rem;line-height:1.6">
                        Bespoke business management systems that eliminate operational chaos.
                    </p>
                    <p style="color:var(--fg-text-muted);line-height:1.8;margin-bottom:1.5rem">
                        Off-the-shelf ERP systems force your business to adapt to software. We do it the other way around — building tailored systems that map exactly to your workflows. Whether you need a full factory ERP, a headless CMS for a media company or an HR platform for a 500-person enterprise, we deliver solutions that actually get used.
                    </p>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1.75rem">
                        @foreach(['Laravel','Filament','MySQL','Redis','WordPress','REST API','Webhooks','Docker'] as $tag)
                            <span style="padding:0.3rem 0.75rem;border-radius:99px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);color:#F59E0B;font-size:0.78rem;font-weight:600">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('contact') }}?service=ERP+%26+CMS" class="btn-primary">Get a Quote</a>
                </div>

                {{-- Included card --}}
                <div class="included-card">
                    <div class="included-card__header">
                        <div class="included-card__icon-wrap"><i class="ri-layout-grid-line"></i></div>
                        <span class="included-card__heading">What's Included</span>
                    </div>
                    <ul class="included-card__list">
                        @foreach([
                            'Requirements workshop & process mapping',
                            'Custom modules: inventory, HR, payroll & procurement',
                            'Role-based access control & audit logging',
                            'Third-party integrations (accounting, e-commerce, APIs)',
                            'Data migration from legacy systems',
                            'Staff training sessions & ongoing support',
                        ] as $item)
                        <li class="included-card__item">
                            <div class="included-card__check"><i class="ri-check-line"></i></div>
                            <span class="included-card__text">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         SERVICE 6 — SOFTWARE DEVELOPMENT (even = content right)
    ═══════════════════════════════════════════════ --}}
    <section class="section" id="software-development" style="background:var(--fg-surface);scroll-margin-top:80px">
        <div class="container">
            <div class="rg-svc" data-gsap-stagger>

                {{-- Included card (left on desktop, below content on mobile) --}}
                <div class="included-card svc-even-card">
                    <div class="included-card__header">
                        <div class="included-card__icon-wrap"><i class="ri-terminal-box-line"></i></div>
                        <span class="included-card__heading">What's Included</span>
                    </div>
                    <ul class="included-card__list">
                        @foreach([
                            'Technical architecture design & documentation',
                            'Agile development with bi-weekly sprint demos',
                            'Full test coverage — unit, feature & end-to-end',
                            'CI/CD pipelines, Docker & cloud deployment',
                            'Code review, security audits & performance profiling',
                            'Source code ownership transferred 100% to you',
                        ] as $item)
                        <li class="included-card__item">
                            <div class="included-card__check"><i class="ri-check-line"></i></div>
                            <span class="included-card__text">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Content --}}
                <div>
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem">
                        <div style="display:flex;align-items:center;justify-content:center;width:60px;height:60px;border-radius:14px;background:rgba(14,165,233,0.12);border:1px solid rgba(14,165,233,0.25)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#0EA5E9" style="width:30px;height:30px"><path stroke-linecap="round" stroke-linejoin="round" d="m6.75 7.5 3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0 0 21 18V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v12a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                        </div>
                        <span style="font-size:3rem;font-weight:800;color:rgba(14,165,233,0.15);font-family:'Clash Display',sans-serif;line-height:1">06</span>
                    </div>
                    <h2 style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:700;color:var(--fg-heading);margin-bottom:0.75rem">Software Development</h2>
                    <p style="font-size:1.1rem;color:var(--fg-text);font-weight:500;margin-bottom:1rem;line-height:1.6">
                        End-to-end custom software built to exact specification, on time and on budget.
                    </p>
                    <p style="color:var(--fg-text-muted);line-height:1.8;margin-bottom:1.5rem">
                        Need a SaaS platform, a marketplace, an internal tool or something entirely new? We take complex requirements and turn them into clean, maintainable software. Our agile process keeps you in the loop every step of the way — no surprises, no scope creep, just consistent delivery you can count on.
                    </p>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1.75rem">
                        @foreach(['PHP','Laravel','Node.js','Python','TypeScript','PostgreSQL','Docker','AWS'] as $tag)
                            <span style="padding:0.3rem 0.75rem;border-radius:99px;background:rgba(14,165,233,0.1);border:1px solid rgba(14,165,233,0.25);color:#0EA5E9;font-size:0.78rem;font-weight:600">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('contact') }}?service=Software+Development" class="btn-primary">Get a Quote</a>
                </div>

            </div>
        </div>
    </section>

    <x-frontend.cta-banner />

    @push('scripts')
    <script>
        window.addEventListener('load', function () {
            var hash = window.location.hash;
            if (!hash) return;
            var el = document.querySelector(hash);
            if (!el) return;
            setTimeout(function () {
                var top = el.getBoundingClientRect().top + window.scrollY - 88;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }, 120);
        });
    </script>
    @endpush

</x-layouts.frontend>
