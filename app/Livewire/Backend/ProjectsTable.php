<?php

namespace App\Livewire\Backend;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectsTable extends Component
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

    public function deleteProject(int $id): void
    {
        $project = Project::findOrFail($id);
        $project->delete();

        $this->dispatch('toast', type: 'success', message: "Project {$project->project_code} deleted.");
    }

    /** @return LengthAwarePaginator<Project> */
    private function getProjects(): LengthAwarePaginator
    {
        return Project::query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('client_name', 'like', "%{$this->search}%")
                        ->orWhere('project_code', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
    }

    public function render(): View
    {
        return view('livewire.backend.projects-table', [
            'projects' => $this->getProjects(),
            'statuses' => Project::$statuses,
        ]);
    }
}
