<?php

namespace App\Livewire\Backend;

use App\Models\PortfolioItem;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PortfolioTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $categoryFilter = '';

    #[Url]
    public string $statusFilter = '';

    #[Url]
    public string $sortBy = 'display_order';

    #[Url]
    public string $sortDir = 'asc';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }

        $this->resetPage();
    }

    public function toggleFeatured(int $id): void
    {
        $item = PortfolioItem::findOrFail($id);
        $item->update(['is_featured' => ! $item->is_featured]);

        $this->dispatch('toast', type: 'success', message: $item->is_featured ? 'Marked as featured.' : 'Removed from featured.');
    }

    public function toggleStatus(int $id): void
    {
        $item = PortfolioItem::findOrFail($id);
        $item->update(['status' => $item->status === 'active' ? 'draft' : 'active']);

        $this->dispatch('toast', type: 'success', message: 'Status updated.');
    }

    #[On('delete')]
    public function deleteItem(int $id): void
    {
        PortfolioItem::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Portfolio item deleted.');
    }

    public function render(): View
    {
        $items = PortfolioItem::query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('client_name', 'like', "%{$this->search}%")
                        ->orWhere('short_desc', 'like', "%{$this->search}%");
                });
            })
            ->when($this->categoryFilter, fn ($q) => $q->where('category', $this->categoryFilter))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(20);

        return view('livewire.backend.portfolio-table', compact('items'));
    }
}
