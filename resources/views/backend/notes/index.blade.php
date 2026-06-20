<x-layouts.backend title="Personal Notes">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem">
        <div>
            <h1 class="page-title">Personal Notes</h1>
            <p class="page-subtitle">Your private notes — only visible to you.</p>
        </div>
        @can('note.create')
            <a href="{{ route('admin.notes.create') }}" class="btn btn-primary">
                <i class="ri-add-line"></i> New Note
            </a>
        @endcan
    </div>

    @livewire('backend.notes-index')

</x-layouts.backend>
