<x-layouts.backend title="Activity Logs">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem">
        <div>
            <h1 class="page-title">Activity Logs</h1>
            <p class="page-subtitle">Full audit trail of all CRM actions.</p>
        </div>
    </div>

    @livewire('backend.activity-logs-table')

</x-layouts.backend>
