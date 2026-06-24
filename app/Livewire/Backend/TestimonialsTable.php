<?php

namespace App\Livewire\Backend;

use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TestimonialsTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function toggleActive(int $id): void
    {
        $item = Testimonial::findOrFail($id);
        $item->update(['is_active' => ! $item->is_active]);
        $this->dispatch('toast', type: 'success', message: $item->is_active ? 'Testimonial activated.' : 'Testimonial hidden.');
    }

    #[On('delete')]
    public function deleteItem(int $id): void
    {
        Testimonial::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Testimonial deleted.');
    }

    public function render(): View
    {
        $items = Testimonial::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('company', 'like', "%{$this->search}%"))
            ->orderBy('display_order')
            ->orderBy('id')
            ->paginate(20);

        return view('livewire.backend.testimonials-table', compact('items'));
    }
}
