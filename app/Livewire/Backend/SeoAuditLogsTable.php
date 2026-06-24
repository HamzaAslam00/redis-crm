<?php

namespace App\Livewire\Backend;

use App\Models\SeoAuditLog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SeoAuditLogsTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    public bool $showModal = false;

    public string $selectedUrl = '';

    public array $selectedLogs = [];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function showDetails(string $url): void
    {
        $this->selectedUrl = $url;
        $this->selectedLogs = SeoAuditLog::where('url', $url)
            ->orderByDesc('created_at')
            ->get()
            ->toArray();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedUrl = '';
        $this->selectedLogs = [];
    }

    public function render(): View
    {
        $logs = SeoAuditLog::query()
            ->select('url', DB::raw('COUNT(*) as total_audits'), DB::raw('MAX(created_at) as last_audit'), DB::raw('MIN(created_at) as first_audit'), DB::raw('GROUP_CONCAT(DISTINCT country ORDER BY country SEPARATOR ", ") as countries'))
            ->when($this->search, fn ($q) => $q->where('url', 'like', "%{$this->search}%"))
            ->groupBy('url')
            ->orderByDesc('last_audit')
            ->paginate(20);

        $totalAudits = SeoAuditLog::count();
        $uniqueUrls = SeoAuditLog::distinct('url')->count('url');
        $uniqueCountries = SeoAuditLog::whereNotNull('country')->distinct('country')->count('country');

        return view('livewire.backend.seo-audit-logs-table', compact('logs', 'totalAudits', 'uniqueUrls', 'uniqueCountries'));
    }
}
