<?php

namespace App\Livewire\Backend;

use App\Models\Investment;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class InvestmentsTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $statusFilter = '';

    #[Url]
    public string $sortBy = 'created_at';

    #[Url]
    public string $sortDir = 'desc';

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
        Investment::findOrFail($id)->delete();

        $this->dispatch('toast', type: 'success', message: 'Investment deleted.');
    }

    /** @return LengthAwarePaginator<Investment> */
    private function getInvestments(): LengthAwarePaginator
    {
        return Investment::query()
            ->withSum('expenses', 'amount')
            ->when($this->search, fn ($q) => $q->where('person_name', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
    }

    public function render(): View
    {
        return view('livewire.backend.investments-table', [
            'investments' => $this->getInvestments(),
            'statuses' => Investment::$statuses,
        ]);
    }
}
