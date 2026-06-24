<x-layouts.backend title="Portfolio">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem">
        <div>
            <h1 class="page-title">Portfolio</h1>
            <p class="page-subtitle">Manage case studies and project showcase items.</p>
        </div>
        <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary btn-sm">
            <i class="ri-add-line"></i> Add Project
        </a>
    </div>

    @livewire('backend.portfolio-table')

</x-layouts.backend>
