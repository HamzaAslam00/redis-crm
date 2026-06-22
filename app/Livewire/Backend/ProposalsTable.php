<?php

namespace App\Livewire\Backend;

use App\Models\Proposal;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProposalsTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $statusFilter = '';

    #[Url]
    public string $platformFilter = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingPlatformFilter(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $proposals = Proposal::query()
            ->when($this->search, function ($q): void {
                $q->where(function ($q): void {
                    $q->where('client_name', 'like', "%{$this->search}%")
                        ->orWhere('project_title', 'like', "%{$this->search}%")
                        ->orWhere('proposal_number', 'like', "%{$this->search}%")
                        ->orWhere('client_company', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->platformFilter, fn ($q) => $q->where('platform', $this->platformFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.backend.proposals-table', compact('proposals'));
    }
}
