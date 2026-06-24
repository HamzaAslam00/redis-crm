<x-layouts.backend title="Edit SEO — {{ $seoPage->page_label }}">

    <x-backend.page-header title="Edit SEO: {{ $seoPage->page_label }}" subtitle="Route: {{ $seoPage->route_name }}">
        <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary"><i class="ri-arrow-left-line"></i> Back</a>
    </x-backend.page-header>

    <x-backend.breadcrumb :items="[
        'SEO Management' => route('admin.seo.index'),
        $seoPage->page_label => null,
    ]" />

    @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:8px;padding:0.75rem 1rem;margin-bottom:1.25rem;color:#16a34a;font-size:0.88rem">
            <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;padding:0.75rem 1rem;margin-bottom:1.25rem">
            <strong style="color:#dc2626;font-size:0.88rem">Please fix:</strong>
            <ul style="margin:0.3rem 0 0 1.2rem;font-size:0.82rem;color:#dc2626">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.seo.pages.update', $seoPage) }}">
        @csrf @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">

            {{-- Main fields --}}
            <div style="display:flex;flex-direction:column;gap:1.25rem">

                {{-- Core Meta --}}
                <div class="crm-card">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:#FF6400;margin:0 0 1.25rem;padding-bottom:0.5rem;border-bottom:1.5px solid #FF6400">
                        Core Meta Tags
                    </h3>

                    <div class="form-group">
                        <label class="form-label">
                            Meta Title
                            <span id="title-count" style="font-weight:400;color:var(--crm-text-muted);margin-left:6px;font-size:0.78rem">
                                ({{ strlen(old('meta_title', $seoPage->meta_title ?? '')) }}/60)
                            </span>
                        </label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control"
                            value="{{ old('meta_title', $seoPage->meta_title) }}"
                            maxlength="70" placeholder="e.g. Redis Solution — Web Development Company Pakistan"
                            oninput="updateCount('meta_title','title-count',60,'title-bar')">
                        <div style="height:4px;background:var(--crm-border);border-radius:2px;margin-top:6px">
                            <div id="title-bar" style="height:4px;border-radius:2px;transition:width 0.2s,background 0.2s;width:{{ min(100, strlen(old('meta_title', $seoPage->meta_title ?? '')) / 60 * 100) }}%;background:{{ strlen(old('meta_title', $seoPage->meta_title ?? '')) > 60 ? '#ef4444' : (strlen(old('meta_title', $seoPage->meta_title ?? '')) < 30 ? '#f59e0b' : '#22c55e') }}"></div>
                        </div>
                        <div style="font-size:0.73rem;color:var(--crm-text-muted);margin-top:4px">Optimal: 30–60 characters. Shown in Google search results.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Meta Description
                            <span id="desc-count" style="font-weight:400;color:var(--crm-text-muted);margin-left:6px;font-size:0.78rem">
                                ({{ strlen(old('meta_description', $seoPage->meta_description ?? '')) }}/160)
                            </span>
                        </label>
                        <textarea name="meta_description" id="meta_description" class="form-control" rows="3"
                            maxlength="170" placeholder="Concise description of this page shown in Google results..."
                            oninput="updateCount('meta_description','desc-count',160,'desc-bar')">{{ old('meta_description', $seoPage->meta_description) }}</textarea>
                        <div style="height:4px;background:var(--crm-border);border-radius:2px;margin-top:6px">
                            <div id="desc-bar" style="height:4px;border-radius:2px;transition:width 0.2s,background 0.2s;width:{{ min(100, strlen(old('meta_description', $seoPage->meta_description ?? '')) / 160 * 100) }}%;background:{{ strlen(old('meta_description', $seoPage->meta_description ?? '')) > 160 ? '#ef4444' : (strlen(old('meta_description', $seoPage->meta_description ?? '')) < 120 ? '#f59e0b' : '#22c55e') }}"></div>
                        </div>
                        <div style="font-size:0.73rem;color:var(--crm-text-muted);margin-top:4px">Optimal: 120–160 characters. Shown in Google search results.</div>
                    </div>

                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Keywords <span style="font-weight:400;color:var(--crm-text-muted)">(comma separated)</span></label>
                        <input type="text" name="meta_keywords" class="form-control"
                            value="{{ old('meta_keywords', $seoPage->meta_keywords) }}"
                            placeholder="web development, laravel, pakistan, redis solution">
                        <div style="font-size:0.73rem;color:var(--crm-text-muted);margin-top:4px">Meta keywords are not used by Google but help some search engines.</div>
                    </div>
                </div>

                {{-- Open Graph --}}
                <div class="crm-card">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:#FF6400;margin:0 0 1.25rem;padding-bottom:0.5rem;border-bottom:1.5px solid #FF6400">
                        Open Graph <span style="font-weight:400;font-size:0.75rem;color:var(--crm-text-muted)">(Facebook, WhatsApp, LinkedIn previews)</span>
                    </h3>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                        <div class="form-group">
                            <label class="form-label">OG Title <span style="font-weight:400;color:var(--crm-text-muted)">(leave blank to use meta title)</span></label>
                            <input type="text" name="og_title" class="form-control"
                                value="{{ old('og_title', $seoPage->og_title) }}"
                                placeholder="Same as meta title if empty">
                        </div>
                        <div class="form-group">
                            <label class="form-label">OG Type</label>
                            <select name="og_type" class="form-control">
                                @foreach(['website' => 'Website', 'article' => 'Article', 'profile' => 'Profile', 'product' => 'Product'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('og_type', $seoPage->og_type) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">OG Description <span style="font-weight:400;color:var(--crm-text-muted)">(leave blank to use meta description)</span></label>
                        <textarea name="og_description" class="form-control" rows="2"
                            placeholder="Same as meta description if empty">{{ old('og_description', $seoPage->og_description) }}</textarea>
                    </div>

                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">OG Image Path <span style="font-weight:400;color:var(--crm-text-muted)">(relative to public/, e.g. assets/og/home.jpg — 1200×630px recommended)</span></label>
                        <input type="text" name="og_image" class="form-control"
                            value="{{ old('og_image', $seoPage->og_image) }}"
                            placeholder="assets/og/home.jpg">
                        @if($seoPage->og_image)
                            <div style="margin-top:8px">
                                <img src="{{ asset($seoPage->og_image) }}" style="max-width:260px;border-radius:6px;border:1px solid var(--crm-border)" onerror="this.style.display='none'">
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Twitter Card --}}
                <div class="crm-card">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:#FF6400;margin:0 0 1.25rem;padding-bottom:0.5rem;border-bottom:1.5px solid #FF6400">
                        Twitter / X Card
                    </h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                        <div class="form-group">
                            <label class="form-label">Card Type</label>
                            <select name="twitter_card" class="form-control">
                                @foreach(['summary_large_image' => 'Summary Large Image', 'summary' => 'Summary', 'app' => 'App', 'player' => 'Player'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('twitter_card', $seoPage->twitter_card) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Twitter Title <span style="font-weight:400;color:var(--crm-text-muted)">(or OG title)</span></label>
                            <input type="text" name="twitter_title" class="form-control"
                                value="{{ old('twitter_title', $seoPage->twitter_title) }}"
                                placeholder="Falls back to OG title">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Twitter Description <span style="font-weight:400;color:var(--crm-text-muted)">(or OG description)</span></label>
                        <textarea name="twitter_description" class="form-control" rows="2"
                            placeholder="Falls back to OG description">{{ old('twitter_description', $seoPage->twitter_description) }}</textarea>
                    </div>
                </div>

                {{-- Schema / JSON-LD --}}
                <div class="crm-card">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:#FF6400;margin:0 0 1.25rem;padding-bottom:0.5rem;border-bottom:1.5px solid #FF6400">
                        Structured Data <span style="font-weight:400;font-size:0.75rem;color:var(--crm-text-muted)">(JSON-LD / Schema.org)</span>
                    </h3>
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">JSON-LD Schema</label>
                        <textarea name="schema_json" class="form-control" rows="8"
                            style="font-family:monospace;font-size:0.8rem"
                            placeholder='{"@@context":"https://schema.org","@type":"Organization","name":"Redis Solution","url":"https://redissolution.com"}'>{{ old('schema_json', $seoPage->schema_json) }}</textarea>
                        <div style="font-size:0.73rem;color:var(--crm-text-muted);margin-top:4px">Paste valid JSON-LD. Use <a href="https://schema.org" target="_blank" style="color:#FF6400">schema.org</a> types: Organization, WebPage, FAQPage, Article, etc.</div>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:1.5rem">

                {{-- Save --}}
                <div class="crm-card">
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center" data-loading-text="Saving…">
                        <i class="ri-save-line"></i> Save Changes
                    </button>
                </div>

                {{-- Health Score --}}
                <div class="crm-card">
                    <h3 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--crm-text-muted);margin:0 0 1rem">SEO Health Score</h3>
                    @php $score = $seoPage->healthScore(); @endphp
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem">
                        <div style="width:56px;height:56px;border-radius:50%;border:4px solid {{ $seoPage->healthColor() }};display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:800;color:{{ $seoPage->healthColor() }};flex-shrink:0">
                            {{ $score }}
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:0.95rem">{{ $score >= 75 ? 'Good' : ($score >= 40 ? 'Needs Work' : 'Poor') }}</div>
                            <div style="font-size:0.75rem;color:var(--crm-text-muted)">out of 100</div>
                        </div>
                    </div>

                    @php $issues = $seoPage->issues(); @endphp
                    @if(count($issues) > 0)
                        <div style="font-size:0.78rem;font-weight:700;color:#ef4444;margin-bottom:6px">{{ count($issues) }} issue(s):</div>
                        @foreach($issues as $issue)
                            <div style="display:flex;align-items:flex-start;gap:5px;font-size:0.78rem;color:#ef4444;margin-bottom:4px">
                                <i class="ri-error-warning-line" style="flex-shrink:0;margin-top:1px"></i> {{ $issue }}
                            </div>
                        @endforeach
                    @else
                        <div style="color:#22c55e;font-size:0.82rem"><i class="ri-checkbox-circle-line"></i> No issues found!</div>
                    @endif
                </div>

                {{-- Technical SEO --}}
                <div class="crm-card">
                    <h3 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--crm-text-muted);margin:0 0 1rem">Technical SEO</h3>

                    <div class="form-group">
                        <label class="form-label">Canonical URL <span style="font-weight:400;color:var(--crm-text-muted)">(optional)</span></label>
                        <input type="url" name="canonical_url" class="form-control" style="font-size:0.82rem"
                            value="{{ old('canonical_url', $seoPage->canonical_url) }}"
                            placeholder="{{ url('/') }}">
                    </div>

                    <div style="display:flex;flex-direction:column;gap:0.6rem;margin-bottom:1rem">
                        <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;font-size:0.85rem">
                            <input type="hidden" name="noindex" value="0">
                            <input type="checkbox" name="noindex" value="1" {{ old('noindex', $seoPage->noindex) ? 'checked' : '' }}
                                style="width:16px;height:16px;accent-color:#ef4444">
                            <span><strong style="color:#ef4444">NOINDEX</strong> — Tell Google NOT to index this page</span>
                        </label>
                        <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;font-size:0.85rem">
                            <input type="hidden" name="nofollow" value="0">
                            <input type="checkbox" name="nofollow" value="1" {{ old('nofollow', $seoPage->nofollow) ? 'checked' : '' }}
                                style="width:16px;height:16px;accent-color:#f59e0b">
                            <span><strong style="color:#f59e0b">NOFOLLOW</strong> — Tell Google NOT to follow links</span>
                        </label>
                    </div>

                    <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;font-size:0.85rem">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $seoPage->is_active) ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#FF6400">
                        <span>Active (apply meta to this page)</span>
                    </label>
                </div>

                {{-- SERP Preview --}}
                <div class="crm-card">
                    <h3 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--crm-text-muted);margin:0 0 1rem">Google Preview</h3>
                    <div style="background:#fff;border-radius:6px;padding:12px;border:1px solid #e0e0e0;font-family:Arial,sans-serif">
                        <div style="font-size:0.7rem;color:#202124;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            {{ url('/') }} › {{ $seoPage->route_name }}
                        </div>
                        <div id="serp-title" style="font-size:1rem;color:#1a0dab;cursor:pointer;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.3;margin-bottom:3px">
                            {{ $seoPage->meta_title ?: $seoPage->page_label.' — '.setting('company_name', 'Redis Solution') }}
                        </div>
                        <div id="serp-desc" style="font-size:0.8rem;color:#4d5156;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                            {{ $seoPage->meta_description ?: 'No meta description set for this page.' }}
                        </div>
                    </div>
                    <div style="font-size:0.7rem;color:var(--crm-text-muted);margin-top:6px">Live preview updates as you type above.</div>
                </div>

            </div>
        </div>
    </form>

@push('scripts')
<script>
function updateCount(fieldId, countId, limit, barId) {
    const field = document.getElementById(fieldId);
    const counter = document.getElementById(countId);
    const bar = document.getElementById(barId);
    const len = field.value.length;
    counter.textContent = '(' + len + '/' + limit + ')';
    const pct = Math.min(100, (len / limit) * 100);
    bar.style.width = pct + '%';
    bar.style.background = len > limit ? '#ef4444' : (len < limit * 0.5 ? '#f59e0b' : '#22c55e');

    // Update SERP preview
    if (fieldId === 'meta_title') {
        document.getElementById('serp-title').textContent = field.value || '{{ $seoPage->page_label }}';
    }
    if (fieldId === 'meta_description') {
        document.getElementById('serp-desc').textContent = field.value || 'No meta description set.';
    }
}
</script>
@endpush

</x-layouts.backend>
