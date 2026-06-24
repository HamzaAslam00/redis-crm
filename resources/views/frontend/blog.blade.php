<x-layouts.frontend title="Blog — Redis Solution">

    {{-- ═══════════════════════════════════════════════
         PAGE HERO
    ═══════════════════════════════════════════════ --}}
    <section class="photo-hero">
        <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1600&q=80&auto=format&fit=crop" alt="Blog" class="photo-hero__img">
        <div class="photo-hero__overlay"></div>
        <div class="container photo-hero__content" style="text-align:center">
            <p class="photo-hero__eye">Insights & Ideas</p>
            <h1 class="photo-hero__title" style="text-align:center">The Redis Solution<br><span>Blog</span></h1>
            <p class="photo-hero__sub" style="margin:0 auto">Web, mobile, AI and marketing insights from our team in Pakistan.</p>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         BLOG CONTENT
    ═══════════════════════════════════════════════ --}}
    <section class="section">
        <div class="container">
            <div class="blog-layout">

                {{-- ── Posts column ────────────────────────────────── --}}
                <div x-data="blogLoadMore">

                    <div id="posts-container">
                        @include('frontend.partials.blog-post-item', ['posts' => $posts])
                    </div>

                    @if($posts->isEmpty())
                        <div style="text-align:center;padding:5rem 1rem">
                            <div style="font-size:3.5rem;margin-bottom:1rem;opacity:0.2">✍️</div>
                            <h3 style="font-family:'Syne',sans-serif;font-size:1.5rem;color:var(--fg-text-muted);margin-bottom:0.5rem">
                                First post coming soon
                            </h3>
                            <p style="color:var(--fg-text-muted)">Our team is writing the first article. Check back shortly.</p>
                        </div>
                    @endif

                    {{-- Load More --}}
                    <div style="text-align:center" x-show="hasMore" x-cloak>
                        <button @click="loadMore()" :disabled="loading" class="btn-load-more">
                            <span x-show="loading" class="load-more-spinner"></span>
                            <span x-text="loading ? 'Loading…' : 'Load More Posts'">Load More Posts</span>
                        </button>
                    </div>

                </div>

                {{-- ── Sidebar ──────────────────────────────────────── --}}
                <aside class="blog-sidebar-sticky">

                    @if($categories->isNotEmpty())
                        <div class="blog-sidebar-widget">
                            <h3>Categories</h3>
                            <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:0.5rem">
                                @foreach($categories as $cat)
                                    <li>
                                        <a href="{{ route('blog.index') }}?category={{ $cat->slug }}"
                                           class="blog-sidebar-cat-link">
                                            <span>{{ $cat->name }}</span>
                                            <span class="count">{{ $cat->published_posts_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="blog-sidebar-cta">
                        <p style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--fg-heading);margin:0 0 0.5rem">Have a project?</p>
                        <p style="font-size:0.82rem;color:var(--fg-text-muted);margin:0 0 1.25rem;line-height:1.5">Let's build something great together.</p>
                        <a href="{{ route('contact') }}"
                           style="display:inline-block;padding:0.6rem 1.4rem;background:#FF6400;color:#fff;border-radius:8px;font-size:0.85rem;font-weight:700;text-decoration:none">
                            Get in Touch
                        </a>
                    </div>

                </aside>

            </div>
        </div>
    </section>

    @push('scripts')
    <script>
    window.__blogLoadMore = {
        nextUrl: @json($posts->nextPageUrl()),
        hasMore: @json($posts->hasMorePages()),
    };

    document.addEventListener('alpine:init', () => {
        window.Alpine.data('blogLoadMore', () => ({
            nextUrl: window.__blogLoadMore.nextUrl,
            hasMore: window.__blogLoadMore.hasMore,
            loading: false,
            async loadMore() {
                if (!this.nextUrl || this.loading) { return; }
                this.loading = true;
                try {
                    const res = await fetch(this.nextUrl, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    });
                    const data = await res.json();
                    document.getElementById('posts-container').insertAdjacentHTML('beforeend', data.html);
                    this.nextUrl = data.nextPageUrl;
                    this.hasMore = data.hasMorePages;
                } catch (e) {
                    console.error('Load more failed', e);
                } finally {
                    this.loading = false;
                }
            },
        }));
    });
    </script>
    @endpush

</x-layouts.frontend>
