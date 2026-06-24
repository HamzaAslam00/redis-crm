<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $categorySlug = $request->query('category');

        $posts = BlogPost::with(['author', 'category'])
            ->published()
            ->when($categorySlug, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $categorySlug)))
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.partials.blog-post-item', compact('posts'))->render(),
                'nextPageUrl' => $posts->nextPageUrl(),
                'hasMorePages' => $posts->hasMorePages(),
            ]);
        }

        $categories = BlogCategory::withCount('publishedPosts')
            ->having('published_posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        $siteName = setting('company_name', config('app.name'));

        SEOMeta::setCanonical(route('blog.index'));
        OpenGraph::setUrl(route('blog.index'));
        OpenGraph::setType('website');
        OpenGraph::setSiteName($siteName);
        TwitterCard::setType('summary_large_image');

        return view('frontend.blog', compact('posts', 'categories'));
    }

    public function show(string $slug): View
    {
        $post = BlogPost::with(['author', 'category'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $post->incrementViews();

        $related = BlogPost::with(['author', 'category'])
            ->published()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, fn ($q) => $q->where('category_id', $post->category_id))
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $this->applySeo($post);

        return view('frontend.blog-post', compact('post', 'related'));
    }

    private function applySeo(BlogPost $post): void
    {
        $siteName = setting('company_name', config('app.name'));
        $title = $post->meta_title ?: $post->title;
        $description = $post->meta_description ?: $post->excerpt ?: '';
        $url = route('blog.show', $post->slug);
        $image = $post->featured_image;

        // Core meta
        SEOMeta::setTitle($title.' | '.$siteName);
        SEOMeta::setTitleSeparator('');
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($url);

        // Open Graph — article type
        OpenGraph::setSiteName($siteName);
        OpenGraph::setType('article');
        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl($url);
        OpenGraph::setArticle([
            'published_time' => $post->published_at?->toIso8601String(),
            'modified_time' => $post->updated_at->toIso8601String(),
            'author' => $post->author?->name,
            'section' => $post->category?->name,
        ]);
        if ($image) {
            OpenGraph::addImage($image, ['width' => 1200, 'height' => 630]);
        }

        // Twitter Card
        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        if ($image) {
            TwitterCard::setImage($image);
        }

        // JSON-LD — BlogPosting schema
        JsonLd::setType('BlogPosting');
        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::setUrl($url);
        if ($image) {
            JsonLd::addValue('image', $image);
        }
        if ($post->published_at) {
            JsonLd::addValue('datePublished', $post->published_at->toIso8601String());
        }
        JsonLd::addValue('dateModified', $post->updated_at->toIso8601String());
        if ($post->author) {
            JsonLd::addValue('author', ['@type' => 'Person', 'name' => $post->author->name]);
        }
        JsonLd::addValue('publisher', [
            '@type' => 'Organization',
            'name' => $siteName,
        ]);
        JsonLd::addValue('mainEntityOfPage', ['@type' => 'WebPage', '@id' => $url]);
        if ($post->category) {
            JsonLd::addValue('articleSection', $post->category->name);
        }
    }
}
