<x-layouts.frontend title="Free SEO Audit — Redis Solution">

<section class="photo-hero">
    <img src="https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=1600&q=80&auto=format&fit=crop" alt="SEO Audit" class="photo-hero__img">
    <div class="photo-hero__overlay"></div>
    <div class="container photo-hero__content" style="text-align:center">
        <p class="photo-hero__eye"><i class="ri-search-eye-line"></i> Instant · Free · No Sign-Up</p>
        <h1 class="photo-hero__title" style="text-align:center">Free SEO &amp; Performance<br><span>Audit Tool</span></h1>
        <p class="photo-hero__sub" style="margin:0 auto">Enter any URL and get a full Lighthouse report — scores, Core Web Vitals, on-page SEO, and actionable fixes.</p>
    </div>
</section>

<div x-data="auditApp()" class="audit-wrap">

    {{-- ── URL Input Bar ── --}}
    <div class="audit-input-bar">
        <div class="container">
            <form @submit.prevent="runAudit()" class="audit-form">
                <div class="audit-form__field">
                    <i class="ri-global-line audit-form__icon"></i>
                    <input x-model="url" type="text" placeholder="https://yourwebsite.com"
                        class="audit-form__input" :disabled="state==='loading'"
                        autocomplete="url" spellcheck="false">
                </div>
                <button type="submit" class="btn-primary audit-form__btn" :disabled="state==='loading'||!url.trim()">
                    <template x-if="state!=='loading'"><span style="display:inline-flex;align-items:center;gap:.5rem"><i class="ri-search-eye-line"></i> Analyze Site</span></template>
                    <template x-if="state==='loading'"><span style="display:inline-flex;align-items:center;gap:.5rem"><i class="ri-loader-4-line" style="animation:spin 1s linear infinite"></i> Analyzing…</span></template>
                </button>
            </form>
            <p x-show="state==='idle'" class="audit-form__hint">Try: redissolution.com &middot; google.com &middot; any competitor URL</p>
        </div>
    </div>

    {{-- ── Loading ── --}}
    <div x-show="state==='loading'" x-transition class="section">
        <div class="container" style="max-width:640px;text-align:center">
            <div style="padding:3rem 0">
                <div style="display:flex;justify-content:center;margin-bottom:1.5rem">
                    <svg viewBox="0 0 120 120" width="120" height="120">
                        <circle cx="60" cy="60" r="50" fill="none" stroke="rgba(255,100,0,0.1)" stroke-width="8"/>
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#FF6400" stroke-width="8" stroke-linecap="round" stroke-dasharray="314" transform="rotate(-90 60 60)"
                            :stroke-dashoffset="314-(314*progress/100)" style="transition:stroke-dashoffset 0.8s ease"/>
                        <text x="60" y="65" text-anchor="middle" fill="#FF6400" font-size="22" font-weight="700" font-family="'Clash Display',sans-serif" x-text="Math.round(progress)+'%'"></text>
                    </svg>
                </div>
                <h2 style="font-family:'Syne',sans-serif;font-size:1.3rem;font-weight:700;color:var(--fg-heading)" x-text="progressMsg"></h2>
                <p style="color:var(--fg-text-muted);font-size:.9rem;margin-top:.5rem" x-text="'Auditing: '+url"></p>
                <div class="audit-loading-steps">
                    <template x-for="(step,i) in loadingSteps" :key="i">
                        <div class="audit-step" :class="{'audit-step--done':stepsDone>i,'audit-step--active':stepsDone===i}">
                            <i :class="stepsDone>i?'ri-checkbox-circle-fill':(stepsDone===i?'ri-loader-4-line':'ri-circle-line')" :style="stepsDone===i?'animation:spin 1s linear infinite':''"></i>
                            <span x-text="step"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Error ── --}}
    <div x-show="state==='error'" x-transition class="section">
        <div class="container" style="max-width:560px;text-align:center">
            <div style="display:inline-flex;width:72px;height:72px;border-radius:18px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);align-items:center;justify-content:center;margin-bottom:1.5rem">
                <i class="ri-error-warning-line" style="color:#EF4444;font-size:2rem"></i>
            </div>
            <h2 style="font-family:'Syne',sans-serif;font-weight:700;color:var(--fg-heading);margin-bottom:.75rem">Analysis Failed</h2>
            <p style="color:var(--fg-text-muted);line-height:1.75;margin-bottom:2rem" x-text="errorMsg"></p>
            <button @click="state='idle';errorMsg=''" class="btn-primary">Try Again</button>
        </div>
    </div>

    {{-- ══════════════ RESULTS ══════════════ --}}
    <div x-show="state==='results'" x-transition.opacity.duration.500ms>

        {{-- ① SCORE HEADER --}}
        <div class="ar-header">
            <div class="container">

                {{-- Top row: speedometer + site info + re-analyze --}}
                <div class="ar-header-top">

                    {{-- Speedometer --}}
                    <div class="ar-speedo-wrap">
                        <svg viewBox="0 0 220 130" class="ar-speedo-svg">
                            <path d="M 15 118 A 95 95 0 0 1 205 118" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="16" stroke-linecap="round"/>
                            <path d="M 15 118 A 95 95 0 0 1 205 118" fill="none"
                                :stroke="gradeColor(avgScore())" stroke-width="16" stroke-linecap="round"
                                :stroke-dasharray="299" :stroke-dashoffset="299*(1-avgScore()/100)"
                                style="transition:stroke-dashoffset 1.8s ease .3s"/>
                            <text x="110" y="105" text-anchor="middle" fill="white" font-size="40" font-weight="800" font-family="'Clash Display',sans-serif" x-text="avgScore()"></text>
                            <text x="110" y="122" text-anchor="middle" fill="rgba(255,255,255,.35)" font-size="8.5" letter-spacing="2" font-weight="700">OVERALL SCORE</text>
                        </svg>
                        <div class="ar-speedo-grade" :style="`color:${gradeColor(avgScore())}`" x-text="grade(avgScore())"></div>
                    </div>

                    {{-- Site info + badges + re-analyze --}}
                    <div class="ar-header-info">
                        <div class="ar-site-url"><i class="ri-global-line" style="color:#FF6400;flex-shrink:0"></i><span x-text="result?.url"></span></div>
                        <p class="ar-site-time">Analyzed <span x-text="formatDate(result?.analyzed_at)"></span></p>
                        <div class="ar-header-actions">
                            <div class="ar-badges">
                                <span class="ar-badge ar-badge--fail"><i class="ri-close-circle-fill"></i><span x-text="issueCount('fail')"></span> Critical</span>
                                <span class="ar-badge ar-badge--warn"><i class="ri-error-warning-fill"></i><span x-text="issueCount('warn')"></span> Warnings</span>
                                <span class="ar-badge ar-badge--pass"><i class="ri-checkbox-circle-fill"></i><span x-text="issueCount('pass')"></span> Passed</span>
                            </div>
                            <button @click="reAnalyze()" class="ar-reanalyze-btn"><i class="ri-refresh-line"></i> Re-analyze</button>
                        </div>
                        {{-- Page info from PSI --}}
                        <div class="ar-page-stats" x-show="result?.page_info?.size_kb||result?.page_info?.requests||result?.page_info?.load_time">
                            <template x-if="result?.page_info?.size_kb">
                                <span class="ar-page-stat"><i class="ri-file-zip-line"></i><span x-text="result.page_info.size_kb+'KB'"></span></span>
                            </template>
                            <template x-if="result?.page_info?.requests">
                                <span class="ar-page-stat"><i class="ri-arrow-left-right-line"></i><span x-text="result.page_info.requests+' requests'"></span></span>
                            </template>
                            <template x-if="result?.page_info?.load_time">
                                <span class="ar-page-stat"><i class="ri-timer-line"></i><span x-text="result.page_info.load_time+' interactive'"></span></span>
                            </template>
                        </div>
                    </div>

                </div>

                {{-- Category score cards --}}
                <div class="ar-cat-cards">
                    <template x-for="cat in categoryCards()" :key="cat.key">
                        <div class="ar-cat-card">
                            <div class="ar-cat-card__ring-wrap">
                                <svg viewBox="0 0 72 72" width="72" height="72">
                                    <circle cx="36" cy="36" r="29" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="6"/>
                                    <circle cx="36" cy="36" r="29" fill="none"
                                        :stroke="scoreColor(cat.value)" stroke-width="6" stroke-linecap="round"
                                        :stroke-dasharray="182.2" :stroke-dashoffset="182.2*(1-cat.value/100)"
                                        transform="rotate(-90 36 36)" style="transition:stroke-dashoffset 1.4s ease .5s"/>
                                </svg>
                                <div class="ar-cat-card__num" :style="`color:${scoreColor(cat.value)}`" x-text="cat.value"></div>
                            </div>
                            <div class="ar-cat-card__label" x-text="cat.label"></div>
                            <div class="ar-cat-card__grade" :style="`color:${gradeColor(cat.value)}`" x-text="grade(cat.value)"></div>
                        </div>
                    </template>
                    {{-- Mobile vs Desktop card --}}
                    <div class="ar-cat-card ar-cat-card--compare" x-show="!psiUnavailable()">
                        <p class="ar-compare-title">Mobile vs Desktop</p>
                        <div style="display:flex;flex-direction:column;gap:.45rem">
                            <template x-for="row in comparisonItems()" :key="row.key">
                                <div class="ar-compare-row">
                                    <span class="ar-compare-cat" x-text="row.label.substring(0,5)"></span>
                                    <div class="ar-compare-bars">
                                        <div class="ar-cbar-wrap">
                                            <i class="ri-smartphone-line" style="font-size:.6rem;opacity:.5"></i>
                                            <div class="ar-cbar-track"><div class="ar-cbar-fill" :style="`width:${row.mobile}%;background:${scoreColor(row.mobile)}`"></div></div>
                                            <span :style="`color:${scoreColor(row.mobile)};font-size:.65rem;font-weight:700;min-width:22px`" x-text="row.mobile"></span>
                                        </div>
                                        <div class="ar-cbar-wrap">
                                            <i class="ri-computer-line" style="font-size:.6rem;opacity:.5"></i>
                                            <div class="ar-cbar-track"><div class="ar-cbar-fill" :style="`width:${row.desktop}%;background:${scoreColor(row.desktop)}`"></div></div>
                                            <span :style="`color:${scoreColor(row.desktop)};font-size:.65rem;font-weight:700;min-width:22px`" x-text="row.desktop"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- PSI notice --}}
        <template x-if="psiUnavailable()">
            <div class="container" style="padding-top:1.25rem;padding-bottom:0">
                <div class="ar-notice">
                    <i class="ri-information-line"></i>
                    <span><strong>Performance scores unavailable</strong> — Google PageSpeed API daily quota reached. On-page SEO radar &amp; all checks below are complete &amp; accurate. To enable full Lighthouse scores: get a free API key from <strong style="color:#F59E0B">Google Cloud Console</strong> → enable PageSpeed Insights API → add <code style="background:rgba(255,255,255,.06);padding:.1rem .4rem;border-radius:4px;font-size:.74rem;color:#F59E0B">GOOGLE_PAGESPEED_KEY=your_key</code> to your <code style="background:rgba(255,255,255,.06);padding:.1rem .4rem;border-radius:4px;font-size:.74rem;color:#F59E0B">.env</code> file (25,000 calls/day free).</span>
                </div>
            </div>
        </template>

        {{-- ② TAB NAV --}}
        <div class="ar-tabs-wrap">
            <div class="container">
                <div class="ar-tabs">
                    <button class="ar-tab" :class="{'ar-tab--active':tab==='overview'}" @click="tab='overview'">
                        <i class="ri-dashboard-line"></i> Overview
                    </button>
                    <button class="ar-tab" :class="{'ar-tab--active':tab==='seo'}" @click="tab='seo'">
                        <i class="ri-search-2-line"></i> SEO Checks
                        <span class="ar-tab-badge ar-tab-badge--fail" x-show="seoIssues()>0" x-text="seoIssues()"></span>
                    </button>
                    <button class="ar-tab" :class="{'ar-tab--active':tab==='technical'}" @click="tab='technical'">
                        <i class="ri-settings-3-line"></i> Technical
                        <span class="ar-tab-badge ar-tab-badge--fail" x-show="techIssues()>0" x-text="techIssues()"></span>
                    </button>
                    <button class="ar-tab" :class="{'ar-tab--active':tab==='performance'}" @click="tab='performance'">
                        <i class="ri-speed-line"></i> Performance
                    </button>
                </div>
            </div>
        </div>

        {{-- ③ OVERVIEW TAB --}}
        <div x-show="tab==='overview'" class="section">
            <div class="container">

                {{-- ── SEO Health Radar ── --}}
                <div class="ar-radar-section">
                    <div class="ar-radar-header">
                        <div>
                            <p class="sh__eye" style="text-align:left;margin-bottom:.25rem"><i class="ri-radar-line"></i> On-Page Analysis</p>
                            <h2 class="sh__title" style="font-size:clamp(1.2rem,3vw,1.7rem);text-align:left;margin-bottom:0">SEO Health Radar</h2>
                        </div>
                        <div class="ar-radar-badge">
                            <span class="ar-radar-badge-num" :style="`color:${gradeColor(onPageScore())}`" x-text="onPageScore()"></span>
                            <span class="ar-radar-badge-lbl">On-Page Score / 100</span>
                        </div>
                    </div>
                    <div class="ar-radar-body">
                        {{-- SVG Spider Chart --}}
                        <div class="ar-radar-chart-wrap">
                            <svg viewBox="0 0 220 222" class="ar-radar-svg">
                                {{-- Static hex grid rings --}}
                                <polygon points="110,92 125.6,101 125.6,119 110,128 94.4,119 94.4,101" fill="none" stroke="rgba(255,255,255,0.04)" stroke-width="0.8"/>
                                <polygon points="110,74 141.2,92 141.2,128 110,146 78.8,128 78.8,92" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.8"/>
                                <polygon points="110,56 156.8,83 156.8,137 110,164 63.2,137 63.2,83" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="0.8"/>
                                <polygon points="110,38 172.4,74 172.4,146 110,182 47.6,146 47.6,74" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="0.8"/>
                                <polygon points="110,20 187.9,65 187.9,155 110,200 32.1,155 32.1,65" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="1"/>
                                {{-- Axis lines --}}
                                <line x1="110" y1="110" x2="110" y2="20" stroke="rgba(255,255,255,0.07)" stroke-width="0.8"/>
                                <line x1="110" y1="110" x2="187.9" y2="65" stroke="rgba(255,255,255,0.07)" stroke-width="0.8"/>
                                <line x1="110" y1="110" x2="187.9" y2="155" stroke="rgba(255,255,255,0.07)" stroke-width="0.8"/>
                                <line x1="110" y1="110" x2="110" y2="200" stroke="rgba(255,255,255,0.07)" stroke-width="0.8"/>
                                <line x1="110" y1="110" x2="32.1" y2="155" stroke="rgba(255,255,255,0.07)" stroke-width="0.8"/>
                                <line x1="110" y1="110" x2="32.1" y2="65" stroke="rgba(255,255,255,0.07)" stroke-width="0.8"/>
                                {{-- Axis labels --}}
                                <text x="110" y="12" text-anchor="middle" fill="rgba(255,255,255,0.38)" font-size="7" font-weight="700" letter-spacing="0.06em">META</text>
                                <text x="197" y="61" text-anchor="start" fill="rgba(255,255,255,0.38)" font-size="7" font-weight="700" letter-spacing="0.06em">CONTENT</text>
                                <text x="197" y="161" text-anchor="start" fill="rgba(255,255,255,0.38)" font-size="7" font-weight="700" letter-spacing="0.06em">MEDIA</text>
                                <text x="110" y="218" text-anchor="middle" fill="rgba(255,255,255,0.38)" font-size="7" font-weight="700" letter-spacing="0.06em">TECHNICAL</text>
                                <text x="23" y="161" text-anchor="end" fill="rgba(255,255,255,0.38)" font-size="7" font-weight="700" letter-spacing="0.06em">SOCIAL</text>
                                <text x="23" y="61" text-anchor="end" fill="rgba(255,255,255,0.38)" font-size="7" font-weight="700" letter-spacing="0.06em">CRAWL</text>
                                {{-- Dynamic data polygon --}}
                                <polygon :points="radarPolygon()" fill="rgba(255,100,0,0.18)" stroke="#FF6400" stroke-width="2.5" stroke-linejoin="round"/>
                                {{-- Score dots – 6 static bindings (SVG namespace safe) --}}
                                <circle :cx="radarPoints()[0].x" :cy="radarPoints()[0].y" r="4.5" :fill="scoreColor(radarPoints()[0].score)" stroke="rgba(14,12,36,0.9)" stroke-width="2"/>
                                <circle :cx="radarPoints()[1].x" :cy="radarPoints()[1].y" r="4.5" :fill="scoreColor(radarPoints()[1].score)" stroke="rgba(14,12,36,0.9)" stroke-width="2"/>
                                <circle :cx="radarPoints()[2].x" :cy="radarPoints()[2].y" r="4.5" :fill="scoreColor(radarPoints()[2].score)" stroke="rgba(14,12,36,0.9)" stroke-width="2"/>
                                <circle :cx="radarPoints()[3].x" :cy="radarPoints()[3].y" r="4.5" :fill="scoreColor(radarPoints()[3].score)" stroke="rgba(14,12,36,0.9)" stroke-width="2"/>
                                <circle :cx="radarPoints()[4].x" :cy="radarPoints()[4].y" r="4.5" :fill="scoreColor(radarPoints()[4].score)" stroke="rgba(14,12,36,0.9)" stroke-width="2"/>
                                <circle :cx="radarPoints()[5].x" :cy="radarPoints()[5].y" r="4.5" :fill="scoreColor(radarPoints()[5].score)" stroke="rgba(14,12,36,0.9)" stroke-width="2"/>
                            </svg>
                        </div>
                        {{-- Score breakdown bars --}}
                        <div class="ar-radar-scores-grid">
                            <template x-for="(sc,i) in radarScoreItems()" :key="i">
                                <div class="ar-radar-score-row">
                                    <div class="ar-radar-score-top">
                                        <span class="ar-radar-score-label" x-text="sc.label"></span>
                                        <span class="ar-radar-score-val" :style="`color:${scoreColor(sc.score)}`" x-text="sc.score+'%'"></span>
                                    </div>
                                    <div class="ar-radar-bar-bg">
                                        <div class="ar-radar-bar-fill" :style="`width:${sc.score}%;background:${scoreColor(sc.score)};transition:width 1.3s ease ${0.3+i*0.12}s`"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div style="height:2rem"></div>

                {{-- Vitals legend --}}
                <div class="ar-section-head">
                    <div>
                        <p class="sh__eye" style="text-align:left">Google Lighthouse · Mobile</p>
                        <h2 class="sh__title" style="font-size:clamp(1.5rem,3vw,2rem);text-align:left;margin-bottom:0">Core Web Vitals</h2>
                    </div>
                    <div class="ar-legend">
                        <span class="ar-legend-dot" style="background:#10B981"></span>Good
                        <span class="ar-legend-dot" style="background:#F59E0B;margin-left:.75rem"></span>Needs Work
                        <span class="ar-legend-dot" style="background:#EF4444;margin-left:.75rem"></span>Poor
                    </div>
                </div>

                <div class="ar-vitals-grid">
                    <template x-for="v in vitalItems()" :key="v.key">
                        <div class="ar-vital-card" :class="`ar-vital--${ratingClass(v.score)}`">
                            <div class="ar-vital__top">
                                <span class="ar-vital__name" x-text="v.label"></span>
                                <span :class="`ar-pill ar-pill--${ratingClass(v.score)}`" x-text="ratingLabel(v.score)"></span>
                            </div>
                            <div class="ar-vital__val" x-text="v.display"></div>
                            <div class="ar-vital__bar-bg">
                                <div class="ar-vital__seg" style="background:#10B981;border-radius:99px 0 0 99px" :style="`width:${v.gPct}%;background:#10B981`"></div>
                                <div class="ar-vital__seg" :style="`width:${v.wPct}%;background:#F59E0B`"></div>
                                <div class="ar-vital__seg" :style="`width:${v.pPct}%;background:#EF4444;border-radius:0 99px 99px 0;flex:1`"></div>
                            </div>
                            <div class="ar-vital__ticks"><span x-text="v.gMax"></span><span x-text="v.wMax"></span></div>
                            <p class="ar-vital__desc" x-text="v.desc"></p>
                        </div>
                    </template>
                </div>

                <div style="height:3rem"></div>

                {{-- Desktop Vitals --}}
                <div class="ar-section-head">
                    <div>
                        <p class="sh__eye" style="text-align:left">Google Lighthouse · Desktop</p>
                        <h2 class="sh__title" style="font-size:clamp(1.3rem,2.5vw,1.8rem);text-align:left;margin-bottom:0">Desktop Performance</h2>
                    </div>
                </div>
                <div class="ar-vitals-grid">
                    <template x-for="v in desktopVitalItems()" :key="v.key">
                        <div class="ar-vital-card" :class="`ar-vital--${ratingClass(v.score)}`">
                            <div class="ar-vital__top">
                                <span class="ar-vital__name" x-text="v.label"></span>
                                <span :class="`ar-pill ar-pill--${ratingClass(v.score)}`" x-text="ratingLabel(v.score)"></span>
                            </div>
                            <div class="ar-vital__val" x-text="v.display"></div>
                            <div class="ar-vital__bar-bg">
                                <div class="ar-vital__seg" :style="`width:${v.gPct}%;background:#10B981;border-radius:99px 0 0 99px`"></div>
                                <div class="ar-vital__seg" :style="`width:${v.wPct}%;background:#F59E0B`"></div>
                                <div class="ar-vital__seg" :style="`width:${v.pPct}%;background:#EF4444;border-radius:0 99px 99px 0;flex:1`"></div>
                            </div>
                            <div class="ar-vital__ticks"><span x-text="v.gMax"></span><span x-text="v.wMax"></span></div>
                            <p class="ar-vital__desc" x-text="v.desc"></p>
                        </div>
                    </template>
                </div>

            </div>
        </div>

        {{-- ④ SEO CHECKS TAB --}}
        <div x-show="tab==='seo'" class="section">
            <div class="container">

                {{-- SERP Preview --}}
                <div class="ar-serp-card">
                    <p class="ar-serp-card__label"><i class="ri-google-line"></i> Google Search Preview</p>
                    <div class="ar-serp-preview">
                        <div class="ar-serp-url" x-text="serpUrl()"></div>
                        <div class="ar-serp-title" x-text="result?.on_page?.title?.value||'(No title tag found)'"></div>
                        <div class="ar-serp-desc" x-text="result?.on_page?.description?.value||'(No meta description found — Google will auto-generate a snippet from your page content.)'"></div>
                    </div>
                </div>

                {{-- Title + Meta with length bars --}}
                <div class="ar-meta-cards">

                    <div class="ar-meta-card" :class="`ar-meta-card--${result?.on_page?.title?.status}`"
                         @click="toggle('title')" style="cursor:pointer">
                        <div class="ar-meta-card__head">
                            <i :class="statusIcon(result?.on_page?.title?.status)" :style="`color:${statusColor(result?.on_page?.title?.status)}`"></i>
                            <span>Title Tag</span>
                            <span class="ar-meta-len" x-text="(result?.on_page?.title?.length??0)+' / 60 chars'"></span>
                            <i class="ri-arrow-down-s-line ar-expand-icon" :class="{'ar-expand-icon--open':isOpen('title')}"></i>
                        </div>
                        <p class="ar-meta-val" x-text="result?.on_page?.title?.value||'Not found'"></p>
                        <div class="ar-len-track">
                            <div class="ar-len-fill" :style="`width:${Math.min((result?.on_page?.title?.length??0)/70*100,100)}%;background:${statusColor(result?.on_page?.title?.status)}`"></div>
                            <div class="ar-len-zone" style="left:71.4%;width:14.3%"></div>
                        </div>
                        <div class="ar-len-ticks"><span>0</span><span>50</span><span>60</span><span>70+</span></div>
                        <p class="ar-meta-msg" :style="`color:${statusColor(result?.on_page?.title?.status)}`" x-text="result?.on_page?.title?.message"></p>
                        <div class="ar-fix-box" x-show="isOpen('title')">
                            <i class="ri-tools-line"></i>
                            <span x-text="result?.on_page?.title?.fix"></span>
                        </div>
                    </div>

                    <div class="ar-meta-card" :class="`ar-meta-card--${result?.on_page?.description?.status}`"
                         @click="toggle('desc')" style="cursor:pointer">
                        <div class="ar-meta-card__head">
                            <i :class="statusIcon(result?.on_page?.description?.status)" :style="`color:${statusColor(result?.on_page?.description?.status)}`"></i>
                            <span>Meta Description</span>
                            <span class="ar-meta-len" x-text="(result?.on_page?.description?.length??0)+' / 160 chars'"></span>
                            <i class="ri-arrow-down-s-line ar-expand-icon" :class="{'ar-expand-icon--open':isOpen('desc')}"></i>
                        </div>
                        <p class="ar-meta-val" x-text="result?.on_page?.description?.value||'Not found'"></p>
                        <div class="ar-len-track">
                            <div class="ar-len-fill" :style="`width:${Math.min((result?.on_page?.description?.length??0)/180*100,100)}%;background:${statusColor(result?.on_page?.description?.status)}`"></div>
                            <div class="ar-len-zone" style="left:66.7%;width:22.2%"></div>
                        </div>
                        <div class="ar-len-ticks"><span>0</span><span>120</span><span>160</span><span>180+</span></div>
                        <p class="ar-meta-msg" :style="`color:${statusColor(result?.on_page?.description?.status)}`" x-text="result?.on_page?.description?.message"></p>
                        <div class="ar-fix-box" x-show="isOpen('desc')">
                            <i class="ri-tools-line"></i>
                            <span x-text="result?.on_page?.description?.fix"></span>
                        </div>
                    </div>

                </div>

                {{-- SEO check items --}}
                <h3 class="ar-group-title" style="margin-top:2rem"><i class="ri-file-text-line"></i> Content &amp; Structure</h3>
                <div class="ar-checks-list">
                    <template x-for="item in contentCheckItems()" :key="item.key">
                        <div class="ar-expand-card" :class="`ar-expand-card--${item.status}`" @click="toggle(item.key)">
                            <div class="ar-expand-card__row">
                                <div class="ar-check-icon" :style="`color:${statusColor(item.status)};background:${statusColor(item.status)}14`">
                                    <i :class="statusIcon(item.status)"></i>
                                </div>
                                <div style="flex:1;min-width:0">
                                    <p class="ar-check-label" x-text="item.label"></p>
                                    <p class="ar-check-msg" x-text="item.message"></p>
                                </div>
                                <i class="ri-arrow-down-s-line ar-expand-icon" :class="{'ar-expand-icon--open':isOpen(item.key)}"></i>
                            </div>
                            <div class="ar-fix-box" x-show="isOpen(item.key)">
                                <i class="ri-tools-line"></i>
                                <span x-text="item.fix"></span>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Heading breakdown --}}
                <div class="ar-heading-viz" style="margin-top:1.5rem">
                    <div class="ar-hbox ar-hbox--h1" :class="(result?.on_page?.h1?.count===1)?'ar-hbox--pass':'ar-hbox--fail'">
                        <span class="ar-hbox__tag">H1</span>
                        <span class="ar-hbox__text" x-text="result?.on_page?.h1?.text||'—'"></span>
                        <span class="ar-hbox__count" x-text="'×'+(result?.on_page?.h1?.count??0)"></span>
                    </div>
                    <div class="ar-hbox ar-hbox--h2">
                        <span class="ar-hbox__tag" style="background:#0EA5E920;color:#0EA5E9;border-color:#0EA5E930">H2</span>
                        <span class="ar-hbox__text" style="color:var(--fg-text-muted)" x-text="(result?.on_page?.h2?.count??0)+' subheadings found'"></span>
                        <span class="ar-hbox__count" x-text="'×'+(result?.on_page?.h2?.count??0)"></span>
                    </div>
                    <div class="ar-hbox ar-hbox--h3">
                        <span class="ar-hbox__tag" style="background:#6366F120;color:#6366F1;border-color:#6366F130">H3</span>
                        <span class="ar-hbox__text" style="color:var(--fg-text-muted)" x-text="(result?.on_page?.h2?.h3_count??0)+' sub-subheadings found'"></span>
                        <span class="ar-hbox__count" x-text="'×'+(result?.on_page?.h2?.h3_count??0)"></span>
                    </div>
                </div>

                {{-- Image analysis --}}
                <h3 class="ar-group-title" style="margin-top:2rem"><i class="ri-image-line"></i> Image Analysis</h3>
                <div class="ar-img-row">
                    <div class="ar-img-stat">
                        <span class="ar-img-stat__num" style="color:#F59E0B" x-text="result?.on_page?.images?.total??0"></span>
                        <span class="ar-img-stat__lbl">Total Images</span>
                    </div>
                    <div class="ar-img-stat">
                        <span class="ar-img-stat__num" :style="`color:${(result?.on_page?.images?.without_alt??0)>0?'#EF4444':'#10B981'}`" x-text="result?.on_page?.images?.without_alt??0"></span>
                        <span class="ar-img-stat__lbl">Missing Alt</span>
                    </div>
                    <div class="ar-img-stat">
                        <span class="ar-img-stat__num" style="color:#10B981" x-text="(result?.on_page?.images?.total??0)-(result?.on_page?.images?.without_alt??0)"></span>
                        <span class="ar-img-stat__lbl">With Alt Text</span>
                    </div>
                    <div class="ar-img-coverage">
                        <p style="font-size:.75rem;font-weight:700;color:var(--fg-text-muted);margin-bottom:.5rem">Alt Text Coverage</p>
                        <div class="ar-cov-bar"><div class="ar-cov-fill" :style="`width:${imgCoverage()}%`"></div></div>
                        <div style="display:flex;justify-content:space-between;font-size:.75rem;margin-top:.3rem">
                            <span style="color:#10B981;font-weight:700" x-text="imgCoverage()+'%'"></span>
                            <span style="color:var(--fg-text-muted)" x-text="result?.on_page?.images?.message"></span>
                        </div>
                    </div>
                </div>

                {{-- Links --}}
                <h3 class="ar-group-title" style="margin-top:2rem"><i class="ri-links-line"></i> Links</h3>
                <div class="ar-links-row">
                    <div class="ar-link-card" style="border-color:rgba(99,102,241,.25)">
                        <i class="ri-arrow-right-circle-line" style="color:#6366F1;font-size:1.5rem;margin-bottom:.5rem"></i>
                        <span class="ar-link-card__num" style="color:#6366F1" x-text="result?.on_page?.links?.internal??0"></span>
                        <span class="ar-link-card__lbl">Internal Links</span>
                    </div>
                    <div class="ar-link-card" style="border-color:rgba(14,165,233,.25)">
                        <i class="ri-external-link-line" style="color:#0EA5E9;font-size:1.5rem;margin-bottom:.5rem"></i>
                        <span class="ar-link-card__num" style="color:#0EA5E9" x-text="result?.on_page?.links?.external??0"></span>
                        <span class="ar-link-card__lbl">External Links</span>
                    </div>
                    <div class="ar-link-card" style="border-color:rgba(16,185,129,.25)">
                        <i class="ri-file-word-line" style="color:#10B981;font-size:1.5rem;margin-bottom:.5rem"></i>
                        <span class="ar-link-card__num" style="color:#10B981" x-text="result?.on_page?.word_count?.count??0"></span>
                        <span class="ar-link-card__lbl">Words</span>
                    </div>
                </div>

                {{-- Keyword Consistency --}}
                <h3 class="ar-group-title" style="margin-top:2rem"><i class="ri-key-2-line"></i> Keyword Consistency</h3>
                <div class="ar-kw-card" :class="`ar-expand-card--${result?.on_page?.keywords?.status||'warn'}`">
                    <div class="ar-kw-status-row">
                        <div class="ar-check-icon" :style="`color:${statusColor(result?.on_page?.keywords?.status)};background:${statusColor(result?.on_page?.keywords?.status)}14`">
                            <i :class="statusIcon(result?.on_page?.keywords?.status)"></i>
                        </div>
                        <div>
                            <p class="ar-check-label" x-text="result?.on_page?.keywords?.message||'Analyzing keywords…'"></p>
                            <p class="ar-check-msg">Top keywords should appear in title, meta description &amp; H1</p>
                        </div>
                    </div>
                    <div class="ar-kw-table-wrap" x-show="(result?.on_page?.keywords?.top||[]).length>0">
                        <table class="ar-kw-table">
                            <thead><tr><th>Keyword</th><th>Freq</th><th title="In Title">Title</th><th title="In Meta">Meta</th><th title="In H1">H1</th></tr></thead>
                            <tbody>
                                <template x-for="(kw,i) in (result?.on_page?.keywords?.top||[])" :key="i">
                                    <tr>
                                        <td x-text="kw.word"></td>
                                        <td style="font-weight:700;color:var(--fg-heading)" x-text="kw.count"></td>
                                        <td><i :class="kw.in_title?'ri-checkbox-circle-fill':'ri-close-circle-line'" :style="`color:${kw.in_title?'#10B981':'rgba(255,255,255,0.2)'};font-size:1rem`"></i></td>
                                        <td><i :class="kw.in_meta?'ri-checkbox-circle-fill':'ri-close-circle-line'" :style="`color:${kw.in_meta?'#10B981':'rgba(255,255,255,0.2)'};font-size:1rem`"></i></td>
                                        <td><i :class="kw.in_h1?'ri-checkbox-circle-fill':'ri-close-circle-line'" :style="`color:${kw.in_h1?'#10B981':'rgba(255,255,255,0.2)'};font-size:1rem`"></i></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="ar-fix-box" style="margin-top:.75rem">
                        <i class="ri-tools-line"></i>
                        <span x-text="result?.on_page?.keywords?.fix"></span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ⑤ TECHNICAL TAB --}}
        <div x-show="tab==='technical'" class="section">
            <div class="container">

                {{-- Summary row --}}
                <div class="ar-tech-summary">
                    <div class="ar-tech-sum-item">
                        <span class="ar-tech-sum-num" style="color:#EF4444" x-text="techIssues()"></span>
                        <span class="ar-tech-sum-lbl">Critical</span>
                    </div>
                    <div style="width:1px;background:var(--fg-border);align-self:stretch"></div>
                    <div class="ar-tech-sum-item">
                        <span class="ar-tech-sum-num" style="color:#F59E0B" x-text="techWarnings()"></span>
                        <span class="ar-tech-sum-lbl">Warnings</span>
                    </div>
                    <div style="width:1px;background:var(--fg-border);align-self:stretch"></div>
                    <div class="ar-tech-sum-item">
                        <span class="ar-tech-sum-num" style="color:#10B981" x-text="techPassed()"></span>
                        <span class="ar-tech-sum-lbl">Passed</span>
                    </div>
                </div>

                <h3 class="ar-group-title"><i class="ri-shield-check-line"></i> Security &amp; Indexability</h3>
                <div class="ar-checks-list">
                    <template x-for="item in securityCheckItems()" :key="item.key">
                        <div class="ar-expand-card" :class="`ar-expand-card--${item.status}`" @click="toggle(item.key)">
                            <div class="ar-expand-card__row">
                                <div class="ar-check-icon" :style="`color:${statusColor(item.status)};background:${statusColor(item.status)}14`"><i :class="statusIcon(item.status)"></i></div>
                                <div style="flex:1;min-width:0">
                                    <p class="ar-check-label" x-text="item.label"></p>
                                    <p class="ar-check-msg" x-text="item.message"></p>
                                </div>
                                <i class="ri-arrow-down-s-line ar-expand-icon" :class="{'ar-expand-icon--open':isOpen(item.key)}"></i>
                            </div>
                            <div class="ar-fix-box" x-show="isOpen(item.key)">
                                <i class="ri-tools-line"></i>
                                <span x-text="item.fix"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <h3 class="ar-group-title" style="margin-top:2rem"><i class="ri-share-line"></i> Social &amp; Metadata</h3>
                <div class="ar-checks-list">
                    <template x-for="item in socialCheckItems()" :key="item.key">
                        <div class="ar-expand-card" :class="`ar-expand-card--${item.status}`" @click="toggle(item.key)">
                            <div class="ar-expand-card__row">
                                <div class="ar-check-icon" :style="`color:${statusColor(item.status)};background:${statusColor(item.status)}14`"><i :class="statusIcon(item.status)"></i></div>
                                <div style="flex:1;min-width:0">
                                    <p class="ar-check-label" x-text="item.label"></p>
                                    <p class="ar-check-msg" x-text="item.message"></p>
                                </div>
                                <i class="ri-arrow-down-s-line ar-expand-icon" :class="{'ar-expand-icon--open':isOpen(item.key)}"></i>
                            </div>
                            <div class="ar-fix-box" x-show="isOpen(item.key)">
                                <i class="ri-tools-line"></i>
                                <span x-text="item.fix"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <h3 class="ar-group-title" style="margin-top:2rem"><i class="ri-sitemap-line"></i> Crawlability</h3>
                <div class="ar-checks-list">
                    <template x-for="item in crawlCheckItems()" :key="item.key">
                        <div class="ar-expand-card" :class="`ar-expand-card--${item.status}`" @click="toggle(item.key)">
                            <div class="ar-expand-card__row">
                                <div class="ar-check-icon" :style="`color:${statusColor(item.status)};background:${statusColor(item.status)}14`"><i :class="statusIcon(item.status)"></i></div>
                                <div style="flex:1;min-width:0">
                                    <p class="ar-check-label" x-text="item.label"></p>
                                    <p class="ar-check-msg" x-text="item.message"></p>
                                </div>
                                <i class="ri-arrow-down-s-line ar-expand-icon" :class="{'ar-expand-icon--open':isOpen(item.key)}"></i>
                            </div>
                            <div class="ar-fix-box" x-show="isOpen(item.key)">
                                <i class="ri-tools-line"></i>
                                <span x-text="item.fix"></span>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Social Profiles Found --}}
                <h3 class="ar-group-title" style="margin-top:2rem"><i class="ri-share-2-line"></i> Social Profiles Detected on Page</h3>
                <div class="ar-social-profiles">
                    <template x-for="pl in socialProfileItems()" :key="pl.key">
                        <a :href="pl.url||'#'" target="_blank" class="ar-social-profile" :class="pl.url?'ar-social-profile--found':'ar-social-profile--missing'" @click.prevent="pl.url&&window.open(pl.url,'_blank')">
                            <i :class="pl.icon" :style="`font-size:1.3rem;color:${pl.url?pl.color:'rgba(255,255,255,0.18)'}`"></i>
                            <div style="flex:1;min-width:0">
                                <p class="ar-sp-name" x-text="pl.name"></p>
                                <p class="ar-sp-url" x-text="pl.url||'Not linked on page'"></p>
                            </div>
                            <span class="ar-sp-badge" :class="pl.url?'ar-sp-badge--found':'ar-sp-badge--missing'" x-text="pl.url?'Found':'Missing'"></span>
                        </a>
                    </template>
                </div>

                {{-- Technology Stack --}}
                <h3 class="ar-group-title" style="margin-top:2rem"><i class="ri-code-box-line"></i> Technology Stack</h3>
                <div x-show="!(result?.on_page?.technologies?.length)" class="ar-kw-card" style="padding:1rem 1.25rem">
                    <p style="color:var(--fg-text-muted);font-size:.85rem;margin:0">No technologies detected on this page.</p>
                </div>
                <div class="ar-tech-grid">
                    <template x-for="(tech,i) in (result?.on_page?.technologies||[])" :key="i">
                        <div class="ar-tech-item">
                            <i class="ri-code-s-slash-line" style="color:#6366F1;font-size:1.15rem;flex-shrink:0"></i>
                            <div style="min-width:0">
                                <p class="ar-tech-name" x-text="tech.name"></p>
                                <p class="ar-tech-cat" x-text="tech.category"></p>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Server Information --}}
                <h3 class="ar-group-title" style="margin-top:2rem"><i class="ri-server-line"></i> Server Information</h3>
                <div class="ar-server-grid">
                    <template x-if="result?.on_page?.server_info?.ip">
                        <div class="ar-server-item"><span class="ar-server-lbl">Server IP</span><code class="ar-server-val" x-text="result.on_page.server_info.ip"></code></div>
                    </template>
                    <template x-if="result?.on_page?.server_info?.server">
                        <div class="ar-server-item"><span class="ar-server-lbl">Web Server</span><span class="ar-server-val" x-text="result.on_page.server_info.server"></span></div>
                    </template>
                    <template x-if="result?.on_page?.server_info?.charset">
                        <div class="ar-server-item"><span class="ar-server-lbl">Charset</span><span class="ar-server-val" x-text="result.on_page.server_info.charset"></span></div>
                    </template>
                    <div class="ar-server-item">
                        <span class="ar-server-lbl">Compression</span>
                        <span class="ar-server-val" :style="`color:${result?.on_page?.server_info?.compression?'#10B981':'#F59E0B'}`" x-text="result?.on_page?.server_info?.compression?.toUpperCase()||'Not detected'"></span>
                    </div>
                    <div class="ar-server-item"><span class="ar-server-lbl">JS Files</span><span class="ar-server-val" x-text="(result?.on_page?.resources?.js??0)+' files'"></span></div>
                    <div class="ar-server-item"><span class="ar-server-lbl">CSS Files</span><span class="ar-server-val" x-text="(result?.on_page?.resources?.css??0)+' files'"></span></div>
                    <div class="ar-server-item"><span class="ar-server-lbl">Images</span><span class="ar-server-val" x-text="(result?.on_page?.resources?.images??0)+' files'"></span></div>
                    <div class="ar-server-item"><span class="ar-server-lbl">Total Resources</span><span class="ar-server-val" style="color:var(--fg-heading);font-weight:700" x-text="(result?.on_page?.resources?.total??0)+' files'"></span></div>
                </div>

            </div>
        </div>

        {{-- ⑥ PERFORMANCE TAB --}}
        <div x-show="tab==='performance'" class="section">
            <div class="container">

                {{-- Big speed dial + desktop comparison --}}
                <div class="ar-perf-hero">
                    {{-- Mobile speed dial --}}
                    <div class="ar-speed-dial">
                        <p class="ar-speed-dial__label">Mobile Performance</p>
                        <svg viewBox="0 0 240 140" class="ar-speed-dial__svg">
                            <defs>
                                <linearGradient id="gaugePoor" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#EF4444"/>
                                    <stop offset="100%" style="stop-color:#F59E0B"/>
                                </linearGradient>
                                <linearGradient id="gaugeGood" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#F59E0B"/>
                                    <stop offset="100%" style="stop-color:#10B981"/>
                                </linearGradient>
                            </defs>
                            <path d="M 20 125 A 100 100 0 0 1 220 125" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="18" stroke-linecap="round"/>
                            <path d="M 20 125 A 100 100 0 0 1 220 125" fill="none"
                                :stroke="scoreColor(result?.scores?.performance??0)" stroke-width="18" stroke-linecap="round"
                                :stroke-dasharray="314" :stroke-dashoffset="314*(1-(result?.scores?.performance??0)/100)"
                                style="transition:stroke-dashoffset 1.8s ease .3s"/>
                            <text x="120" y="108" text-anchor="middle" fill="white" font-size="46" font-weight="800" font-family="'Clash Display',sans-serif" x-text="result?.scores?.performance??0"></text>
                            <text x="120" y="130" text-anchor="middle" fill="rgba(255,255,255,.35)" font-size="9" letter-spacing="1.5" font-weight="700">PERFORMANCE SCORE</text>
                            <text x="20" y="140" text-anchor="middle" fill="rgba(255,255,255,.3)" font-size="9">0</text>
                            <text x="220" y="140" text-anchor="middle" fill="rgba(255,255,255,.3)" font-size="9">100</text>
                        </svg>
                        <div class="ar-speed-dial__grade" :style="`color:${gradeColor(result?.scores?.performance??0)}`" x-text="grade(result?.scores?.performance??0)"></div>
                    </div>

                    {{-- Desktop speed dial --}}
                    <div class="ar-speed-dial">
                        <p class="ar-speed-dial__label">Desktop Performance</p>
                        <svg viewBox="0 0 240 140" class="ar-speed-dial__svg">
                            <path d="M 20 125 A 100 100 0 0 1 220 125" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="18" stroke-linecap="round"/>
                            <path d="M 20 125 A 100 100 0 0 1 220 125" fill="none"
                                :stroke="scoreColor(result?.desktop_scores?.performance??0)" stroke-width="18" stroke-linecap="round"
                                :stroke-dasharray="314" :stroke-dashoffset="314*(1-(result?.desktop_scores?.performance??0)/100)"
                                style="transition:stroke-dashoffset 1.8s ease .5s"/>
                            <text x="120" y="108" text-anchor="middle" fill="white" font-size="46" font-weight="800" font-family="'Clash Display',sans-serif" x-text="result?.desktop_scores?.performance??0"></text>
                            <text x="120" y="130" text-anchor="middle" fill="rgba(255,255,255,.35)" font-size="9" letter-spacing="1.5" font-weight="700">PERFORMANCE SCORE</text>
                            <text x="20" y="140" text-anchor="middle" fill="rgba(255,255,255,.3)" font-size="9">0</text>
                            <text x="220" y="140" text-anchor="middle" fill="rgba(255,255,255,.3)" font-size="9">100</text>
                        </svg>
                        <div class="ar-speed-dial__grade" :style="`color:${gradeColor(result?.desktop_scores?.performance??0)}`" x-text="grade(result?.desktop_scores?.performance??0)"></div>
                    </div>

                    {{-- Page info stats --}}
                    <div class="ar-perf-stats">
                        <p class="ar-perf-stats__title">Page Info</p>
                        <div class="ar-perf-stat-list">
                            <div class="ar-perf-stat-item">
                                <i class="ri-file-zip-line" style="color:#6366F1"></i>
                                <div>
                                    <p class="ar-perf-stat-val" x-text="result?.page_info?.size_kb ? result.page_info.size_kb+'KB' : 'N/A'"></p>
                                    <p class="ar-perf-stat-lbl">Page Size</p>
                                </div>
                            </div>
                            <div class="ar-perf-stat-item">
                                <i class="ri-arrow-left-right-line" style="color:#0EA5E9"></i>
                                <div>
                                    <p class="ar-perf-stat-val" x-text="result?.page_info?.requests ? result.page_info.requests+' reqs' : 'N/A'"></p>
                                    <p class="ar-perf-stat-lbl">HTTP Requests</p>
                                </div>
                            </div>
                            <div class="ar-perf-stat-item">
                                <i class="ri-timer-2-line" style="color:#F59E0B"></i>
                                <div>
                                    <p class="ar-perf-stat-val" x-text="result?.page_info?.load_time||'N/A'"></p>
                                    <p class="ar-perf-stat-lbl">Time to Interactive</p>
                                </div>
                            </div>
                            <div class="ar-perf-stat-item">
                                <i class="ri-file-word-line" style="color:#EC4899"></i>
                                <div>
                                    <p class="ar-perf-stat-val" x-text="result?.on_page?.word_count?.count??0"></p>
                                    <p class="ar-perf-stat-lbl">Word Count</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Opportunities --}}
                <h3 class="ar-group-title" style="margin-top:2.5rem"><i class="ri-flashlight-line"></i> Performance Opportunities</h3>

                <div x-show="!result?.opportunities?.length" class="ar-empty-opp">
                    <i class="ri-rocket-2-line" style="font-size:2.5rem;color:#10B981;display:block;margin-bottom:.75rem"></i>
                    <p style="font-weight:700;color:var(--fg-heading);margin-bottom:.35rem">No Major Issues Found!</p>
                    <p style="color:var(--fg-text-muted);font-size:.88rem">No significant performance opportunities detected. Great work!</p>
                </div>

                <div class="ar-opp-list">
                    <template x-for="(opp,idx) in result?.opportunities" :key="idx">
                        <div class="ar-opp-card" @click="toggle('opp_'+idx)">
                            <div class="ar-opp-card__head">
                                <div class="ar-opp-icon" :style="`background:${oppColor(opp.score)}14;border-color:${oppColor(opp.score)}30`">
                                    <i class="ri-flashlight-line" :style="`color:${oppColor(opp.score)}`"></i>
                                </div>
                                <div style="flex:1;min-width:0">
                                    <p class="ar-opp-title" x-text="opp.title"></p>
                                    <div style="display:flex;align-items:center;gap:.4rem;flex-wrap:wrap;margin-top:.2rem">
                                        <template x-if="opp.savings_ms">
                                            <span class="ar-opp-save" x-text="'⚡ Save ~'+formatMs(opp.savings_ms)"></span>
                                        </template>
                                        <span class="ar-opp-pill" :style="`background:${oppColor(opp.score)}12;color:${oppColor(opp.score)};border-color:${oppColor(opp.score)}30`" x-text="Math.round(opp.score*100)+'% score'"></span>
                                    </div>
                                </div>
                                <i class="ri-arrow-down-s-line ar-expand-icon" :class="{'ar-expand-icon--open':isOpen('opp_'+idx)}"></i>
                            </div>
                            <div class="ar-opp-bar-bg"><div class="ar-opp-bar-fill" :style="`width:${opp.score*100}%;background:${oppColor(opp.score)}`"></div></div>
                            <div class="ar-fix-box" x-show="isOpen('opp_'+idx)">
                                <i class="ri-information-line"></i>
                                <span x-text="opp.description"></span>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- CTA --}}
                <div class="ar-cta-box">
                    <div class="ar-cta-icon"><i class="ri-customer-service-2-line"></i></div>
                    <h3 class="ar-cta-title">Need Help Fixing These Issues?</h3>
                    <p class="ar-cta-text">Our SEO and performance team can implement every recommendation above. Book a free 30-minute strategy call — no obligation.</p>
                    <a href="{{ route('free-consultation') }}" class="btn-primary" style="width:100%;justify-content:center">
                        <i class="ri-calendar-check-line"></i> Book Free Strategy Call
                    </a>
                </div>

            </div>
        </div>

    </div>{{-- /results --}}

    {{-- Idle landing --}}
    <div x-show="state==='idle'">
        <section class="section section-alt">
            <div class="container">
                <div class="sh" data-gsap-fade>
                    <p class="sh__eye">What We Check</p>
                    <h2 class="sh__title">Comprehensive Analysis</h2>
                    <p class="sh__sub">20+ checks across performance, SEO, technical health, and social metadata.</p>
                </div>
                <div class="rg-3" style="margin-top:3rem" data-gsap-stagger>
                    @foreach([
                        ['ri-search-2-line',     '#FF6400', 'On-Page SEO',       'Title, meta description, H-tags, keyword structure, content length, SERP preview.'],
                        ['ri-speed-line',        '#6366F1', 'Core Web Vitals',   'FCP, LCP, TBT, CLS, TTI — Google Lighthouse scores for mobile and desktop.'],
                        ['ri-smartphone-line',   '#10B981', 'Mobile Performance','Mobile-first Lighthouse audit with load speed, interactivity and stability scores.'],
                        ['ri-shield-check-line', '#F59E0B', 'Technical SEO',     'HTTPS, canonical, viewport, robots.txt, sitemap, schema markup, favicon, lang attribute.'],
                        ['ri-share-line',        '#0EA5E9', 'Social Metadata',   'Open Graph tags, Twitter Cards, og:image — control how pages appear on social media.'],
                        ['ri-flashlight-line',   '#EC4899', 'Quick Wins',        'Prioritized performance opportunities with estimated time savings to guide your fixes.'],
                    ] as [$icon, $color, $title, $desc])
                    <div class="bento-card" style="padding:2rem">
                        <div style="width:48px;height:48px;border-radius:12px;background:{{ $color }}15;border:1px solid {{ $color }}30;display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem">
                            <i class="{{ $icon }}" style="color:{{ $color }};font-size:1.35rem"></i>
                        </div>
                        <h3 style="font-family:'Syne',sans-serif;font-weight:700;color:var(--fg-heading);margin-bottom:.5rem;font-size:.95rem">{{ $title }}</h3>
                        <p style="color:var(--fg-text-muted);font-size:.86rem;line-height:1.75;margin:0">{{ $desc }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

</div>

<script>
function auditApp() {
    return {
        url: '', state: 'idle', progress: 0, progressMsg: 'Starting analysis…',
        stepsDone: 0, result: null, errorMsg: '', tab: 'overview', open: {},
        loadingSteps: ['Fetching page HTML…','Running Lighthouse audit…','Analysing Core Web Vitals…','Checking on-page SEO…','Running desktop audit…','Building your report…'],

        init() {
            const p = new URLSearchParams(window.location.search);
            const u = p.get('url');
            if (!u) { return; }
            this.url = u;
            try {
                const c = localStorage.getItem('audit_v3_' + u);
                if (c) { this.result = JSON.parse(c); this.state = 'results'; return; }
            } catch(e) {}
            this.$nextTick(() => this.runAudit());
        },

        toggle(key) { this.open[key] = !this.open[key]; },
        isOpen(key) { return !!this.open[key]; },

        reAnalyze() {
            try { localStorage.removeItem('audit_v3_' + this.url); } catch(e) {}
            this.open = {};
            this.runAudit();
        },

        async runAudit() {
            if (!this.url.trim()) { return; }
            this.state = 'loading'; this.progress = 0; this.stepsDone = 0; this.result = null; this.open = {};
            const pu = new URL(window.location.href);
            pu.searchParams.set('url', this.url.trim());
            history.pushState({}, '', pu.toString());
            const total = this.loadingSteps.length;
            const iv = setInterval(() => {
                if (this.progress < 92) {
                    this.progress += Math.random() * 4 + 1;
                    this.stepsDone = Math.min(Math.floor(this.progress / (100 / total)), total - 1);
                    this.progressMsg = this.loadingSteps[this.stepsDone];
                }
            }, 900);
            try {
                const resp = await fetch('{{ route('free-audit.analyze') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                    body: JSON.stringify({ url: this.url }),
                });
                clearInterval(iv);
                this.progress = 100; this.stepsDone = total; this.progressMsg = 'Report ready!';
                if (!resp.ok) { const d = await resp.json(); this.errorMsg = d.error || 'Analysis failed.'; this.state = 'error'; return; }
                this.result = await resp.json();
                try { localStorage.setItem('audit_v3_' + this.url.trim(), JSON.stringify(this.result)); } catch(e) {}
                await new Promise(r => setTimeout(r, 400));
                this.state = 'results'; this.tab = 'overview';
                this.$nextTick(() => { const el = document.querySelector('.ar-header'); if (el) window.scrollTo({ top: el.offsetTop - 80, behavior: 'smooth' }); });
            } catch(e) {
                clearInterval(iv);
                this.errorMsg = 'Network error. Check your connection and try again.';
                this.state = 'error';
            }
        },

        serpUrl() {
            try {
                const u = new URL(this.result?.url || '');
                return u.hostname + ' › ' + (u.pathname === '/' ? 'home' : u.pathname.replace(/^\//, '').replace(/\//g, ' › '));
            } catch(e) { return this.result?.url || ''; }
        },

        avgScore() {
            const s = this.result?.scores; if (!s) return 0;
            if (this.psiUnavailable()) return this.onPageScore();
            const vals = [s.performance, s.seo, s.accessibility, s.best_practices].filter(v => v > 0);
            if (!vals.length) return this.onPageScore();
            return Math.round(vals.reduce((a,b) => a+b, 0) / vals.length);
        },

        onPageScore() {
            const p = this.result?.on_page; if (!p) return 0;
            const keys = ['title','description','h1','h2','images','links','canonical','viewport','og_tags','twitter_card','https','robots_txt','sitemap','schema','favicon','lang_attr','noindex','word_count'];
            let total = 0, count = 0;
            keys.forEach(k => { if (!p[k]?.status) return; count++; if (p[k].status==='pass') total+=100; else if (p[k].status==='warn') total+=50; });
            return count > 0 ? Math.round(total/count) : 0;
        },

        radarScores() {
            const p = this.result?.on_page; if (!p) return [0,0,0,0,0,0];
            const sc = k => { const s=p[k]?.status; return s==='pass'?100:s==='warn'?50:0; };
            const avg = ks => Math.round(ks.map(sc).reduce((a,b)=>a+b,0)/ks.length);
            return [avg(['title','description']), avg(['h1','h2','word_count']), avg(['images','links']), avg(['https','viewport','canonical','noindex']), avg(['og_tags','twitter_card','favicon','lang_attr']), avg(['robots_txt','sitemap','schema'])];
        },

        radarScoreItems() {
            const labels = ['Meta & Title','Content Quality','Images & Links','Technical SEO','Social Tags','Crawlability'];
            return this.radarScores().map((score,i) => ({score, label:labels[i]}));
        },

        radarPoints() {
            const scores = this.radarScores(), cx=110, cy=110, r=90;
            return [-90,-30,30,90,150,210].map((deg,i) => {
                const a=deg*Math.PI/180, pct=Math.max(0.06, scores[i]/100);
                return {i, score:scores[i], x:+(cx+pct*r*Math.cos(a)).toFixed(1), y:+(cy+pct*r*Math.sin(a)).toFixed(1)};
            });
        },

        radarPolygon() { return this.radarPoints().map(p=>`${p.x},${p.y}`).join(' '); },
        psiUnavailable() { const s = this.result?.scores; if (!s) return false; return s.performance===0 && s.seo===0 && s.accessibility===0 && s.best_practices===0; },
        issueCount(st) { const p = this.result?.on_page; if (!p) return 0; return Object.values(p).filter(v => v && typeof v==='object' && v.status===st).length; },
        imgCoverage() { const t=this.result?.on_page?.images?.total??0,m=this.result?.on_page?.images?.without_alt??0; return !t?100:Math.round(((t-m)/t)*100); },

        seoIssues() {
            const p = this.result?.on_page; if (!p) return 0;
            const seoKeys = ['title','description','h1','h2','images','links','word_count','keywords'];
            return seoKeys.filter(k => p[k] && (p[k].status==='fail'||p[k].status==='warn')).length;
        },
        techIssues() {
            const p = this.result?.on_page; if (!p) return 0;
            const keys = ['https','noindex','viewport','canonical','og_tags','twitter_card','robots_txt','sitemap','schema','favicon','lang_attr','hreflang','amp','email_privacy','dmarc','spf','deprecated_html','inline_styles'];
            return keys.filter(k => p[k] && p[k].status==='fail').length;
        },
        techWarnings() {
            const p = this.result?.on_page; if (!p) return 0;
            const keys = ['https','noindex','viewport','canonical','og_tags','twitter_card','robots_txt','sitemap','schema','favicon','lang_attr','hreflang','amp','email_privacy','dmarc','spf','deprecated_html','inline_styles'];
            return keys.filter(k => p[k] && p[k].status==='warn').length;
        },
        techPassed() {
            const p = this.result?.on_page; if (!p) return 0;
            const keys = ['https','noindex','viewport','canonical','og_tags','twitter_card','robots_txt','sitemap','schema','favicon','lang_attr','hreflang','amp','email_privacy','dmarc','spf','deprecated_html','inline_styles'];
            return keys.filter(k => p[k] && p[k].status==='pass').length;
        },

        grade(v) { if(v>=90)return 'A+'; if(v>=80)return 'A'; if(v>=70)return 'B+'; if(v>=60)return 'B'; if(v>=50)return 'C'; return 'F'; },
        gradeColor(v) { return v>=90?'#10B981':v>=70?'#84CC16':v>=50?'#F59E0B':'#EF4444'; },
        scoreColor(v) { return v>=90?'#10B981':v>=50?'#F59E0B':'#EF4444'; },
        oppColor(v) { return v>=0.5?'#F59E0B':'#EF4444'; },
        ratingClass(v) { if(v===null||v===undefined)return 'na'; return v>=0.9?'good':v>=0.5?'medium':'poor'; },
        ratingLabel(v) { if(v===null||v===undefined)return 'N/A'; return v>=0.9?'Good':v>=0.5?'Needs Work':'Poor'; },
        statusIcon(s) { return {pass:'ri-checkbox-circle-fill',warn:'ri-error-warning-fill',fail:'ri-close-circle-fill'}[s]||'ri-question-mark'; },
        statusColor(s) { return {pass:'#10B981',warn:'#F59E0B',fail:'#EF4444'}[s]||'#6B7280'; },
        formatMs(ms) { if(!ms)return ''; return ms>=1000?(ms/1000).toFixed(1)+'s':Math.round(ms)+'ms'; },
        formatDate(iso) { if(!iso)return ''; return new Date(iso).toLocaleString('en-US',{month:'short',day:'numeric',year:'numeric',hour:'2-digit',minute:'2-digit'}); },

        categoryCards() {
            const s=this.result?.scores; if(!s) return [];
            if (this.psiUnavailable()) {
                const ax=this.radarScoreItems();
                return [{key:'meta',label:'Meta & Title',value:ax[0]?.score??0},{key:'content',label:'Content',value:ax[1]?.score??0},{key:'technical',label:'Technical SEO',value:ax[3]?.score??0},{key:'social',label:'Social Tags',value:ax[4]?.score??0}];
            }
            return [{key:'performance',label:'Performance',value:s.performance},{key:'seo',label:'SEO',value:s.seo},{key:'accessibility',label:'Accessibility',value:s.accessibility},{key:'best_practices',label:'Best Practices',value:s.best_practices}];
        },
        comparisonItems() {
            const m=this.result?.scores,d=this.result?.desktop_scores; if(!m||!d) return [];
            return [
                {key:'performance',label:'Performance',mobile:m.performance,desktop:d.performance},
                {key:'seo',label:'SEO',mobile:m.seo,desktop:d.seo},
                {key:'accessibility',label:'Accessibility',mobile:m.accessibility,desktop:d.accessibility},
                {key:'best_practices',label:'Best Practices',mobile:m.best_practices,desktop:d.best_practices},
            ];
        },

        _vitalsBase(m) {
            if (!m) return [];
            return [
                {key:'fcp',label:'First Contentful Paint',display:m.fcp?.display,score:m.fcp?.score,desc:'Time until first content renders on screen.',gMax:'1.8s',wMax:'3.0s',gPct:30,wPct:20,pPct:50},
                {key:'lcp',label:'Largest Contentful Paint',display:m.lcp?.display,score:m.lcp?.score,desc:'Time for the largest visible element to load. Target: <2.5s.',gMax:'2.5s',wMax:'4.0s',gPct:35,wPct:20,pPct:45},
                {key:'tbt',label:'Total Blocking Time',display:m.tbt?.display,score:m.tbt?.score,desc:'Total time the main thread was blocked. Target: <200ms.',gMax:'200ms',wMax:'600ms',gPct:25,wPct:25,pPct:50},
                {key:'cls',label:'Cumulative Layout Shift',display:m.cls?.display,score:m.cls?.score,desc:'Visual stability — unexpected layout shifts. Target: <0.1.',gMax:'0.1',wMax:'0.25',gPct:33,wPct:20,pPct:47},
                {key:'tti',label:'Time to Interactive',display:m.tti?.display,score:m.tti?.score,desc:'Time until fully interactive. Target: <3.8s.',gMax:'3.8s',wMax:'7.3s',gPct:30,wPct:25,pPct:45},
                {key:'si',label:'Speed Index',display:m.speed_index?.display,score:m.speed_index?.score,desc:'How quickly content is visually populated.',gMax:'3.4s',wMax:'5.8s',gPct:32,wPct:22,pPct:46},
            ];
        },
        vitalItems() { return this._vitalsBase(this.result?.metrics); },
        desktopVitalItems() { return this._vitalsBase(this.result?.desktop_metrics); },

        contentCheckItems() {
            const p=this.result?.on_page; if(!p) return [];
            return [
                {key:'h1',label:'H1 Tag',status:p.h1?.status,message:p.h1?.message,fix:p.h1?.fix},
                {key:'h2_check',label:'Heading Structure (H2/H3)',status:p.h2?.status,message:p.h2?.message,fix:p.h2?.fix},
                {key:'images',label:'Image Alt Texts',status:p.images?.status,message:p.images?.message,fix:p.images?.fix},
                {key:'links',label:'Internal Linking',status:p.links?.status,message:p.links?.message,fix:p.links?.fix},
                {key:'word_count',label:'Content Length',status:p.word_count?.status,message:p.word_count?.message,fix:p.word_count?.fix},
            ];
        },
        securityCheckItems() {
            const p=this.result?.on_page; if(!p) return [];
            return [
                {key:'https',label:'HTTPS / SSL',status:p.https?.status,message:p.https?.message,fix:p.https?.fix},
                {key:'noindex',label:'Indexability',status:p.noindex?.status,message:p.noindex?.message,fix:p.noindex?.fix},
                {key:'viewport',label:'Viewport Meta',status:p.viewport?.status,message:p.viewport?.message,fix:p.viewport?.fix},
                {key:'email_privacy',label:'Email Privacy',status:p.email_privacy?.status,message:p.email_privacy?.message,fix:p.email_privacy?.fix},
                {key:'dmarc',label:'DMARC Record',status:p.dmarc?.status,message:p.dmarc?.message,fix:p.dmarc?.fix},
                {key:'spf',label:'SPF Record',status:p.spf?.status,message:p.spf?.message,fix:p.spf?.fix},
            ];
        },
        socialCheckItems() {
            const p=this.result?.on_page; if(!p) return [];
            return [
                {key:'og_tags',label:'Open Graph Tags',status:p.og_tags?.status,message:p.og_tags?.message,fix:p.og_tags?.fix},
                {key:'twitter_card',label:'Twitter / X Card',status:p.twitter_card?.status,message:p.twitter_card?.message,fix:p.twitter_card?.fix},
                {key:'lang_attr',label:'Language Attribute',status:p.lang_attr?.status,message:p.lang_attr?.message,fix:p.lang_attr?.fix},
                {key:'hreflang',label:'Hreflang Tags',status:p.hreflang?.status,message:p.hreflang?.message,fix:p.hreflang?.fix},
                {key:'favicon',label:'Favicon',status:p.favicon?.status,message:p.favicon?.message,fix:p.favicon?.fix},
            ];
        },
        crawlCheckItems() {
            const p=this.result?.on_page; if(!p) return [];
            return [
                {key:'canonical',label:'Canonical Tag',status:p.canonical?.status,message:p.canonical?.message,fix:p.canonical?.fix},
                {key:'robots_txt',label:'robots.txt',status:p.robots_txt?.status,message:p.robots_txt?.message,fix:p.robots_txt?.fix},
                {key:'sitemap',label:'XML Sitemap',status:p.sitemap?.status,message:p.sitemap?.message,fix:p.sitemap?.fix},
                {key:'schema',label:'Schema Markup',status:p.schema?.status,message:p.schema?.message,fix:p.schema?.fix},
                {key:'amp',label:'AMP Support',status:p.amp?.status,message:p.amp?.message,fix:p.amp?.fix},
                {key:'deprecated_html',label:'Deprecated HTML',status:p.deprecated_html?.status,message:p.deprecated_html?.message,fix:p.deprecated_html?.fix},
                {key:'inline_styles',label:'Inline Styles',status:p.inline_styles?.status,message:p.inline_styles?.message,fix:p.inline_styles?.fix},
            ];
        },

        socialProfileItems() {
            const sl = this.result?.on_page?.social_links || {};
            return [
                {key:'facebook',  name:'Facebook',  icon:'ri-facebook-fill',   color:'#1877F2', url:sl.facebook  },
                {key:'twitter',   name:'X (Twitter)',icon:'ri-twitter-x-fill',  color:'#000000', url:sl.twitter   },
                {key:'linkedin',  name:'LinkedIn',  icon:'ri-linkedin-fill',   color:'#0A66C2', url:sl.linkedin  },
                {key:'instagram', name:'Instagram', icon:'ri-instagram-fill',  color:'#E1306C', url:sl.instagram },
                {key:'youtube',   name:'YouTube',   icon:'ri-youtube-fill',    color:'#FF0000', url:sl.youtube   },
            ];
        },
    };
}
</script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
.audit-wrap { min-height: 60vh; }

/* ── Input bar ── */
.audit-input-bar { background:var(--fg-surface); border-bottom:1px solid var(--fg-border); padding:1.75rem 0; position:sticky; top:66px; z-index:50; backdrop-filter:blur(16px); }
.audit-form { display:flex; gap:.75rem; align-items:stretch; }
.audit-form__field { position:relative; flex:1; }
.audit-form__icon { position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:var(--fg-text-muted); font-size:1.1rem; pointer-events:none; }
.audit-form__input { width:100%; height:100%; min-height:48px; padding:.7rem 1rem .7rem 2.75rem; border-radius:10px; background:var(--fg-body); border:1.5px solid var(--fg-border); color:var(--fg-heading); font-size:.95rem; outline:none; box-sizing:border-box; transition:border-color .2s; font-family:inherit; }
.audit-form__input:focus { border-color:#FF6400; }
.audit-form__btn { height:48px; white-space:nowrap; flex-shrink:0; }
.audit-form__btn:disabled { opacity:.6; cursor:not-allowed; transform:none !important; }
.audit-form__hint { font-size:.8rem; color:var(--fg-text-muted); margin-top:.75rem; }
@media(max-width:640px){ .audit-form{flex-direction:column;} .audit-form__btn{width:100%;justify-content:center;} }

/* ── Loading ── */
.audit-loading-steps { display:flex; flex-direction:column; gap:.6rem; margin:2rem auto 0; max-width:340px; }
.audit-step { display:flex; align-items:center; gap:.65rem; font-size:.88rem; color:var(--fg-text-muted); }
.audit-step--done { color:#10B981; }
.audit-step--active { color:var(--fg-heading); font-weight:600; }

/* ── Grade header ── */
.ar-header { background:linear-gradient(135deg,#0a0915 0%,#141228 100%); border-bottom:1px solid rgba(255,255,255,.06); padding:2.5rem 0 2rem; }
.ar-header-top { display:grid; grid-template-columns:auto 1fr; gap:2.5rem; align-items:center; margin-bottom:2rem; }
@media(max-width:700px){ .ar-header-top{grid-template-columns:1fr;gap:1.5rem;} }

.ar-speedo-wrap { text-align:center; flex-shrink:0; position:relative; }
.ar-speedo-svg { width:200px; display:block; margin:0 auto; }
.ar-speedo-grade { font-family:'Clash Display',sans-serif; font-size:1.6rem; font-weight:800; text-align:center; margin-top:-.5rem; }

.ar-header-info { min-width:0; }
.ar-site-url { display:flex; align-items:center; gap:.5rem; font-size:.95rem; font-weight:700; color:#fff; word-break:break-all; margin-bottom:.25rem; }
.ar-site-time { font-size:.74rem; color:rgba(255,255,255,.32); margin-bottom:.75rem; }
.ar-header-actions { display:flex; align-items:center; gap:.6rem; flex-wrap:wrap; margin-bottom:.75rem; }
.ar-badges { display:flex; gap:.35rem; flex-wrap:wrap; }
.ar-badge { display:inline-flex; align-items:center; gap:.3rem; padding:.18rem .6rem; border-radius:99px; font-size:.68rem; font-weight:700; border:1px solid; }
.ar-badge--fail { background:rgba(239,68,68,.12); color:#EF4444; border-color:rgba(239,68,68,.28); }
.ar-badge--warn { background:rgba(245,158,11,.12); color:#F59E0B; border-color:rgba(245,158,11,.28); }
.ar-badge--pass { background:rgba(16,185,129,.12); color:#10B981; border-color:rgba(16,185,129,.28); }
.ar-reanalyze-btn { display:inline-flex; align-items:center; gap:.3rem; padding:.22rem .75rem; border-radius:99px; font-size:.7rem; font-weight:700; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.14); color:rgba(255,255,255,.55); cursor:pointer; transition:all .2s; }
.ar-reanalyze-btn:hover { background:rgba(255,100,0,.15); border-color:rgba(255,100,0,.38); color:#FF6400; }

.ar-page-stats { display:flex; gap:1rem; flex-wrap:wrap; }
.ar-page-stat { display:inline-flex; align-items:center; gap:.35rem; font-size:.74rem; font-weight:600; color:rgba(255,255,255,.4); background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); padding:.18rem .65rem; border-radius:6px; }
.ar-page-stat i { font-size:.8rem; }

/* Category cards */
.ar-cat-cards { display:grid; grid-template-columns:repeat(4,1fr) 1.5fr; gap:.85rem; }
@media(max-width:1100px){ .ar-cat-cards{grid-template-columns:repeat(3,1fr);} .ar-cat-card--compare{grid-column:1/-1;} }
@media(max-width:640px){ .ar-cat-cards{grid-template-columns:1fr 1fr;} }
@media(max-width:400px){ .ar-cat-cards{grid-template-columns:1fr;} }

.ar-cat-card { background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.07); border-radius:14px; padding:1rem .75rem; text-align:center; transition:border-color .2s; }
.ar-cat-card:hover { border-color:rgba(255,255,255,.15); }
.ar-cat-card__ring-wrap { position:relative; display:inline-block; margin-bottom:.5rem; }
.ar-cat-card__num { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-family:'Clash Display',sans-serif; font-size:.95rem; font-weight:800; }
.ar-cat-card__label { font-size:.62rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:rgba(255,255,255,.35); margin-bottom:.25rem; }
.ar-cat-card__grade { font-family:'Clash Display',sans-serif; font-size:1.1rem; font-weight:800; }
.ar-cat-card--compare { text-align:left; padding:1rem; }
.ar-compare-title { font-size:.62rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:rgba(255,255,255,.3); margin-bottom:.65rem; }
.ar-compare-row { display:grid; grid-template-columns:32px 1fr; gap:.4rem; align-items:center; margin-bottom:.4rem; }
.ar-compare-cat { font-size:.62rem; font-weight:600; color:rgba(255,255,255,.38); }
.ar-compare-bars { display:flex; flex-direction:column; gap:.2rem; }
.ar-cbar-wrap { display:flex; align-items:center; gap:.3rem; color:rgba(255,255,255,.3); }
.ar-cbar-track { flex:1; height:4px; background:rgba(255,255,255,.07); border-radius:99px; overflow:hidden; }
.ar-cbar-fill { height:100%; border-radius:99px; transition:width 1.2s ease .6s; }

/* Notice */
.ar-notice { display:flex; align-items:flex-start; gap:.65rem; padding:.85rem 1.15rem; background:rgba(245,158,11,.07); border:1px solid rgba(245,158,11,.22); border-radius:10px; font-size:.82rem; color:rgba(255,255,255,.55); line-height:1.6; margin-bottom:0; }
.ar-notice i { color:#F59E0B; font-size:1.05rem; flex-shrink:0; margin-top:.1rem; }
.ar-notice strong { color:#F59E0B; }

/* Tabs */
.ar-tabs-wrap { background:var(--fg-surface); border-bottom:1px solid var(--fg-border); position:sticky; top:calc(66px + 96px); z-index:40; }
.ar-tabs { display:flex; gap:0; overflow-x:auto; scrollbar-width:none; }
.ar-tabs::-webkit-scrollbar { display:none; }
.ar-tab { display:inline-flex; align-items:center; gap:.4rem; padding:.85rem 1.35rem; font-size:.83rem; font-weight:600; color:var(--fg-text-muted); border:none; background:none; cursor:pointer; border-bottom:2px solid transparent; transition:all .2s; white-space:nowrap; position:relative; }
.ar-tab:hover { color:var(--fg-heading); }
.ar-tab--active { color:#FF6400; border-bottom-color:#FF6400; }
.ar-tab-badge { display:inline-flex; align-items:center; justify-content:center; width:17px; height:17px; border-radius:50%; font-size:.62rem; font-weight:800; }
.ar-tab-badge--fail { background:#EF4444; color:#fff; }

/* Section head */
.ar-section-head { display:flex; justify-content:space-between; align-items:flex-start; gap:1.5rem; margin-bottom:2rem; flex-wrap:wrap; }
.ar-legend { display:flex; align-items:center; font-size:.73rem; color:var(--fg-text-muted); margin-top:.5rem; }
.ar-legend-dot { width:9px; height:9px; border-radius:50%; display:inline-block; margin-right:.35rem; }

/* Vitals */
.ar-vitals-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; }
@media(max-width:900px){ .ar-vitals-grid{grid-template-columns:1fr 1fr;} }
@media(max-width:500px){ .ar-vitals-grid{grid-template-columns:1fr;} }
.ar-vital-card { background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:14px; padding:1.35rem; }
.ar-vital--good { border-color:rgba(16,185,129,.25); }
.ar-vital--medium { border-color:rgba(245,158,11,.25); }
.ar-vital--poor { border-color:rgba(239,68,68,.25); }
.ar-vital__top { display:flex; justify-content:space-between; align-items:center; gap:.5rem; margin-bottom:.9rem; }
.ar-vital__name { font-size:.74rem; font-weight:600; color:var(--fg-text-muted); }
.ar-pill { padding:.12rem .5rem; border-radius:99px; font-size:.62rem; font-weight:700; border:1px solid; }
.ar-pill--good { background:rgba(16,185,129,.1); color:#10B981; border-color:rgba(16,185,129,.3); }
.ar-pill--medium { background:rgba(245,158,11,.1); color:#F59E0B; border-color:rgba(245,158,11,.3); }
.ar-pill--poor { background:rgba(239,68,68,.1); color:#EF4444; border-color:rgba(239,68,68,.3); }
.ar-pill--na { background:rgba(107,114,128,.1); color:#6B7280; border-color:rgba(107,114,128,.25); }
.ar-vital__val { font-family:'Clash Display',sans-serif; font-size:1.75rem; font-weight:800; color:var(--fg-heading); margin-bottom:.85rem; line-height:1; }
.ar-vital__bar-bg { display:flex; height:6px; border-radius:99px; overflow:hidden; margin-bottom:.3rem; }
.ar-vital__seg { height:100%; }
.ar-vital__ticks { display:flex; justify-content:space-between; font-size:.6rem; color:var(--fg-text-muted); padding:0 2px; margin-bottom:.65rem; }
.ar-vital__desc { font-size:.74rem; color:var(--fg-text-muted); line-height:1.55; margin:0; }

/* SERP Preview */
.ar-serp-card { background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:14px; padding:1.5rem; margin-bottom:1.5rem; }
.ar-serp-card__label { font-size:.72rem; font-weight:700; color:var(--fg-text-muted); text-transform:uppercase; letter-spacing:.08em; margin-bottom:1rem; display:flex; align-items:center; gap:.4rem; }
.ar-serp-preview { background:#fff; border-radius:10px; padding:1.25rem 1.5rem; max-width:600px; }
.ar-serp-url { font-size:.78rem; color:#202124; margin-bottom:.2rem; opacity:.7; }
.ar-serp-title { font-size:1.1rem; font-weight:400; color:#1a0dab; line-height:1.3; margin-bottom:.25rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.ar-serp-desc { font-size:.86rem; color:#4d5156; line-height:1.55; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

/* Meta cards */
.ar-meta-cards { display:flex; flex-direction:column; gap:1rem; margin-bottom:1.5rem; }
.ar-meta-card { background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:14px; padding:1.35rem; transition:border-color .2s; }
.ar-meta-card--pass { border-color:rgba(16,185,129,.22); }
.ar-meta-card--warn { border-color:rgba(245,158,11,.22); }
.ar-meta-card--fail { border-color:rgba(239,68,68,.22); }
.ar-meta-card__head { display:flex; align-items:center; gap:.5rem; margin-bottom:.5rem; font-size:.83rem; font-weight:700; color:var(--fg-heading); }
.ar-meta-len { margin-left:auto; font-size:.7rem; font-weight:600; color:var(--fg-text-muted); background:var(--fg-body); padding:.1rem .5rem; border-radius:5px; }
.ar-meta-val { font-size:.82rem; color:var(--fg-text-muted); margin-bottom:.75rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.ar-meta-msg { font-size:.75rem; font-weight:600; margin-top:.5rem; }
.ar-len-track { position:relative; height:7px; background:var(--fg-border); border-radius:99px; overflow:visible; margin-bottom:.28rem; }
.ar-len-fill { position:absolute; left:0; top:0; height:100%; border-radius:99px; transition:width 1s ease .5s; }
.ar-len-zone { position:absolute; top:-1px; height:9px; background:rgba(16,185,129,.2); border-radius:2px; }
.ar-len-ticks { display:flex; justify-content:space-between; font-size:.6rem; color:var(--fg-text-muted); margin-bottom:.4rem; }

/* Expand cards */
.ar-group-title { font-family:'Syne',sans-serif; font-size:.78rem; font-weight:700; color:var(--fg-text-muted); text-transform:uppercase; letter-spacing:.08em; display:flex; align-items:center; gap:.4rem; margin:0 0 .7rem; padding-bottom:.5rem; border-bottom:1px solid var(--fg-border); }
.ar-checks-list { display:flex; flex-direction:column; gap:.5rem; }
.ar-expand-card { background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:12px; padding:1rem 1.1rem; cursor:pointer; transition:border-color .2s; }
.ar-expand-card--pass { border-color:rgba(16,185,129,.16); }
.ar-expand-card--warn { border-color:rgba(245,158,11,.16); }
.ar-expand-card--fail { border-color:rgba(239,68,68,.16); }
.ar-expand-card:hover { border-color:rgba(255,100,0,.25); }
.ar-expand-card__row { display:flex; align-items:center; gap:.8rem; }
.ar-check-icon { width:30px; height:30px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:.88rem; flex-shrink:0; }
.ar-check-label { font-size:.8rem; font-weight:700; color:var(--fg-heading); margin-bottom:.1rem; }
.ar-check-msg { font-size:.73rem; color:var(--fg-text-muted); margin:0; }
.ar-expand-icon { color:var(--fg-text-muted); font-size:1rem; transition:transform .25s; flex-shrink:0; }
.ar-expand-icon--open { transform:rotate(180deg); }
.ar-fix-box { display:flex; align-items:flex-start; gap:.6rem; margin-top:.85rem; padding:.85rem 1rem; background:rgba(255,100,0,.05); border:1px solid rgba(255,100,0,.15); border-radius:9px; font-size:.78rem; color:var(--fg-text-muted); line-height:1.65; }
.ar-fix-box i { color:#FF6400; font-size:.95rem; flex-shrink:0; margin-top:.05rem; }

/* Heading viz */
.ar-heading-viz { display:flex; flex-direction:column; gap:.5rem; }
.ar-hbox { display:flex; align-items:center; gap:.75rem; padding:.7rem 1rem; border-radius:10px; background:var(--fg-card); border:1px solid var(--fg-card-border); }
.ar-hbox--pass { border-color:rgba(16,185,129,.2); }
.ar-hbox--fail { border-color:rgba(239,68,68,.2); }
.ar-hbox__tag { flex-shrink:0; padding:.15rem .55rem; border-radius:5px; font-size:.7rem; font-weight:800; background:rgba(255,100,0,.12); border:1px solid rgba(255,100,0,.25); color:#FF6400; }
.ar-hbox__text { flex:1; min-width:0; font-size:.82rem; color:var(--fg-heading); font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.ar-hbox__count { font-size:.72rem; font-weight:700; color:var(--fg-text-muted); flex-shrink:0; }

/* Image analysis */
.ar-img-row { display:grid; grid-template-columns:1fr 1fr 1fr 2fr; gap:1rem; align-items:start; }
@media(max-width:768px){ .ar-img-row{grid-template-columns:1fr 1fr;} .ar-img-coverage{grid-column:1/-1;} }
@media(max-width:400px){ .ar-img-row{grid-template-columns:1fr;} }
.ar-img-stat { background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:12px; padding:1.25rem; text-align:center; display:flex; flex-direction:column; align-items:center; gap:.3rem; }
.ar-img-stat__num { font-family:'Clash Display',sans-serif; font-size:2.2rem; font-weight:800; line-height:1; }
.ar-img-stat__lbl { font-size:.7rem; font-weight:600; text-transform:uppercase; letter-spacing:.06em; color:var(--fg-text-muted); }
.ar-img-coverage { background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:12px; padding:1.25rem; }
.ar-cov-bar { height:10px; background:var(--fg-border); border-radius:99px; overflow:hidden; }
.ar-cov-fill { height:100%; background:linear-gradient(90deg,#10B981,#34D399); border-radius:99px; transition:width 1.2s ease .5s; }

/* Links */
.ar-links-row { display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; }
@media(max-width:600px){ .ar-links-row{grid-template-columns:1fr;} }
.ar-link-card { background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:12px; padding:1.5rem; text-align:center; display:flex; flex-direction:column; align-items:center; }
.ar-link-card__num { font-family:'Clash Display',sans-serif; font-size:2rem; font-weight:800; line-height:1; margin-bottom:.25rem; }
.ar-link-card__lbl { font-size:.72rem; font-weight:600; text-transform:uppercase; letter-spacing:.06em; color:var(--fg-text-muted); }

/* Technical summary */
.ar-tech-summary { display:flex; align-items:center; gap:2rem; padding:1.25rem 1.5rem; background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:14px; margin-bottom:2rem; flex-wrap:wrap; }
.ar-tech-sum-item { display:flex; flex-direction:column; align-items:center; gap:.15rem; }
.ar-tech-sum-num { font-family:'Clash Display',sans-serif; font-size:2rem; font-weight:800; line-height:1; }
.ar-tech-sum-lbl { font-size:.7rem; font-weight:600; text-transform:uppercase; letter-spacing:.06em; color:var(--fg-text-muted); }

/* Performance tab */
.ar-perf-hero { display:grid; grid-template-columns:1fr 1fr 1fr; gap:1.5rem; align-items:start; margin-bottom:1rem; }
@media(max-width:900px){ .ar-perf-hero{grid-template-columns:1fr 1fr;} }
@media(max-width:600px){ .ar-perf-hero{grid-template-columns:1fr;} }
.ar-speed-dial { background:linear-gradient(135deg,#0a0915,#141228); border:1px solid rgba(255,255,255,.08); border-radius:16px; padding:1.5rem 1rem 1rem; text-align:center; }
.ar-speed-dial__label { font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:rgba(255,255,255,.35); margin-bottom:.5rem; }
.ar-speed-dial__svg { width:100%; max-width:220px; display:block; margin:0 auto; }
.ar-speed-dial__grade { font-family:'Clash Display',sans-serif; font-size:1.4rem; font-weight:800; margin-top:-.25rem; }
.ar-perf-stats { background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:16px; padding:1.5rem; }
.ar-perf-stats__title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--fg-text-muted); margin-bottom:1rem; }
.ar-perf-stat-list { display:flex; flex-direction:column; gap:.85rem; }
.ar-perf-stat-item { display:flex; align-items:center; gap:.75rem; }
.ar-perf-stat-item i { font-size:1.3rem; flex-shrink:0; }
.ar-perf-stat-val { font-family:'Clash Display',sans-serif; font-size:1.1rem; font-weight:800; color:var(--fg-heading); line-height:1; margin-bottom:.1rem; }
.ar-perf-stat-lbl { font-size:.68rem; font-weight:600; text-transform:uppercase; letter-spacing:.05em; color:var(--fg-text-muted); }

/* Opportunities */
.ar-empty-opp { padding:2.5rem; text-align:center; background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:14px; margin-bottom:1.5rem; }
.ar-opp-list { display:flex; flex-direction:column; gap:.6rem; margin-bottom:1.5rem; }
.ar-opp-card { background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:13px; padding:1.1rem; cursor:pointer; transition:border-color .2s; }
.ar-opp-card:hover { border-color:rgba(255,100,0,.25); }
.ar-opp-card__head { display:flex; align-items:flex-start; gap:.75rem; margin-bottom:.6rem; }
.ar-opp-icon { width:34px; height:34px; border-radius:9px; border:1px solid; display:flex; align-items:center; justify-content:center; font-size:.9rem; flex-shrink:0; }
.ar-opp-title { font-size:.82rem; font-weight:700; color:var(--fg-heading); margin:0; }
.ar-opp-save { font-size:.7rem; font-weight:700; color:#10B981; background:rgba(16,185,129,.1); padding:.08rem .45rem; border-radius:99px; }
.ar-opp-pill { font-size:.67rem; font-weight:700; padding:.08rem .45rem; border-radius:99px; border:1px solid; }
.ar-opp-bar-bg { height:3px; background:var(--fg-border); border-radius:99px; overflow:hidden; margin-bottom:0; }
.ar-opp-bar-fill { height:100%; border-radius:99px; transition:width 1s ease .5s; }

/* CTA */
.ar-cta-box { background:linear-gradient(135deg,rgba(255,100,0,.08),rgba(255,100,0,.03)); border:1px solid rgba(255,100,0,.2); border-radius:16px; padding:2rem; text-align:center; margin-top:2rem; }
.ar-cta-icon { width:52px; height:52px; border-radius:13px; background:rgba(255,100,0,.1); border:1px solid rgba(255,100,0,.2); display:flex; align-items:center; justify-content:center; font-size:1.4rem; color:#FF6400; margin:0 auto 1rem; }
.ar-cta-title { font-family:'Syne',sans-serif; font-weight:700; color:var(--fg-heading); margin-bottom:.4rem; font-size:1.05rem; }
.ar-cta-text { color:var(--fg-text-muted); font-size:.86rem; line-height:1.7; margin-bottom:1.4rem; }

/* ── Keyword Table ── */
.ar-kw-card { background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:14px; padding:1.25rem 1.5rem; }
.ar-kw-status-row { display:flex; align-items:center; gap:.75rem; margin-bottom:1rem; }
.ar-kw-table-wrap { overflow-x:auto; margin-bottom:.5rem; }
.ar-kw-table { width:100%; border-collapse:collapse; font-size:.8rem; }
.ar-kw-table th { padding:.5rem .75rem; text-align:left; font-size:.66rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:var(--fg-text-muted); border-bottom:1px solid var(--fg-border); white-space:nowrap; }
.ar-kw-table td { padding:.55rem .75rem; border-bottom:1px solid rgba(255,255,255,.04); color:var(--fg-text-muted); vertical-align:middle; }
.ar-kw-table tr:last-child td { border-bottom:none; }
.ar-kw-table tr:hover td { background:rgba(255,255,255,.02); }
.ar-kw-table td:first-child { font-weight:600; color:var(--fg-heading); text-transform:capitalize; }

/* ── Social Profiles ── */
.ar-social-profiles { display:flex; flex-direction:column; gap:.5rem; }
.ar-social-profile { display:flex; align-items:center; gap:.85rem; padding:.9rem 1.1rem; border-radius:12px; border:1px solid; transition:border-color .2s; cursor:pointer; text-decoration:none; }
.ar-social-profile--found { background:var(--fg-card); border-color:rgba(255,255,255,.1); }
.ar-social-profile--found:hover { border-color:rgba(255,255,255,.2); }
.ar-social-profile--missing { background:rgba(255,255,255,.02); border-color:rgba(255,255,255,.05); }
.ar-sp-name { font-size:.82rem; font-weight:700; color:var(--fg-heading); margin:0 0 .1rem; }
.ar-sp-url { font-size:.72rem; color:var(--fg-text-muted); margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:280px; }
.ar-sp-badge { flex-shrink:0; font-size:.65rem; font-weight:700; padding:.12rem .55rem; border-radius:99px; border:1px solid; }
.ar-sp-badge--found { background:rgba(16,185,129,.1); color:#10B981; border-color:rgba(16,185,129,.25); }
.ar-sp-badge--missing { background:rgba(255,255,255,.04); color:var(--fg-text-muted); border-color:rgba(255,255,255,.08); }

/* ── Technology Grid ── */
.ar-tech-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:.65rem; }
@media(max-width:768px){ .ar-tech-grid{grid-template-columns:1fr 1fr;} }
@media(max-width:480px){ .ar-tech-grid{grid-template-columns:1fr;} }
.ar-tech-item { display:flex; align-items:center; gap:.65rem; padding:.85rem 1rem; background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:10px; }
.ar-tech-name { font-size:.8rem; font-weight:700; color:var(--fg-heading); margin:0 0 .1rem; }
.ar-tech-cat { font-size:.67rem; color:var(--fg-text-muted); margin:0; }

/* ── Server Info Grid ── */
.ar-server-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:.65rem; }
@media(max-width:900px){ .ar-server-grid{grid-template-columns:1fr 1fr;} }
@media(max-width:480px){ .ar-server-grid{grid-template-columns:1fr;} }
.ar-server-item { padding:.9rem 1rem; background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:10px; }
.ar-server-lbl { display:block; font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--fg-text-muted); margin-bottom:.3rem; }
.ar-server-val { font-size:.85rem; font-weight:600; color:var(--fg-heading); font-family:'Clash Display',sans-serif; }
code.ar-server-val { font-family:monospace; font-size:.8rem; }

/* ── Radar / Spider Chart ── */
.ar-radar-section { background:var(--fg-card); border:1px solid var(--fg-card-border); border-radius:18px; padding:2rem; margin-bottom:3rem; }
.ar-radar-header { display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:1.75rem; flex-wrap:wrap; }
.ar-radar-badge { text-align:center; flex-shrink:0; }
.ar-radar-badge-num { font-family:'Clash Display',sans-serif; font-size:3rem; font-weight:800; line-height:1; display:block; }
.ar-radar-badge-lbl { font-size:.64rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--fg-text-muted); display:block; margin-top:.2rem; }
.ar-radar-body { display:grid; grid-template-columns:270px 1fr; gap:3rem; align-items:center; }
@media(max-width:800px){ .ar-radar-body { grid-template-columns:1fr; } }
.ar-radar-chart-wrap { display:flex; justify-content:center; }
.ar-radar-svg { width:100%; max-width:270px; display:block; }
.ar-radar-scores-grid { display:flex; flex-direction:column; gap:1.1rem; }
.ar-radar-score-top { display:flex; justify-content:space-between; align-items:center; margin-bottom:.3rem; }
.ar-radar-score-label { font-size:.8rem; font-weight:600; color:var(--fg-heading); }
.ar-radar-score-val { font-size:.8rem; font-weight:700; }
.ar-radar-bar-bg { height:6px; background:var(--fg-border); border-radius:99px; overflow:hidden; }
.ar-radar-bar-fill { height:100%; border-radius:99px; }
</style>

</x-layouts.frontend>
