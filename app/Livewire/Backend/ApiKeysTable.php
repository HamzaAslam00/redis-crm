<?php

namespace App\Livewire\Backend;

use App\Models\ApiKey;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ApiKeysTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $typeFilter = '';

    #[Url]
    public string $envFilter = '';

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

    public function updatedEnvFilter(): void
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
        $key = ApiKey::findOrFail($id);
        $key->delete();

        $this->dispatch('toast', type: 'success', message: "API key \"{$key->key_label}\" deleted.");
    }

    /** @return LengthAwarePaginator<ApiKey> */
    private function getApiKeys(): LengthAwarePaginator
    {
        return ApiKey::query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('provider_name', 'like', "%{$this->search}%")
                        ->orWhere('key_label', 'like', "%{$this->search}%");
                });
            })
            ->when($this->typeFilter, fn ($q) => $q->where('key_type', $this->typeFilter))
            ->when($this->envFilter, fn ($q) => $q->where('environment', $this->envFilter))
            ->when($this->statusFilter === 'active', fn ($q) => $q->where('is_active', true))
            ->when($this->statusFilter === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('provider_name')
            ->orderBy('key_label')
            ->paginate($this->perPage);
    }

    public function render(): View
    {
        return view('livewire.backend.api-keys-table', [
            'apiKeys' => $this->getApiKeys(),
            'keyTypes' => ApiKey::$keyTypes,
            'environments' => ApiKey::$environments,
        ]);
    }
}
