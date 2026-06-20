<?php

namespace App\Livewire\Backend;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ActivityLogsTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $logFilter = '';

    #[Url]
    public string $causerFilter = '';

    #[Url]
    public string $dateFrom = '';

    #[Url]
    public string $dateTo = '';

    public int $perPage = 50;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedLogFilter(): void
    {
        $this->resetPage();
    }

    public function updatedCauserFilter(): void
    {
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    /** @return LengthAwarePaginator<Activity> */
    private function getLogs(): LengthAwarePaginator
    {
        return Activity::with('causer')
            ->when($this->search, function ($q) {
                $q->where('description', 'like', "%{$this->search}%");
            })
            ->when($this->logFilter, fn ($q) => $q->where('log_name', $this->logFilter))
            ->when($this->causerFilter, fn ($q) => $q->where('causer_id', $this->causerFilter))
            ->when($this->dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }

    private function getLogNames(): array
    {
        return Activity::distinct('log_name')
            ->pluck('log_name')
            ->sort()
            ->values()
            ->toArray();
    }

    private function getCausers()
    {
        return User::orderBy('name')->get(['id', 'name']);
    }

    public function render(): View
    {
        return view('livewire.backend.activity-logs-table', [
            'logs' => $this->getLogs(),
            'logNames' => $this->getLogNames(),
            'causers' => $this->getCausers(),
        ]);
    }
}
