<?php

namespace App\Livewire\Backend;

use App\Models\SeoBacklink;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SeoBacklinksTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $statusFilter = '';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $source_url = '';

    public string $target_url = '/';

    public string $anchor_text = '';

    public string $link_type = 'dofollow';

    public string $domain_authority = '';

    public string $formStatus = 'pending';

    public string $discovered_at = '';

    public string $last_checked_at = '';

    public string $notes = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset(['source_url', 'target_url', 'anchor_text', 'link_type', 'domain_authority', 'formStatus', 'discovered_at', 'last_checked_at', 'notes', 'editingId']);
        $this->target_url = '/';
        $this->link_type = 'dofollow';
        $this->formStatus = 'pending';
        $this->discovered_at = now()->format('Y-m-d');
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $bl = SeoBacklink::findOrFail($id);
        $this->editingId = $id;
        $this->source_url = $bl->source_url;
        $this->target_url = $bl->target_url;
        $this->anchor_text = $bl->anchor_text ?? '';
        $this->link_type = $bl->link_type;
        $this->domain_authority = (string) ($bl->domain_authority ?? '');
        $this->formStatus = $bl->status;
        $this->discovered_at = $bl->discovered_at->format('Y-m-d');
        $this->last_checked_at = $bl->last_checked_at?->format('Y-m-d') ?? '';
        $this->notes = $bl->notes ?? '';
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate([
            'source_url' => 'required|url|max:1000',
            'target_url' => 'required|string|max:500',
            'anchor_text' => 'nullable|string|max:300',
            'link_type' => 'required|in:dofollow,nofollow,sponsored,ugc',
            'domain_authority' => 'nullable|integer|min:0|max:100',
            'formStatus' => 'required|in:active,broken,pending,lost',
            'discovered_at' => 'required|date',
            'last_checked_at' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $data = [
            'source_url' => $this->source_url,
            'source_domain' => SeoBacklink::extractDomain($this->source_url),
            'target_url' => $this->target_url,
            'anchor_text' => $this->anchor_text ?: null,
            'link_type' => $this->link_type,
            'domain_authority' => $this->domain_authority !== '' ? (int) $this->domain_authority : null,
            'status' => $this->formStatus,
            'discovered_at' => $this->discovered_at,
            'last_checked_at' => $this->last_checked_at ?: null,
            'notes' => $this->notes ?: null,
        ];

        if ($this->editingId) {
            SeoBacklink::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Backlink updated.');
        } else {
            SeoBacklink::create($data);
            session()->flash('success', 'Backlink added.');
        }

        $this->showForm = false;
        $this->reset(['source_url', 'target_url', 'anchor_text', 'link_type', 'domain_authority', 'formStatus', 'discovered_at', 'last_checked_at', 'notes', 'editingId']);
    }

    public function delete(int $id): void
    {
        SeoBacklink::findOrFail($id)->delete();
        session()->flash('success', 'Backlink removed.');
    }

    public function render(): View
    {
        $backlinks = SeoBacklink::query()
            ->when($this->search, fn ($q) => $q->where(function ($q): void {
                $q->where('source_domain', 'like', "%{$this->search}%")
                    ->orWhere('anchor_text', 'like', "%{$this->search}%")
                    ->orWhere('target_url', 'like', "%{$this->search}%");
            }))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(20);

        return view('livewire.backend.seo-backlinks-table', compact('backlinks'));
    }
}
