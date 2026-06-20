<?php

namespace App\Livewire\Backend;

use App\Models\Credential;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CredentialsTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $typeFilter = '';

    #[Url]
    public string $ownerFilter = '';

    #[Url]
    public string $statusFilter = 'active';

    public int $perPage = 15;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedTypeFilter(): void
    {
        $this->resetPage();
    }

    public function updatedOwnerFilter(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    #[On('delete')]
    public function delete(int $id): void
    {
        $cred = Credential::findOrFail($id);
        $cred->delete();

        $this->dispatch('toast', type: 'success', message: "Credential \"{$cred->system_name}\" deleted.");
    }

    /** @return LengthAwarePaginator<Credential> */
    private function getCredentials(): LengthAwarePaginator
    {
        return Credential::query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('system_name', 'like', "%{$this->search}%")
                        ->orWhere('url', 'like', "%{$this->search}%")
                        ->orWhere('owner_name', 'like', "%{$this->search}%")
                        ->orWhere('ip_address', 'like', "%{$this->search}%");
                });
            })
            ->when($this->typeFilter, fn ($q) => $q->where('cred_type', $this->typeFilter))
            ->when($this->ownerFilter, fn ($q) => $q->where('owner_type', $this->ownerFilter))
            ->when($this->statusFilter === 'active', fn ($q) => $q->where('is_active', true))
            ->when($this->statusFilter === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('system_name')
            ->paginate($this->perPage);
    }

    public function render(): View
    {
        return view('livewire.backend.credentials-table', [
            'credentials' => $this->getCredentials(),
            'credTypes' => Credential::$credTypes,
            'ownerTypes' => Credential::$ownerTypes,
        ]);
    }
}
