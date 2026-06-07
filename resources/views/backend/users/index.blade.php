<x-layouts.backend title="Users">

    {{-- Page header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:2rem;flex-wrap:wrap">
        <div>
            <h1 class="page-title">Users</h1>
            <p class="page-subtitle">Manage team members and their access roles.</p>
        </div>
    </div>

    @livewire('backend.users-table')

</x-layouts.backend>
