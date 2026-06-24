<x-layouts.backend title="FAQs">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem">
        <div>
            <h1 class="page-title">FAQs</h1>
            <p class="page-subtitle">Manage frequently asked questions shown on the FAQ page.</p>
        </div>
        <div style="display:flex;gap:0.75rem">
            <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-secondary btn-sm">
                <i class="ri-folders-line"></i> Categories
            </a>
            <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary btn-sm">
                <i class="ri-add-line"></i> Add FAQ
            </a>
        </div>
    </div>

    @livewire('backend.faqs-table')

</x-layouts.backend>
