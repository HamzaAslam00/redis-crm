<x-layouts.backend title="SEO Management">

    <x-backend.page-header title="SEO Management" description="Manage meta tags, keywords, backlinks, and technical SEO for your website">
        <div style="display:flex;gap:0.5rem">
            <a href="{{ route('admin.seo.audit-logs') }}" class="btn btn-secondary"><i class="ri-radar-line"></i> Audit Logs</a>
            <a href="{{ route('admin.seo.tools') }}" class="btn btn-secondary"><i class="ri-tools-line"></i> Tools</a>
            <a href="{{ route('admin.seo.keywords') }}" class="btn btn-secondary"><i class="ri-price-tag-3-line"></i> Keywords</a>
            <a href="{{ route('admin.seo.backlinks') }}" class="btn btn-secondary"><i class="ri-links-line"></i> Backlinks</a>
        </div>
    </x-backend.page-header>

    <x-backend.breadcrumb :items="[['label' => 'SEO Management']]" />

    @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:8px;padding:0.75rem 1rem;margin-bottom:1.25rem;color:#16a34a;font-size:0.88rem">
            <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Stat Cards --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem">
        <div class="crm-card" style="text-align:center;padding:1.25rem">
            <div style="font-size:2rem;font-weight:800;color:#FF6400">{{ $pages->count() }}</div>
            <div style="font-size:0.78rem;color:var(--crm-text-muted);margin-top:3px;text-transform:uppercase;letter-spacing:0.05em">Pages Managed</div>
        </div>
        <div class="crm-card" style="text-align:center;padding:1.25rem">
            <div style="font-size:2rem;font-weight:800;color:{{ $avgScore >= 75 ? '#22c55e' : ($avgScore >= 40 ? '#f59e0b' : '#ef4444') }}">{{ $avgScore }}%</div>
            <div style="font-size:0.78rem;color:var(--crm-text-muted);margin-top:3px;text-transform:uppercase;letter-spacing:0.05em">Avg SEO Score</div>
        </div>
        <div class="crm-card" style="text-align:center;padding:1.25rem">
            <div style="font-size:2rem;font-weight:800;color:{{ $issues > 0 ? '#ef4444' : '#22c55e' }}">{{ $issues }}</div>
            <div style="font-size:0.78rem;color:var(--crm-text-muted);margin-top:3px;text-transform:uppercase;letter-spacing:0.05em">Total Issues</div>
        </div>
        <div class="crm-card" style="text-align:center;padding:1.25rem">
            <div style="font-size:2rem;font-weight:800;color:#FF6400">{{ $keywords }}</div>
            <div style="font-size:0.78rem;color:var(--crm-text-muted);margin-top:3px;text-transform:uppercase;letter-spacing:0.05em">Keywords Tracked</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">

        {{-- Pages Health Grid --}}
        <div class="crm-card" style="padding:0;overflow:hidden">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid var(--crm-border);display:flex;align-items:center;justify-content:space-between">
                <h3 style="font-size:0.95rem;font-weight:700;margin:0">Pages SEO Health</h3>
                <span style="font-size:0.78rem;color:var(--crm-text-muted)">Click a page to edit its meta</span>
            </div>
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Page</th>
                        <th style="width:180px">Meta Title</th>
                        <th style="width:80px;text-align:center">Score</th>
                        <th style="width:80px;text-align:center">Index</th>
                        <th style="width:60px">Issues</th>
                        <th style="width:60px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        @php $score = $page->healthScore(); $issues = $page->issues(); @endphp
                        <tr>
                            <td>
                                <div style="font-weight:600;font-size:0.88rem">{{ $page->page_label }}</div>
                                <div style="font-size:0.75rem;color:var(--crm-text-muted);font-family:monospace">{{ $page->route_name }}</div>
                            </td>
                            <td>
                                @if($page->meta_title)
                                    <div style="font-size:0.82rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:160px" title="{{ $page->meta_title }}">
                                        {{ $page->meta_title }}
                                    </div>
                                    <div style="font-size:0.72rem;color:{{ strlen($page->meta_title) > 60 ? '#ef4444' : (strlen($page->meta_title) < 30 ? '#f59e0b' : '#22c55e') }}">
                                        {{ strlen($page->meta_title) }} chars
                                    </div>
                                @else
                                    <span style="font-size:0.78rem;color:#ef4444"><i class="ri-alert-line"></i> Missing</span>
                                @endif
                            </td>
                            <td style="text-align:center">
                                <div style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;border:2.5px solid {{ $page->healthColor() }};font-size:0.72rem;font-weight:700;color:{{ $page->healthColor() }}">
                                    {{ $score }}
                                </div>
                            </td>
                            <td style="text-align:center">
                                @if($page->noindex)
                                    <span style="font-size:0.72rem;background:#fef2f2;color:#ef4444;padding:2px 7px;border-radius:20px;font-weight:600">NOINDEX</span>
                                @else
                                    <span style="font-size:0.72rem;background:#f0fdf4;color:#22c55e;padding:2px 7px;border-radius:20px;font-weight:600">Index</span>
                                @endif
                            </td>
                            <td>
                                @if(count($issues) > 0)
                                    <span style="font-size:0.78rem;color:#ef4444;font-weight:700">{{ count($issues) }}</span>
                                @else
                                    <i class="ri-checkbox-circle-line" style="color:#22c55e"></i>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.seo.pages.edit', $page) }}" class="btn btn-sm" style="padding:0.3rem 0.6rem;font-size:0.8rem">
                                    <i class="ri-edit-line"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">

            {{-- Backlinks Summary --}}
            <div class="crm-card">
                <h3 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--crm-text-muted);margin:0 0 1rem">Backlinks</h3>
                <div style="display:flex;flex-direction:column;gap:0.6rem;font-size:0.85rem">
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:var(--crm-text-muted)">Total tracked</span>
                        <span style="font-weight:700">{{ $backlinks }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:var(--crm-text-muted)">Active</span>
                        <span style="font-weight:700;color:#22c55e">{{ $activeLinks }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.seo.backlinks') }}" class="btn btn-secondary" style="width:100%;justify-content:center;margin-top:1rem;font-size:0.82rem">
                    Manage Backlinks
                </a>
            </div>

            {{-- Quick Links --}}
            <div class="crm-card">
                <h3 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--crm-text-muted);margin:0 0 1rem">Quick Actions</h3>
                <div style="display:flex;flex-direction:column;gap:0.5rem">
                    <a href="{{ route('admin.seo.keywords') }}" class="btn btn-secondary" style="justify-content:flex-start;font-size:0.82rem">
                        <i class="ri-price-tag-3-line"></i> Keywords ({{ $keywords }})
                    </a>
                    <a href="{{ route('admin.seo.tools') }}" class="btn btn-secondary" style="justify-content:flex-start;font-size:0.82rem">
                        <i class="ri-tools-line"></i> Sitemap & Robots.txt
                    </a>
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-secondary" style="justify-content:flex-start;font-size:0.82rem">
                        <i class="ri-external-link-line"></i> View Website
                    </a>
                </div>
            </div>

            {{-- SEO Checklist --}}
            <div class="crm-card">
                <h3 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--crm-text-muted);margin:0 0 1rem">SEO Checklist</h3>
                @php
                    $allHaveTitles = $pages->every(fn($p) => $p->meta_title);
                    $allHaveDesc   = $pages->every(fn($p) => $p->meta_description);
                    $allHaveOg     = $pages->every(fn($p) => $p->og_image);
                    $robotsExists  = file_exists(public_path('robots.txt'));
                    $sitemapExists = file_exists(public_path('sitemap.xml'));
                @endphp
                @foreach([
                    [$allHaveTitles,  'All pages have title tags'],
                    [$allHaveDesc,    'All pages have meta descriptions'],
                    [$allHaveOg,      'All pages have OG images'],
                    [$robotsExists,   'robots.txt exists'],
                    [$sitemapExists,  'sitemap.xml exists'],
                    [$keywords > 0,   'Keywords tracked'],
                    [$backlinks > 0,  'Backlinks logged'],
                ] as [$ok, $label])
                    <div style="display:flex;align-items:center;gap:0.5rem;padding:0.35rem 0;border-bottom:1px solid var(--crm-border);font-size:0.82rem">
                        <i class="{{ $ok ? 'ri-checkbox-circle-fill' : 'ri-close-circle-line' }}" style="color:{{ $ok ? '#22c55e' : '#ef4444' }};font-size:1rem;flex-shrink:0"></i>
                        <span style="{{ $ok ? '' : 'color:var(--crm-text-muted)' }}">{{ $label }}</span>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

</x-layouts.backend>
