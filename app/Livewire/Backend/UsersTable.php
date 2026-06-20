<?php

namespace App\Livewire\Backend;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $roleFilter = '';

    #[Url]
    public string $sortBy = 'created_at';

    #[Url]
    public string $sortDir = 'desc';

    public int $perPage = 12;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedRoleFilter(): void
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
        $user = User::findOrFail($id);

        if ($user->hasRole('super-admin')) {
            $this->dispatch('toast', type: 'error', message: 'Cannot delete the super-admin account.');

            return;
        }

        if ($user->id === auth()->id()) {
            $this->dispatch('toast', type: 'error', message: 'You cannot delete your own account.');

            return;
        }

        $user->delete();
        $this->dispatch('toast', type: 'success', message: 'User deleted successfully.');
    }

    /** @return LengthAwarePaginator<User> */
    private function getUsers(): LengthAwarePaginator
    {
        return User::query()
            ->whereDoesntHave('roles', fn ($q) => $q->where('name', 'super-admin'))
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->when($this->roleFilter, function ($q) {
                $q->whereHas('roles', fn ($q) => $q->where('name', $this->roleFilter));
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
    }

    public function render(): View
    {
        return view('livewire.backend.users-table', [
            'users' => $this->getUsers(),
            'roles' => Role::where('name', '!=', 'super-admin')->orderBy('name')->get(),
        ]);
    }
}
