<?php

namespace App\Livewire\Backend;

use App\Models\SeoKeyword;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SeoKeywordsTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $priority = '';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $keyword = '';

    public string $target_url = '';

    public string $formPriority = 'medium';

    public string $current_position = '';

    public string $monthly_volume = '';

    public string $difficulty = '';

    public string $notes = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPriority(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset(['keyword', 'target_url', 'formPriority', 'current_position', 'monthly_volume', 'difficulty', 'notes', 'editingId']);
        $this->formPriority = 'medium';
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $kw = SeoKeyword::findOrFail($id);
        $this->editingId = $id;
        $this->keyword = $kw->keyword;
        $this->target_url = $kw->target_url ?? '';
        $this->formPriority = $kw->priority;
        $this->current_position = (string) ($kw->current_position ?? '');
        $this->monthly_volume = (string) ($kw->monthly_volume ?? '');
        $this->difficulty = (string) ($kw->difficulty ?? '');
        $this->notes = $kw->notes ?? '';
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate([
            'keyword' => 'required|string|max:200',
            'target_url' => 'nullable|string|max:500',
            'formPriority' => 'required|in:high,medium,low',
            'current_position' => 'nullable|integer|min:1|max:1000',
            'monthly_volume' => 'nullable|integer|min:0',
            'difficulty' => 'nullable|integer|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        $data = [
            'keyword' => $this->keyword,
            'target_url' => $this->target_url ?: null,
            'priority' => $this->formPriority,
            'current_position' => $this->current_position !== '' ? (int) $this->current_position : null,
            'monthly_volume' => $this->monthly_volume !== '' ? (int) $this->monthly_volume : null,
            'difficulty' => $this->difficulty !== '' ? (int) $this->difficulty : null,
            'notes' => $this->notes ?: null,
        ];

        if ($this->editingId) {
            SeoKeyword::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Keyword updated.');
        } else {
            SeoKeyword::create($data);
            session()->flash('success', 'Keyword added.');
        }

        $this->showForm = false;
        $this->reset(['keyword', 'target_url', 'formPriority', 'current_position', 'monthly_volume', 'difficulty', 'notes', 'editingId']);
    }

    public function delete(int $id): void
    {
        SeoKeyword::findOrFail($id)->delete();
        session()->flash('success', 'Keyword removed.');
    }

    public function render(): View
    {
        $keywords = SeoKeyword::query()
            ->when($this->search, fn ($q) => $q->where('keyword', 'like', "%{$this->search}%"))
            ->when($this->priority, fn ($q) => $q->where('priority', $this->priority))
            ->latest()
            ->paginate(20);

        return view('livewire.backend.seo-keywords-table', compact('keywords'));
    }
}
