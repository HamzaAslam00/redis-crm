<x-layouts.backend title="Blog Posts">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem">
        <div>
            <h1 class="page-title">Blog Posts</h1>
            <p class="page-subtitle">Manage your website blog content.</p>
        </div>
        <div style="display:flex;align-items:center;gap:0.5rem">
            <a href="{{ route('admin.blog.categories.index') }}" class="btn btn-secondary btn-sm">
                <i class="ri-price-tag-3-line"></i> Categories
            </a>
            <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary btn-sm">
                <i class="ri-add-line"></i> New Post
            </a>
        </div>
    </div>

    @livewire('backend.blog-posts-table')

</x-layouts.backend>
