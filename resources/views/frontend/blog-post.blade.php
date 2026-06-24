<x-layouts.frontend :title="($post->meta_title ?: $post->title) . ' — Redis Solution Blog'">

    {{-- ═══════════════════════════════════════════════
         HERO
    ═══════════════════════════════════════════════ --}}
    <section class="photo-hero">
        @if($post->featured_image)
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="photo-hero__img">
        @else
            <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1600&q=80&auto=format&fit=crop" alt="Blog" class="photo-hero__img">
        @endif
        <div class="photo-hero__overlay"></div>
        <div class="container photo-hero__content">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.75rem;flex-wrap:wrap">
                <a href="{{ route('blog.index') }}" style="font-size:0.8rem;color:rgba(255,255,255,0.6);text-decoration:none">← Blog</a>
                @if($post->category)
                    <span style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;padding:0.2rem 0.6rem;border-radius:20px;background:rgba(255,100,0,0.2);color:#FF6400;border:1px solid rgba(255,100,0,0.35)">
                        {{ $post->category->name }}
                    </span>
                @endif
            </div>
            <h1 class="photo-hero__title" style="max-width:750px">{{ $post->title }}</h1>
            <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;margin-top:0.75rem">
                <span style="font-size:0.85rem;color:rgba(255,255,255,0.55)">
                    <i class="ri-user-line"></i> {{ $post->author->name ?? 'Redis Solution' }}
                </span>
                <span style="font-size:0.85rem;color:rgba(255,255,255,0.55)">
                    <i class="ri-calendar-line"></i> {{ $post->published_at->format('d M Y') }}
                </span>
                <span style="font-size:0.85rem;color:rgba(255,255,255,0.55)">
                    <i class="ri-time-line"></i> {{ $post->reading_time }} min read
                </span>
                <span style="font-size:0.85rem;color:rgba(255,255,255,0.55)">
                    <i class="ri-eye-line"></i> {{ number_format($post->views_count) }} views
                </span>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         CONTENT
    ═══════════════════════════════════════════════ --}}
    <section class="section">
        <div class="container">
            <div style="display:grid;grid-template-columns:1fr 260px;gap:3rem;align-items:start">

                {{-- Post body --}}
                <article>
                    @if($post->excerpt)
                        <p style="font-size:1.1rem;color:rgba(255,255,255,0.6);line-height:1.75;border-left:3px solid #FF6400;padding-left:1.25rem;margin-bottom:2.5rem;font-style:italic">
                            {{ $post->excerpt }}
                        </p>
                    @endif

                    <div class="blog-content" style="color:rgba(255,255,255,0.8);line-height:1.85;font-size:1rem">
                        {!! $post->content !!}
                    </div>

                    {{-- Share --}}
                    <div style="margin-top:3rem;padding-top:2rem;border-top:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;gap:1rem;flex-wrap:wrap">
                        <span style="font-size:0.875rem;font-weight:600;color:rgba(255,255,255,0.5)">Share:</span>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
                            target="_blank" rel="noopener"
                            style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.45rem 1rem;border-radius:8px;background:rgba(29,161,242,0.1);border:1px solid rgba(29,161,242,0.2);color:#1DA1F2;font-size:0.82rem;font-weight:600;text-decoration:none">
                            <i class="ri-twitter-x-line"></i> X / Twitter
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                            target="_blank" rel="noopener"
                            style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.45rem 1rem;border-radius:8px;background:rgba(0,119,181,0.1);border:1px solid rgba(0,119,181,0.2);color:#0077B5;font-size:0.82rem;font-weight:600;text-decoration:none">
                            <i class="ri-linkedin-line"></i> LinkedIn
                        </a>
                    </div>
                </article>

                {{-- Sidebar --}}
                <aside style="position:sticky;top:7rem;display:flex;flex-direction:column;gap:1.5rem">

                    {{-- Author card --}}
                    <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:14px;padding:1.25rem;text-align:center">
                        <div style="width:52px;height:52px;border-radius:50%;background:rgba(255,100,0,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;font-size:1.3rem;font-weight:700;color:#FF6400">
                            {{ strtoupper(substr($post->author->name ?? 'R', 0, 1)) }}
                        </div>
                        <div style="font-weight:700;color:var(--c-white);font-size:0.9rem">{{ $post->author->name ?? 'Redis Solution' }}</div>
                        <div style="font-size:0.78rem;color:rgba(255,255,255,0.4);margin-top:0.2rem">Redis Solution Team</div>
                    </div>

                    {{-- CTA --}}
                    <div style="background:linear-gradient(135deg,rgba(255,100,0,0.12),rgba(236,72,153,0.08));border:1px solid rgba(255,100,0,0.2);border-radius:14px;padding:1.5rem;text-align:center">
                        <p style="font-family:'Syne',sans-serif;font-size:0.95rem;font-weight:700;color:var(--c-white);margin:0 0 0.5rem">Ready to start?</p>
                        <p style="font-size:0.8rem;color:rgba(255,255,255,0.45);margin:0 0 1.25rem;line-height:1.5">Talk to our team about your project — free consultation.</p>
                        <a href="{{ route('free-consultation') }}"
                            style="display:inline-block;padding:0.6rem 1.25rem;background:#FF6400;color:#fff;border-radius:8px;font-size:0.82rem;font-weight:700;text-decoration:none">
                            Free Consultation
                        </a>
                    </div>

                    {{-- Back to blog --}}
                    <a href="{{ route('blog.index') }}"
                        style="display:flex;align-items:center;gap:0.5rem;font-size:0.85rem;color:rgba(255,255,255,0.5);text-decoration:none;padding:0.75rem 0;border-top:1px solid rgba(255,255,255,0.07)"
                        onmouseover="this.style.color='#FF6400'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
                        <i class="ri-arrow-left-line"></i> All Posts
                    </a>

                </aside>

            </div>

            {{-- Related posts --}}
            @if($related->isNotEmpty())
                <div style="margin-top:5rem;padding-top:3rem;border-top:1px solid rgba(255,255,255,0.07)">
                    <h3 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:700;color:var(--c-white);margin-bottom:2rem">Related Articles</h3>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem">
                        @foreach($related as $rel)
                            <a href="{{ route('blog.show', $rel->slug) }}"
                                style="display:block;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;overflow:hidden;text-decoration:none;transition:border-color 0.2s"
                                onmouseover="this.style.borderColor='rgba(255,100,0,0.3)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'">
                                @if($rel->featured_image)
                                    <img src="{{ $rel->featured_image }}" alt="{{ $rel->title }}"
                                        style="width:100%;height:130px;object-fit:cover">
                                @endif
                                <div style="padding:1rem">
                                    @if($rel->category)
                                        <span style="font-size:0.7rem;font-weight:700;text-transform:uppercase;color:#FF6400;letter-spacing:0.06em">{{ $rel->category->name }}</span>
                                    @endif
                                    <h4 style="font-family:'Syne',sans-serif;font-size:0.95rem;font-weight:700;color:var(--c-white);margin:0.3rem 0 0.4rem;line-height:1.4">
                                        {{ Str::limit($rel->title, 65) }}
                                    </h4>
                                    <span style="font-size:0.77rem;color:rgba(255,255,255,0.4)">{{ $rel->published_at->format('d M Y') }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

    <style>
        .blog-content h1,.blog-content h2,.blog-content h3,.blog-content h4{
            font-family:'Syne',sans-serif;font-weight:700;color:#fff;margin:2rem 0 0.75rem
        }
        .blog-content h2{font-size:1.5rem}
        .blog-content h3{font-size:1.2rem}
        .blog-content p{margin:0 0 1.25rem}
        .blog-content ul,.blog-content ol{padding-left:1.5rem;margin:0 0 1.25rem}
        .blog-content li{margin-bottom:0.4rem}
        .blog-content a{color:#FF6400;text-decoration:underline}
        .blog-content strong{color:#fff;font-weight:700}
        .blog-content blockquote{border-left:3px solid #FF6400;padding-left:1.25rem;margin:1.5rem 0;color:rgba(255,255,255,0.6);font-style:italic}
        .blog-content code{background:rgba(255,255,255,0.07);padding:0.1rem 0.4rem;border-radius:4px;font-size:0.875rem;font-family:monospace}
        .blog-content pre{background:#0d1117;border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0;overflow:hidden;margin:1.5rem 0}
        .blog-content pre code.hljs{background:transparent;padding:1.25rem;font-size:0.85rem;line-height:1.65;font-family:"SF Mono","Fira Code","Fira Mono","Roboto Mono",monospace;display:block;overflow-x:auto}
        .blog-content pre code:not(.hljs){background:none;padding:1.25rem;display:block;font-size:0.85rem;line-height:1.65;font-family:monospace;color:#a8b3cf}
        .blog-content img{max-width:100%;border-radius:8px;margin:1rem 0}
        .blog-content iframe{max-width:100%;border-radius:10px;margin:1rem 0}
        /* Video embed responsive wrapper */
        .blog-content div[style*="padding-bottom:56.25%"]{margin:1.5rem 0}
    </style>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.blog-content pre code').forEach(function (el) {
        hljs.highlightElement(el);
    });
});
</script>
@endpush

</x-layouts.frontend>
