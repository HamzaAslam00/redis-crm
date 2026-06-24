<x-layouts.backend title="SEO Audit Logs">

    <x-backend.page-header title="Free Audit Tracker" description="Track who ran the free website SEO audit and from where">
        <div style="display:flex;gap:0.5rem">
            <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary"><i class="ri-arrow-left-line"></i> SEO Dashboard</a>
        </div>
    </x-backend.page-header>

    <x-backend.breadcrumb :items="[
        'SEO Management' => route('admin.seo.index'),
        'Audit Logs' => null,
    ]" />

    <livewire:backend.seo-audit-logs-table />

</x-layouts.backend>
