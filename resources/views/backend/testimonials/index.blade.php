<x-layouts.backend title="Testimonials">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem">
        <div>
            <h1 class="page-title">Testimonials</h1>
            <p class="page-subtitle">Manage client reviews shown on the homepage.</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">
            <i class="ri-add-line"></i> Add Testimonial
        </a>
    </div>

    @livewire('backend.testimonials-table')

</x-layouts.backend>
