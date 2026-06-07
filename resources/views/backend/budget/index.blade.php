<x-layouts.backend title="Budget">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem">
        <div>
            <h1 class="page-title">Budget</h1>
            <p class="page-subtitle">Track all income and expenses.</p>
        </div>
    </div>

    @livewire('backend.budget-table')

</x-layouts.backend>
