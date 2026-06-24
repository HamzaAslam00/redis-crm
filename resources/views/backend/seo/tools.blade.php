<x-layouts.backend title="SEO Tools">

    <x-backend.page-header title="SEO Tools" description="Sitemap, robots.txt, and technical utilities">
        <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary"><i class="ri-arrow-left-line"></i> SEO Dashboard</a>
    </x-backend.page-header>

    <x-backend.breadcrumb :items="[
        'SEO Management' => route('admin.seo.index'),
        'Tools' => null,
    ]" />

    @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:8px;padding:0.75rem 1rem;margin-bottom:1.25rem;color:#16a34a;font-size:0.88rem">
            <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start">

        {{-- Sitemap --}}
        <div class="crm-card">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
                <div style="width:40px;height:40px;background:#FF640015;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="ri-sitemap-line" style="font-size:1.25rem;color:#FF6400"></i>
                </div>
                <div>
                    <h3 style="font-size:0.95rem;font-weight:700;margin:0">XML Sitemap</h3>
                    <div style="font-size:0.78rem;color:var(--crm-text-muted)">Auto-submitted to search engines</div>
                </div>
            </div>

            @php $sitemapExists = file_exists(public_path('sitemap.xml')); @endphp
            <div style="background:var(--crm-bg);border-radius:6px;padding:0.75rem 1rem;margin-bottom:1.25rem;font-size:0.85rem">
                <div style="display:flex;justify-content:space-between;margin-bottom:0.4rem">
                    <span style="color:var(--crm-text-muted)">Status</span>
                    <span style="font-weight:600;color:{{ $sitemapExists ? '#22c55e' : '#ef4444' }}">
                        {{ $sitemapExists ? '✓ Found' : '✗ Not found' }}
                    </span>
                </div>
                @if($sitemapExists)
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.4rem">
                        <span style="color:var(--crm-text-muted)">Last modified</span>
                        <span>{{ date('d M Y H:i', filemtime(public_path('sitemap.xml'))) }}</span>
                    </div>
                @endif
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--crm-text-muted)">URL</span>
                    <a href="{{ url('sitemap.xml') }}" target="_blank" style="color:#FF6400;font-size:0.78rem">{{ url('sitemap.xml') }}</a>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.seo.tools.sitemap') }}">
                @csrf
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center" data-loading-text="Generating…">
                    <i class="ri-refresh-line"></i> Regenerate Sitemap
                </button>
            </form>

            <div style="font-size:0.73rem;color:var(--crm-text-muted);margin-top:0.75rem">
                Generates <code>public/sitemap.xml</code> from all public routes. Submit your sitemap URL to
                <a href="https://search.google.com/search-console" target="_blank" style="color:#FF6400">Google Search Console</a>.
            </div>
        </div>

        {{-- Robots.txt --}}
        <div class="crm-card">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
                <div style="width:40px;height:40px;background:#FF640015;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="ri-robot-line" style="font-size:1.25rem;color:#FF6400"></i>
                </div>
                <div>
                    <h3 style="font-size:0.95rem;font-weight:700;margin:0">robots.txt</h3>
                    <div style="font-size:0.78rem;color:var(--crm-text-muted)">Controls crawler access to your site</div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.seo.tools.robots') }}">
                @csrf
                <div class="form-group">
                    <textarea name="robots_txt" class="form-control" rows="12"
                        style="font-family:monospace;font-size:0.82rem;line-height:1.6">{{ $robotsTxt }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center" data-loading-text="Saving…">
                    <i class="ri-save-line"></i> Save robots.txt
                </button>
            </form>

            <div style="font-size:0.73rem;color:var(--crm-text-muted);margin-top:0.75rem">
                File saved to <code>public/robots.txt</code>. View live at
                <a href="{{ url('robots.txt') }}" target="_blank" style="color:#FF6400">{{ url('robots.txt') }}</a>
            </div>
        </div>

        {{-- Useful Links --}}
        <div class="crm-card">
            <h3 style="font-size:0.85rem;font-weight:700;margin:0 0 1rem">Useful SEO Tools</h3>
            <div style="display:flex;flex-direction:column;gap:0.5rem">
                @foreach([
                    ['Google Search Console', 'https://search.google.com/search-console', 'ri-google-line'],
                    ['Google PageSpeed Insights', 'https://pagespeed.web.dev', 'ri-speed-line'],
                    ['Schema Markup Validator', 'https://validator.schema.org', 'ri-code-s-slash-line'],
                    ['Open Graph Debugger', 'https://developers.facebook.com/tools/debug', 'ri-facebook-line'],
                    ['Twitter Card Validator', 'https://cards-dev.twitter.com/validator', 'ri-twitter-x-line'],
                    ['Ahrefs Backlink Checker', 'https://ahrefs.com/backlink-checker', 'ri-links-line'],
                ] as [$name, $url, $icon])
                    <a href="{{ $url }}" target="_blank"
                        style="display:flex;align-items:center;gap:0.6rem;padding:0.5rem 0.75rem;border:1px solid var(--crm-border);border-radius:6px;text-decoration:none;color:var(--crm-text);font-size:0.83rem;transition:border-color 0.15s"
                        onmouseover="this.style.borderColor='#FF6400'" onmouseout="this.style.borderColor='var(--crm-border)'">
                        <i class="{{ $icon }}" style="color:#FF6400;width:18px"></i>
                        {{ $name }}
                        <i class="ri-external-link-line" style="margin-left:auto;color:var(--crm-text-muted);font-size:0.78rem"></i>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Meta Tag Reference --}}
        <div class="crm-card">
            <h3 style="font-size:0.85rem;font-weight:700;margin:0 0 1rem">SEO Quick Reference</h3>
            <div style="display:flex;flex-direction:column;gap:0.6rem;font-size:0.82rem">
                @foreach([
                    ['Meta Title',       '30–60 chars', '#22c55e'],
                    ['Meta Description', '120–160 chars', '#22c55e'],
                    ['OG Image',         '1200×630px recommended', '#f59e0b'],
                    ['Twitter Card',     'summary_large_image for best display', '#f59e0b'],
                    ['Canonical URL',    'Set when page has duplicate content', '#6b7280'],
                    ['noindex',          'Only for pages you DON\'T want indexed', '#ef4444'],
                    ['Schema JSON-LD',   'Helps Google understand your content', '#22c55e'],
                ] as [$tag, $tip, $color])
                    <div style="display:flex;gap:0.75rem;padding:0.4rem 0;border-bottom:1px solid var(--crm-border)">
                        <span style="font-weight:700;min-width:130px;color:{{ $color }}">{{ $tag }}</span>
                        <span style="color:var(--crm-text-muted)">{{ $tip }}</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</x-layouts.backend>
