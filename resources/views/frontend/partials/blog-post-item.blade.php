@foreach($posts as $post)
<article class="blog-post-item{{ $post->featured_image ? ' blog-post-item--with-thumb' : '' }}" data-gsap-fade>

    @if($post->featured_image)
        <a href="{{ route('blog.show', $post->slug) }}" class="blog-post-thumb">
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" loading="lazy">
        </a>
    @endif

    <div>
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.6rem;flex-wrap:wrap">
            @if($post->category)
                <span class="blog-cat-pill">{{ $post->category->name }}</span>
            @endif
            <span style="font-size:0.78rem;color:var(--fg-text-muted)">
                {{ $post->published_at->format('d M Y') }}
                &nbsp;·&nbsp;
                {{ $post->reading_time }} min read
            </span>
        </div>

        <h2 style="margin:0 0 0.5rem">
            <a href="{{ route('blog.show', $post->slug) }}" class="blog-post-title-link">
                {{ $post->title }}
            </a>
        </h2>

        @if($post->excerpt)
            <p style="font-size:0.9rem;color:var(--fg-text-muted);line-height:1.65;margin:0 0 0.85rem">
                {{ Str::limit($post->excerpt, 160) }}
            </p>
        @endif

        <div style="display:flex;align-items:center;justify-content:space-between">
            <span style="font-size:0.78rem;color:var(--fg-text-muted)">
                By {{ $post->author->name ?? 'Redis Solution' }}
            </span>
            <a href="{{ route('blog.show', $post->slug) }}" class="blog-read-more">
                Read more →
            </a>
        </div>
    </div>

</article>
@endforeach
