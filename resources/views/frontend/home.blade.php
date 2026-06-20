<x-layouts.frontend title="Redis Solution — We Make Your Business Digital">

{{-- ══════════════════════════════════════════════════════════ HERO --}}
<section class="hero-v2">
    <div class="container">
        <div class="hero-v2__grid">

            {{-- Left: copy --}}
            <div class="hero-v2__left">
                <div class="hero-v2__badge">
                    <i class="ri-star-fill" style="color:#FFB800;font-size:0.85rem"></i>
                    Trusted by 100+ Businesses Worldwide
                </div>

                <h1 class="hero-v2__title">
                    We Make Your<br>Business
                    <span class="gradient-text">Digital</span>
                </h1>

                <p class="hero-v2__sub">
                    Transform your business with our cutting-edge digital solutions,
                    designed to drive growth and innovation. From strategy to
                    implementation, we'll guide every step of the way.
                </p>

                <div class="hero-v2__actions">
                    <a href="{{ route('free-consultation') }}" class="btn-primary btn-primary--lg">
                        <i class="ri-calendar-check-line"></i>
                        Free Consultation
                    </a>
                    <a href="tel:{{ preg_replace('/\s+/', '', setting('company_phone','+923493614440')) }}" class="hero-v2__phone">
                        <div class="hero-v2__phone-icon">
                            <i class="ri-phone-fill"></i>
                        </div>
                        <div>
                            <div class="hero-v2__phone-label">Call Us Anytime</div>
                            <div class="hero-v2__phone-num">{{ setting('company_phone','+92 349 3614440') }}</div>
                        </div>
                    </a>
                </div>

                <div class="hero-v2__trust">
                    <div class="hero-v2__trust-item">
                        <i class="ri-shield-check-fill" style="color:#34D399"></i>
                        <span>NDA Protected</span>
                    </div>
                    <div class="hero-v2__trust-sep"></div>
                    <div class="hero-v2__trust-item">
                        <i class="ri-time-fill" style="color:#FF6400"></i>
                        <span>On-time Delivery</span>
                    </div>
                    <div class="hero-v2__trust-sep"></div>
                    <div class="hero-v2__trust-item">
                        <i class="ri-customer-service-2-fill" style="color:#6366F1"></i>
                        <span>24/7 Support</span>
                    </div>
                </div>
            </div>

            {{-- Right: AI dev lifecycle pipeline --}}
            <div class="hero-v2__right" aria-hidden="true">

                <div class="hero-v2__visual">

                    {{-- Animated pipeline card --}}
                    <div class="dev-pipeline" id="devPipeline">
                        <div class="dev-pipeline__titlebar">
                            <div class="dev-pipeline__wc">
                                <span></span><span></span><span></span>
                            </div>
                            <span class="dev-pipeline__title">
                                <i class="ri-git-branch-line"></i> redis-solution / ai-dev-lifecycle
                            </span>
                            <span class="dev-pipeline__live">
                                <span class="dev-pipeline__live-dot"></span> LIVE
                            </span>
                        </div>

                        <div class="dev-pipeline__body">
                            @php
                            $stages = [
                                ['ri-user-star-line',    '#FF6400', 'Client Discovery',  'Brief received · requirements mapped',      'done',   '0.1s'],
                                ['ri-robot-line',        '#6366F1', 'AI Planning',        'Stack, architecture & timeline defined',    'done',   '0.55s'],
                                ['ri-code-s-slash-line', '#10B981', 'Development',        'Full-stack build with AI pair-programming', 'done',   '1.0s'],
                                ['ri-test-tube-line',    '#0EA5E9', 'Testing & QA',       '24/24 passed · 0 bugs found',               'done',   '1.45s'],
                                ['ri-rocket-2-line',     '#FF6400', 'Deployment',         'Pushing to production server…',             'active', '1.9s'],
                            ];
                            @endphp
                            @foreach($stages as $idx => [$icon, $color, $label, $sub, $state, $delay])
                            <div class="dp-row dp-row--{{ $state }}" style="--delay:{{ $delay }}" data-stage="{{ $idx }}">
                                <div class="dp-row__icon" style="color:{{ $color }};background:{{ $color }}18;border:1px solid {{ $color }}30">
                                    <i class="{{ $icon }}"></i>
                                </div>
                                <div class="dp-row__info">
                                    <div class="dp-row__label">{{ $label }}</div>
                                    <div class="dp-row__sub">{{ $sub }}</div>
                                </div>
                                <div class="dp-row__status">
                                    @if($state === 'done')
                                        <i class="ri-checkbox-circle-fill dp-row__check"></i>
                                    @else
                                        <span class="dp-row__spinner" style="border-top-color:{{ $color }}"></span>
                                    @endif
                                </div>
                            </div>
                            @if(!$loop->last)
                                <div class="dp-connector" style="--delay:{{ $delay }}"></div>
                            @endif
                            @endforeach
                        </div>

                        <div class="dev-pipeline__footer">
                            @foreach([
                                ['#10B981','ri-shield-check-line','On-Time Delivery'],
                                ['#6366F1','ri-robot-line',       'AI-Powered Build'],
                                ['#FF6400','ri-lock-line',        'NDA Protected'],
                            ] as [$color, $icon, $label])
                            <span class="dp-tag" style="color:{{ $color }};background:{{ $color }}12;border:1px solid {{ $color }}28">
                                <i class="{{ $icon }}"></i> {{ $label }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Floating stat badges --}}
                    <div class="hero-v2__stat hero-v2__stat--1">
                        <div class="hero-v2__stat-val" data-count="{{ setting('counter_clients','100') }}" data-suffix="+">{{ setting('counter_clients','100') }}+</div>
                        <div class="hero-v2__stat-label">Happy Clients</div>
                    </div>
                    <div class="hero-v2__stat hero-v2__stat--2">
                        <div class="hero-v2__stat-val" data-count="{{ setting('counter_projects','100') }}" data-suffix="+">{{ setting('counter_projects','100') }}+</div>
                        <div class="hero-v2__stat-label">Projects Done</div>
                    </div>

                </div>

                {{-- Tech logo strip --}}
                <div class="hero-v2__tech-strip">
                    <span class="hero-v2__tech-label">We Build With</span>
                    <div class="hero-v2__tech-logos">
                        @foreach(['react','laravel','flutter','nodejs','vuejs','python','firebase','docker'] as $tech)
                        <div class="hero-v2__tech-logo" title="{{ ucfirst($tech) }}">
                            <img src="{{ asset('assets/tech/'.$tech.'.svg') }}" alt="{{ ucfirst($tech) }}" loading="lazy">
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ TECH MARQUEE --}}
<div class="marquee-wrapper">
    <div class="marquee-track">
        @php
        $techs = [
            ['Laravel','ri-code-box-line'],['React','ri-reactjs-line'],['Flutter','ri-flutter-fill'],
            ['Node.js','ri-nodejs-line'],['Vue.js','ri-vuejs-line'],['Next.js','ri-code-s-slash-line'],
            ['Python','ri-terminal-box-line'],['MySQL','ri-database-2-line'],['MongoDB','ri-server-line'],
            ['AWS','ri-cloud-line'],['Figma','ri-pen-nib-line'],['TailwindCSS','ri-palette-line'],
            ['TypeScript','ri-braces-line'],['Docker','ri-ship-2-line'],['Firebase','ri-fire-line'],
            ['Google Ads','ri-google-line'],['Meta Ads','ri-facebook-circle-line'],['OpenAI','ri-robot-line'],
        ];
        $all = array_merge($techs, $techs);
        @endphp
        @foreach($all as [$name, $icon])
            <div class="marquee-item"><i class="{{ $icon }}"></i> {{ $name }}</div>
            <div class="marquee-dot"></div>
        @endforeach
    </div>
</div>

{{-- ══════════════════════════════════════════════ WHY CHOOSE US --}}
<section class="section">
    <div class="container">
        <div class="sh" data-gsap-fade>
            <span class="sh__eye">Our Advantages</span>
            <h2 class="sh__title">Why Choose Redis Solution</h2>
            <p class="sh__sub">We bring the perfect blend of innovation, strategy, and execution to every project we take on.</p>
        </div>

        <div class="why-grid" data-gsap-stagger>
            @foreach([
                ['ri-timer-flash-line',   '#FF6400', 'Save Your Time',           'Efficient solutions designed to save your time and streamline your business processes for maximum productivity.'],
                ['ri-price-tag-3-line',   '#6366F1', 'Affordable Price For You', 'Quality digital solutions at competitive prices, carefully tailored to suit your budget without compromising results.'],
                ['ri-bar-chart-box-line', '#10B981', 'Best Strategy',            'Proven data-driven strategies to drive sustainable success and achieve your business goals effectively and efficiently.'],
                ['ri-shake-hands-line',   '#F59E0B', 'Trusted Partnership',      'We build long-term relationships based on transparency, clear communication, and consistent on-time delivery.'],
            ] as [$icon, $color, $title, $desc])
            <div class="why-card">
                <div class="why-card__icon" style="background:{{ $color }}1A;border:1px solid {{ $color }}33;color:{{ $color }}">
                    <i class="{{ $icon }}"></i>
                </div>
                <h3 class="why-card__title">{{ $title }}</h3>
                <p class="why-card__desc">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ SERVICES (What We Offer) --}}
<section class="section section-alt" id="services">
    <div class="container">
        <div class="sh" data-gsap-fade>
            <span class="sh__eye">Our Services</span>
            <h2 class="sh__title">What We Offer</h2>
            <p class="sh__sub">Comprehensive digital solutions covering every aspect of your technology and marketing needs.</p>
        </div>

        <div class="service-grid" data-gsap-stagger>
            @foreach([
                ['ri-sparkling-2-line', '#EC4899', 'AI-Based Applications',    'Build AI-powered chatbots, automation pipelines and LLM integrations that give your business a real competitive edge.',   'ai-applications'],
                ['ri-window-line',      '#FF6400', 'Website Development',      'Build any website with the expertise of Redis Solution for a faster tomorrow. From landing pages to full SaaS platforms.',    'web-development'],
                ['ri-smartphone-line',  '#6366F1', 'Mobile App Development',   'Build any mobile app with expertise in Flutter, React Native, iOS & Android. Native performance, beautiful UI.',            'mobile-apps'],
                ['ri-bar-chart-line',   '#10B981', 'Digital Marketing',        'Drive growth with SEO, Google Ads, Meta campaigns and social media strategies that deliver measurable, trackable ROI.',       'digital-marketing'],
                ['ri-code-s-slash-line','#0EA5E9', 'Software Development',     'Tailored software solutions designed to meet your unique business needs and drive operational efficiency at scale.',           'software-development'],
                ['ri-layout-grid-line', '#F59E0B', 'ERP & CMS Development',    'Streamline your operations and manage content effortlessly with custom ERP and CMS solutions built for your workflow.',      'erp-cms'],
            ] as [$icon, $color, $title, $desc, $anchor])
            <div class="service-card" data-tilt>
                <div class="service-card__icon" style="background:{{ $color }}15;border:1px solid {{ $color }}30;color:{{ $color }}">
                    <i class="{{ $icon }}"></i>
                </div>
                <div>
                    <h3 class="service-card__title">{{ $title }}</h3>
                    <p class="service-card__desc">{{ $desc }}</p>
                </div>
                <a href="{{ route('services') }}#{{ $anchor }}" class="service-card__arrow">
                    Read More
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:3rem" data-gsap-fade>
            <a href="{{ route('services') }}" class="btn-outline">View All Services <i class="ri-arrow-right-line"></i></a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ GROWTH SERVICES --}}
<section class="section">
    <div class="container">
        <div class="sh" data-gsap-fade>
            <span class="sh__eye">Growth Services</span>
            <h2 class="sh__title">Grow Your Brand Online</h2>
            <p class="sh__sub">Beyond development — we drive traffic, generate leads, and build brand authority that converts visitors into customers.</p>
        </div>

        <div class="mini-services-grid" data-gsap-stagger>
            @foreach([
                ['ri-advertisement-line',   '#EC4899', 'Social Media Ads',   'High-converting ad campaigns on Facebook, Instagram, TikTok and LinkedIn that drive real conversions.'],
                ['ri-mail-send-line',        '#6366F1', 'Email Marketing',    'Automated email sequences that nurture leads, reduce churn and drive repeat purchases on autopilot.'],
                ['ri-file-text-line',        '#10B981', 'Content Writing',    'SEO-optimised blog posts, web copy and marketing content that ranks on Google and converts visitors.'],
                ['ri-lightbulb-flash-line',  '#F59E0B', 'Business Strategy',  'Consulting on digital transformation, product roadmaps and growth strategies tailored to your business.'],
            ] as [$icon, $color, $title, $desc])
            <div class="mini-service-card">
                <div class="mini-service-card__icon" style="color:{{ $color }}"><i class="{{ $icon }}"></i></div>
                <h3 class="mini-service-card__title">{{ $title }}</h3>
                <p class="mini-service-card__desc">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ ABOUT --}}
<section class="section section-alt">
    <div class="container">
        <div class="about-grid" data-gsap-stagger>
            <div class="about-grid__content">
                <span class="sh__eye" style="display:inline-flex;margin-bottom:1.25rem">About Redis Solution</span>
                <h2 class="sh__title" style="text-align:left;margin-bottom:1.5rem">
                    4+ Years of Excellence<br>in Technology Solutions
                </h2>
                <p style="font-size:0.95rem;color:var(--fg-text-muted);line-height:1.8;margin-bottom:2rem">
                    Redis Solution started in 2020 as a small team with one simple belief: Pakistan deserves a software company that doesn't cut corners. Today we're a full-service digital agency trusted by startups, enterprises and international businesses.
                </p>
                <div class="about-pillars">
                    @foreach([
                        ['ri-rocket-2-line',  '#6366F1', 'Innovation First',        'We stay ahead of the technology curve, always delivering cutting-edge solutions built with modern frameworks.'],
                        ['ri-group-line',     '#10B981', 'Client Collaboration',    'Your vision drives our work. Full transparency throughout — weekly updates, no surprises.'],
                        ['ri-award-line',     '#F59E0B', 'Exceeding Expectations',  '98% of our clients renew or refer us. We don\'t just meet deadlines — we deliver quality that surprises.'],
                    ] as [$icon, $color, $title, $desc])
                    <div class="about-pillar">
                        <div class="about-pillar__icon" style="background:{{ $color }}1A;border:1px solid {{ $color }}33;color:{{ $color }}"><i class="{{ $icon }}"></i></div>
                        <div>
                            <h4 class="about-pillar__title">{{ $title }}</h4>
                            <p class="about-pillar__desc">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('about') }}" class="btn-primary" style="display:inline-flex;margin-top:2.5rem">
                    Learn More About Us <i class="ri-arrow-right-line"></i>
                </a>
            </div>
            <div class="about-grid__image">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=680&q=80&auto=format&fit=crop" alt="Redis Solution Team" class="about-img" loading="lazy">
                <div class="about-img-badge">
                    <i class="ri-verified-badge-fill" style="color:#FF6400;font-size:1.75rem"></i>
                    <div>
                        <div style="font-weight:700;font-size:0.88rem;color:var(--fg-heading)">ISO-Standard Code</div>
                        <div style="font-size:0.75rem;color:var(--fg-text-muted)">Every project, no exceptions</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ ACHIEVEMENT COUNTERS --}}
<section class="achievement-strip">
    <div class="container">
        <div class="achievement-grid" data-gsap-stagger>
            @foreach([
                [setting('counter_clients','100'),     '+', 'Satisfied Clients',  'ri-emotion-happy-line'],
                [setting('counter_projects','100'),    '+', 'Projects Delivered',  'ri-checkbox-circle-line'],
                [setting('counter_satisfaction','98'), '%', 'Client Retention',    'ri-heart-line'],
                ['15',                                 '+', 'Team Members',        'ri-team-line'],
            ] as [$num, $suf, $label, $icon])
            <div class="achievement-item">
                <div class="achievement-item__icon"><i class="{{ $icon }}"></i></div>
                <div class="achievement-item__val" data-count="{{ $num }}" data-suffix="{{ $suf }}">{{ $num }}{{ $suf }}</div>
                <div class="achievement-item__label">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ PORTFOLIO --}}
<section class="section">
    <div class="container">
        <div class="sh" data-gsap-fade>
            <span class="sh__eye">Featured Projects</span>
            <h2 class="sh__title">Our Work Speaks<br>For Itself</h2>
            <p class="sh__sub">Real projects, real results — a selection of work we're most proud of.</p>
        </div>

        {{-- Top row: featured card + stats card --}}
        <div class="work-bento-top" data-gsap-stagger>

            <div class="work-bento__featured">
                <div class="work-bento__featured-img">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=900&q=80&auto=format&fit=crop" alt="PakBazar E-Commerce" loading="lazy">
                </div>
                <div class="work-bento__featured-body">
                    <span class="work-bento__cat" style="background:rgba(255,100,0,0.1);color:#FF6400;border:1px solid rgba(255,100,0,0.22)">
                        <i class="ri-window-line"></i> Web Development
                    </span>
                    <h3 class="work-bento__title">PakBazar E-Commerce Platform</h3>
                    <p class="work-bento__desc">Multi-vendor marketplace with 10K+ SKUs, seller onboarding, real-time inventory and Stripe payment integration.</p>
                    <div class="work-bento__tags">
                        @foreach(['Laravel', 'Vue.js', 'MySQL', 'Stripe', 'Redis'] as $t)
                        <span class="work-bento__tag">{{ $t }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="work-bento__stats-card">
                <div class="work-bento__stats-eyebrow">
                    <i class="ri-trophy-line"></i> Our Track Record
                </div>
                <div class="work-bento__stats-inner">
                    @foreach([
                        [setting('counter_projects','100'), '+', 'Projects Delivered', '#FF6400'],
                        ['15',                              '+', 'Industries Served',  '#6366F1'],
                        [setting('counter_satisfaction','98'), '%', 'Client Satisfaction', '#10B981'],
                    ] as [$num, $suf, $label, $color])
                    <div class="work-bento__stat">
                        <div class="work-bento__stat-num" style="color:{{ $color }}">{{ $num }}<span>{{ $suf }}</span></div>
                        <div class="work-bento__stat-label">{{ $label }}</div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('portfolio') }}" class="work-bento__view-btn">
                    View All Projects <i class="ri-arrow-right-line"></i>
                </a>
            </div>

        </div>

        {{-- Bottom row: 3 smaller cards --}}
        <div class="work-bento-bottom" data-gsap-stagger>
            @foreach([
                ['https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=700&q=80&auto=format&fit=crop', 'Mobile App',        '#6366F1', 'RideFlow Ride-Hailing',    ['Flutter','Firebase','Google Maps']],
                ['https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=700&q=80&auto=format&fit=crop', 'ERP Solution',       '#10B981', 'TechManage Factory ERP',   ['Laravel','MySQL','Redis']],
                ['https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=700&q=80&auto=format&fit=crop','Digital Marketing','#F59E0B', 'SEO — 280% ROAS Growth',  ['Google Ads','SEO','Analytics']],
            ] as [$img, $cat, $color, $title, $tags])
            <div class="work-bento__card">
                <div class="work-bento__card-img">
                    <img src="{{ $img }}" alt="{{ $title }}" class="img-cover" loading="lazy">
                    <div class="work-bento__card-overlay">
                        <span class="work-bento__cat" style="background:rgba(0,0,0,0.55);color:#fff;border:1px solid rgba(255,255,255,0.25);backdrop-filter:blur(4px)"><span style="color:{{ $color }}">●</span> {{ $cat }}</span>
                        <h4 class="work-bento__card-title">{{ $title }}</h4>
                        <div class="work-bento__tags" style="margin-top:0.5rem">
                            @foreach($tags as $t)
                            <span class="work-bento__tag work-bento__tag--dark">{{ $t }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ TESTIMONIALS --}}
<section class="section section-alt">
    <div class="container">
        <div class="sh" data-gsap-fade>
            <span class="sh__eye">Client Love</span>
            <h2 class="sh__title">What Clients Say About<br>Redis Solution</h2>
            <p class="sh__sub">Real results from real businesses who trusted us with their digital transformation.</p>
        </div>

        <div class="testimonial-carousel" style="margin-top:0">
            <div class="testimonial-carousel__track">
                @php
                $reviews = [
                    ['"Redis Solution transformed our outdated inventory system into a full ERP platform in under 3 months. Results were impressive — 40% faster order processing."', 'Ahmed Khan', 'CEO, TechManage Pvt. Ltd.', 'AK', '#FF6400'],
                    ['"They delivered our Flutter mobile app on time and within budget. Runs flawlessly on both iOS and Android. Communication was exceptional throughout."', 'Mark Jensen', 'CEO, Agnatech', 'MJ', '#6366F1'],
                    ['"SEO rankings went from page 5 to #1 in 4 months. ROAS on Google Ads improved by 280%. Redis Solution delivers exactly what they promise."', 'Omar Raza', 'Marketing Director, PakBazar', 'OR', '#10B981'],
                    ['"Working with Redis Solution was a game changer. They understood our business needs instantly and delivered a website that significantly boosted enquiries."', 'Sarah Mitchell', 'Founder, BrightEdge Solutions', 'SM', '#EC4899'],
                    ['"The AI chatbot they built handles 70% of customer queries automatically. Incredible ROI from day one."', 'Zubair Malik', 'CTO, Finova Tech', 'ZM', '#F59E0B'],
                ];
                $double = array_merge($reviews, $reviews);
                @endphp
                @foreach($double as [$text, $name, $role, $initials, $color])
                <div class="testimonial-card">
                    <div class="testimonial-card__stars">@for($i=0;$i<5;$i++)<i class="ri-star-fill"></i>@endfor</div>
                    <p class="testimonial-card__text">{{ $text }}</p>
                    <div class="testimonial-card__author">
                        <div class="testimonial-card__avatar" style="background:{{ $color }}20;color:{{ $color }};border-color:{{ $color }}40">{{ $initials }}</div>
                        <div>
                            <div class="testimonial-card__name">{{ $name }}</div>
                            <div class="testimonial-card__role">{{ $role }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ BLOG --}}
@php try { $posts = \App\Models\Blog::where('published',true)->orderBy('published_at','desc')->take(3)->get(); } catch(\Throwable $e) { $posts = collect(); } @endphp
@if($posts->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="sh" data-gsap-fade>
            <span class="sh__eye">Latest Insights</span>
            <h2 class="sh__title">From Our Blog</h2>
        </div>
        <div class="blog-grid" data-gsap-stagger>
            @foreach($posts as $post)
            <article class="blog-card">
                @if($post->thumbnail)
                <div class="blog-card__thumb"><img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}" class="img-cover" loading="lazy"></div>
                @else
                <div class="blog-card__thumb blog-card__thumb--placeholder"><i class="ri-article-line"></i></div>
                @endif
                <div class="blog-card__body">
                    <h3 class="blog-card__title"><a href="{{ route('blog.show',$post->slug) }}">{{ $post->title }}</a></h3>
                    <p class="blog-card__excerpt">{{ Str::limit(strip_tags($post->content ?? ''), 120) }}</p>
                    <a href="{{ route('blog.show',$post->slug) }}" class="blog-card__link">Read More <i class="ri-arrow-right-line"></i></a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════ FREE AUDIT CTA --}}
<div class="audit-cta">
    <div class="container" data-gsap-fade>
        <div class="audit-cta__label"><i class="ri-search-eye-line"></i> Free Offer — No Strings Attached</div>
        <h2 class="audit-cta__title">Get Your Free Website SEO Audit</h2>
        <p class="audit-cta__sub">We'll analyze your site's SEO health, Core Web Vitals, performance score and competitor gaps — completely free.</p>
        <div style="display:flex;align-items:center;justify-content:center;gap:1rem;flex-wrap:wrap">
            <a href="{{ route('free-audit') }}" class="btn-primary btn-primary--lg"><i class="ri-search-eye-line"></i> Run Free Audit</a>
            <a href="{{ route('free-consultation') }}" class="btn-outline"><i class="ri-calendar-line"></i> Book Consultation</a>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════ FINAL CTA --}}
<x-frontend.cta-banner />

</x-layouts.frontend>
