<?php

namespace App\Livewire\Backend;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class FaqsTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $categoryFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function toggleActive(int $id): void
    {
        $faq = Faq::findOrFail($id);
        $faq->update(['is_active' => ! $faq->is_active]);
        $this->dispatch('toast', type: 'success', message: 'Status updated.');
    }

    #[On('delete')]
    public function deleteItem(int $id): void
    {
        Faq::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'FAQ deleted.');
    }

    public function render(): View
    {
        $faqs = Faq::with('category')
            ->when($this->search, fn ($q) => $q->where('question', 'like', "%{$this->search}%"))
            ->when($this->categoryFilter, fn ($q) => $q->where('faq_category_id', $this->categoryFilter))
            ->orderBy('faq_category_id')
            ->orderBy('display_order')
            ->paginate(20);

        $categories = FaqCategory::orderBy('display_order')->get();

        return view('livewire.backend.faqs-table', compact('faqs', 'categories'));
    }
}
