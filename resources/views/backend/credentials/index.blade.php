<x-layouts.backend title="Credentials Vault">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem">
        <div>
            <h1 class="page-title">Credentials Vault</h1>
            <p class="page-subtitle">Encrypted SSH, FTP, database, and panel credentials.</p>
        </div>
        @can('credential.create')
            <a href="{{ route('admin.credentials.create') }}" class="btn btn-primary">
                <i class="ri-add-line"></i> Add Credential
            </a>
        @endcan
    </div>

    @livewire('backend.credentials-table')

</x-layouts.backend>
