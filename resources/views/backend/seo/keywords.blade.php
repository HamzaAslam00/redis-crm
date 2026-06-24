<x-layouts.backend title="SEO Keywords">

    <x-backend.page-header title="Keywords Tracker" description="Track target keywords, positions, and difficulty">
        <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary"><i class="ri-arrow-left-line"></i> SEO Dashboard</a>
    </x-backend.page-header>

    <x-backend.breadcrumb :items="[
        'SEO Management' => route('admin.seo.index'),
        'Keywords' => null,
    ]" />

    @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:8px;padding:0.75rem 1rem;margin-bottom:1.25rem;color:#16a34a;font-size:0.88rem">
            <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
        </div>
    @endif

    <livewire:backend.seo-keywords-table />

</x-layouts.backend>
