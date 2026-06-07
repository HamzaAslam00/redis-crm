<x-layouts.frontend title="About Us — Redis Solution">

    {{-- ═══════════════════════════════════════════════
         PHOTO HERO (half-screen with dark overlay)
    ═══════════════════════════════════════════════ --}}
    <section class="photo-hero">
        <img
            src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1600&q=80&auto=format&fit=crop"
            alt="Redis Solution team"
            class="photo-hero__img"
        >
        <div class="photo-hero__overlay"></div>
        <div class="container photo-hero__content">
            <p class="photo-hero__eye">Our Story</p>
            <h1 class="photo-hero__title">We Are <span>Redis Solution</span></h1>
            <p class="photo-hero__sub">A Team Obsessed with Craft and Results</p>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         MISSION / VISION
    ═══════════════════════════════════════════════ --}}
    <section class="section">
        <div class="container">
            <div class="sh" data-gsap-fade>
                <p class="sh__eye">What Drives Us</p>
                <h2 class="sh__title">Purpose &amp; Direction</h2>
                <p class="sh__sub">Two ideas that shape every decision we make.</p>
            </div>

            <div class="rg-2" style="margin-top:3rem" data-gsap-stagger>
                <div class="bento-card" style="padding:2.5rem">
                    <div style="display:inline-flex;width:52px;height:52px;border-radius:12px;background:rgba(255,100,0,0.12);border:1px solid rgba(255,100,0,0.25);align-items:center;justify-content:center;margin-bottom:1.5rem">
                        <i class="ri-rocket-2-line" style="color:#FF6400;font-size:1.5rem"></i>
                    </div>
                    <h3 style="font-family:'Syne',sans-serif;font-size:1.35rem;font-weight:700;color:var(--fg-heading);margin-bottom:0.75rem">Our Mission</h3>
                    <p style="color:var(--fg-text-muted);line-height:1.8">To empower businesses of every size with world-class digital products — built with honesty, precision and genuine care for the people who use them. We exist to close the gap between great ideas and great software.</p>
                </div>

                <div class="bento-card" style="padding:2.5rem">
                    <div style="display:inline-flex;width:52px;height:52px;border-radius:12px;background:rgba(99,102,241,0.12);border:1px solid rgba(99,102,241,0.25);align-items:center;justify-content:center;margin-bottom:1.5rem">
                        <i class="ri-eye-line" style="color:#6366F1;font-size:1.5rem"></i>
                    </div>
                    <h3 style="font-family:'Syne',sans-serif;font-size:1.35rem;font-weight:700;color:var(--fg-heading);margin-bottom:0.75rem">Our Vision</h3>
                    <p style="color:var(--fg-text-muted);line-height:1.8">To become the go-to digital partner for ambitious companies across South Asia and beyond — known not just for technical excellence, but for the trust, clarity and long-term thinking we bring to every engagement.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         STORY & TIMELINE
    ═══════════════════════════════════════════════ --}}
    <section class="section" style="background:var(--fg-surface)">
        <div class="container">
            <div class="rg-2-gap5">

                <div data-gsap-fade>
                    <p style="font-size:0.75rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#FF6400;margin-bottom:0.75rem">How We Started</p>
                    <h2 style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:700;color:var(--fg-heading);margin-bottom:1.25rem;line-height:1.2">Born in Rawalpindi,<br>built for the world.</h2>
                    <p style="color:var(--fg-text-muted);line-height:1.85;margin-bottom:1.25rem">Redis Solution started in 2020 as a small team with one simple belief: Pakistan deserves a software company that doesn't cut corners. We began with a handful of local clients and a shared determination to ship quality work, every single time.</p>
                    <p style="color:var(--fg-text-muted);line-height:1.85;margin-bottom:1.25rem">Over four years we've grown into a full-service digital agency with clients across Pakistan, the UAE, the UK and the US. The team is bigger, the projects are more complex — but the obsession with craft hasn't changed one bit.</p>
                    <p style="color:var(--fg-text-muted);line-height:1.85">Today we're proud to be one of the fastest-growing IT companies in Rawalpindi, trusted by startups, established enterprises and international businesses who care about getting things right.</p>
                </div>

                <div data-gsap-stagger>
                    @php
                        $milestones = [
                            ['year' => '2020', 'title' => 'Founded', 'desc' => 'Redis Solution incorporated in Rawalpindi with a team of 3, focused on Laravel web development.'],
                            ['year' => '2021', 'title' => 'First International Client', 'desc' => 'Landed our first UK-based client and expanded into mobile app development with Flutter.'],
                            ['year' => '2022', 'title' => 'Digital Marketing Launch', 'desc' => 'Added a dedicated digital marketing division — SEO, Google Ads and Meta Ads now in-house.'],
                            ['year' => 'Now',  'title' => 'Full-Stack Agency', 'desc' => '100+ completed projects, 10+ team members, clients across 5 countries and an AI services division.'],
                        ];
                    @endphp
                    <div style="position:relative;padding-left:2rem">
                        <div style="position:absolute;left:0;top:0;bottom:0;width:2px;background:linear-gradient(to bottom,#FF6400,rgba(255,100,0,0.1))"></div>
                        @foreach($milestones as $index => $m)
                        <div style="position:relative;padding-bottom:{{ $index < count($milestones)-1 ? '2.5rem' : '0' }}">
                            <div style="position:absolute;left:-2.55rem;top:0.2rem;width:14px;height:14px;border-radius:50%;background:#FF6400;border:3px solid var(--fg-surface)"></div>
                            <span style="display:inline-block;padding:0.2rem 0.65rem;border-radius:99px;background:rgba(255,100,0,0.12);border:1px solid rgba(255,100,0,0.25);color:#FF6400;font-size:0.75rem;font-weight:700;margin-bottom:0.5rem">{{ $m['year'] }}</span>
                            <h4 style="font-family:'Syne',sans-serif;font-weight:700;color:var(--fg-heading);margin-bottom:0.35rem">{{ $m['title'] }}</h4>
                            <p style="color:var(--fg-text-muted);line-height:1.7;font-size:0.95rem">{{ $m['desc'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         VALUES
    ═══════════════════════════════════════════════ --}}
    <section class="section">
        <div class="container">
            <div class="sh" data-gsap-fade>
                <p class="sh__eye">What We Stand For</p>
                <h2 class="sh__title">Our Core Values</h2>
                <p class="sh__sub">Six principles that guide how we work, hire and deliver.</p>
            </div>

            <div class="value-grid" style="margin-top:3rem" data-gsap-stagger>
                @php
                    $values = [
                        ['ri-lightbulb-flash-line', '#F59E0B', 'Innovation',    'We stay curious, experiment constantly and bring the best new tools to every client engagement.'],
                        ['ri-eye-line',              '#6366F1', 'Transparency',  'Honest communication, clear pricing and no surprises. We tell you what we can deliver — and deliver it.'],
                        ['ri-rocket-2-line',         '#0EA5E9', 'Speed',         'Fast iteration cycles, agile sprints and a bias for shipping. We move quickly without sacrificing quality.'],
                        ['ri-checkbox-circle-line',  '#10B981', 'Quality',       'Peer-reviewed code, automated tests, QA checklists. We hold ourselves to a standard we\'d be proud of.'],
                        ['ri-group-line',            '#FF6400', 'Partnership',   'We invest in understanding your business goals, not just technical requirements. Your success is ours.'],
                        ['ri-award-line',            '#EC4899', 'Integrity',     'We do what we say, say what we mean and own our mistakes. Relationships built on trust last a lifetime.'],
                    ];
                @endphp
                @foreach($values as $v)
                <div class="value-card">
                    <div style="display:inline-flex;width:48px;height:48px;border-radius:10px;background:{{ $v[1] }}1A;border:1px solid {{ $v[1] }}33;align-items:center;justify-content:center;margin-bottom:1rem">
                        <i class="{{ $v[0] }}" style="color:{{ $v[1] }};font-size:1.3rem"></i>
                    </div>
                    <h3 style="font-family:'Syne',sans-serif;font-weight:700;color:var(--fg-heading);margin-bottom:0.5rem">{{ $v[2] }}</h3>
                    <p style="color:var(--fg-text-muted);font-size:0.92rem;line-height:1.7">{{ $v[3] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         TEAM
    ═══════════════════════════════════════════════ --}}
    <section class="section" style="background:var(--fg-surface)">
        <div class="container">
            <div class="sh" data-gsap-fade>
                <p class="sh__eye">The People Behind It</p>
                <h2 class="sh__title">Meet the Team</h2>
                <p class="sh__sub">A small, focused group of people who genuinely love what they build.</p>
            </div>

            <div class="team-grid" style="margin-top:3rem" data-gsap-stagger>
                @php
                    $team = [
                        ['AK', 'Ahmed Khan',        'CEO & Founder',   '#FF6400'],
                        ['SR', 'Sara Rashid',        'CTO',             '#6366F1'],
                        ['MH', 'Muhammad Hassan',    'Lead Developer',  '#0EA5E9'],
                        ['FA', 'Fatima Aslam',       'Marketing Head',  '#10B981'],
                    ];
                @endphp
                @foreach($team as [$initials, $name, $role, $color])
                <div class="team-card">
                    <div class="team-card__avatar" style="background:{{ $color }}1A;border:2px solid {{ $color }}33">
                        <span style="font-family:'Clash Display',sans-serif;font-size:1.4rem;font-weight:700;color:{{ $color }}">{{ $initials }}</span>
                    </div>
                    <p class="team-card__name">{{ $name }}</p>
                    <p class="team-card__role">{{ $role }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         STATS
    ═══════════════════════════════════════════════ --}}
    <section class="section">
        <div class="container">
            <div class="sh" data-gsap-fade>
                <p class="sh__eye">By the Numbers</p>
                <h2 class="sh__title">Results That Speak</h2>
            </div>

            <div class="rg-4" style="margin-top:3rem" data-gsap-stagger>
                @php
                    $stats = [
                        ['100', '+', 'Projects Delivered', 'ri-checkbox-circle-line', '#FF6400'],
                        ['4',   '+', 'Years in Business',  'ri-calendar-check-line',  '#6366F1'],
                        ['100', '+', 'Happy Clients',      'ri-emotion-happy-line',   '#10B981'],
                        ['98',  '%', 'Client Satisfaction','ri-star-line',             '#F59E0B'],
                    ];
                @endphp
                @foreach($stats as [$num, $suf, $label, $icon, $color])
                <div class="bento-card" style="padding:2rem;text-align:center">
                    <div style="display:inline-flex;width:48px;height:48px;border-radius:10px;background:{{ $color }}15;border:1px solid {{ $color }}30;align-items:center;justify-content:center;margin-bottom:1rem">
                        <i class="{{ $icon }}" style="color:{{ $color }};font-size:1.3rem"></i>
                    </div>
                    <div style="font-family:'Clash Display',sans-serif;font-size:2.5rem;font-weight:800;color:{{ $color }};line-height:1">
                        <span data-count="{{ $num }}" data-suffix="{{ $suf }}">0{{ $suf }}</span>
                    </div>
                    <p style="color:var(--fg-text-muted);font-size:0.9rem;margin-top:0.5rem">{{ $label }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         CTA
    ═══════════════════════════════════════════════ --}}
    <x-frontend.cta-banner />

</x-layouts.frontend>
