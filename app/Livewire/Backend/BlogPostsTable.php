<?php

namespace App\Livewire\Backend;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BlogPostsTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $statusFilter = '';

    #[Url]
    public string $categoryFilter = '';

    #[Url]
    public string $sortBy = 'created_at';

    #[Url]
    public string $sortDir = 'desc';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'desc';
        }

        $this->resetPage();
    }

    public function toggleStatus(int $id): void
    {
        $post = BlogPost::findOrFail($id);
        $newStatus = $post->status === 'published' ? 'draft' : 'published';
        $post->update([
            'status' => $newStatus,
            'published_at' => $newStatus === 'published' ? now() : $post->published_at,
        ]);

        $this->dispatch('toast', type: 'success', message: $newStatus === 'published' ? 'Post published.' : 'Post moved to draft.');
    }

    #[On('delete')]
    public function deletePost(int $id): void
    {
        BlogPost::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Post deleted.');
    }

    public function render(): View
    {
        $posts = BlogPost::with(['author', 'category'])
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('excerpt', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->categoryFilter, fn ($q) => $q->where('category_id', $this->categoryFilter))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(20);

        $categories = BlogCategory::orderBy('name')->get(['id', 'name']);

        return view('livewire.backend.blog-posts-table', compact('posts', 'categories'));
    }
}
