<x-layouts.backend title="API Keys Vault">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem">
        <div>
            <h1 class="page-title">API Keys Vault</h1>
            <p class="page-subtitle">Encrypted storage for all API keys and tokens.</p>
        </div>
        @can('apikey.create')
            <a href="{{ route('admin.api-keys.create') }}" class="btn btn-primary">
                <i class="ri-add-line"></i> Add API Key
            </a>
        @endcan
    </div>

    @livewire('backend.api-keys-table')

</x-layouts.backend>
