<?php

namespace App\Livewire\Backend;

use App\Models\HostingClient;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class HostingClientsTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $statusFilter = 'active';

    #[Url]
    public string $sortBy = 'starting_date';

    #[Url]
    public string $sortDir = 'asc';

    public int $perPage = 15;

    public function updatedSearch(): void
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

    #[On('delete')]
    public function delete(int $id): void
    {
        HostingClient::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Hosting client deleted.');
    }

    /** @return LengthAwarePaginator<HostingClient> */
    private function getClients(): LengthAwarePaginator
    {
        return HostingClient::query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('client_name', 'like', "%{$this->search}%")
                        ->orWhere('domain_name', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter === 'active', fn ($q) => $q->where('is_active', true))
            ->when($this->statusFilter === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
    }

    public function render(): View
    {
        return view('livewire.backend.hosting-clients-table', [
            'clients' => $this->getClients(),
        ]);
    }
}
