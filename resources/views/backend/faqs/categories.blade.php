<x-layouts.backend title="FAQ Categories">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem">
        <div>
            <h1 class="page-title">FAQ Categories</h1>
            <p class="page-subtitle">Group your FAQs into logical categories.</p>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary btn-sm">
            <i class="ri-arrow-left-line"></i> Back to FAQs
        </a>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start">

        {{-- Categories list --}}
        <div class="crm-card" style="padding:0;overflow:hidden">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Icon</th>
                        <th>FAQs</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            <td style="font-weight:600;color:var(--crm-text)">{{ $cat->name }}</td>
                            <td><i class="{{ $cat->icon }}" style="color:#FF6400;font-size:1.1rem"></i></td>
                            <td style="color:var(--crm-text-muted);font-size:0.85rem;text-align:center">{{ $cat->faqs_count }}</td>
                            <td style="color:var(--crm-text-muted);font-size:0.85rem;text-align:center">{{ $cat->display_order }}</td>
                            <td>
                                <span style="font-size:0.72rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:20px;{{ $cat->is_active ? 'background:rgba(16,185,129,0.1);color:#10b981;border:1px solid rgba(16,185,129,0.2)' : 'background:rgba(107,114,128,0.1);color:var(--crm-text-muted);border:1px solid var(--crm-border)' }}">
                                    {{ $cat->is_active ? 'Active' : 'Hidden' }}
                                </span>
                            </td>
                            <td style="text-align:right">
                                <div style="display:inline-flex;gap:0.4rem;align-items:center">
                                    <button onclick="editCat({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->icon }}', {{ $cat->display_order }}, {{ $cat->is_active ? 'true' : 'false' }})"
                                        style="background:rgba(255,100,0,0.08);border:1px solid rgba(255,100,0,0.2);color:#FF6400;padding:0.3rem 0.65rem;border-radius:6px;font-size:0.8rem;cursor:pointer">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.faq-categories.destroy', $cat) }}" onsubmit="return confirm('Delete this category? FAQs in it will become uncategorized.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="background:rgba(239,68,68,0.07);border:1px solid rgba(239,68,68,0.2);color:#ef4444;padding:0.3rem 0.55rem;border-radius:6px;font-size:0.85rem;cursor:pointer">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:2.5rem;color:var(--crm-text-muted)">
                                <i class="ri-folders-line" style="font-size:2rem;display:block;margin-bottom:0.5rem;opacity:0.4"></i>
                                No categories yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Add / Edit form --}}
        <div class="crm-card" id="cat-form-card">
            <h3 id="cat-form-title" style="font-size:0.9rem;font-weight:700;margin:0 0 1.25rem;color:var(--crm-text)">Add Category</h3>

            <form id="cat-form" method="POST" action="{{ route('admin.faq-categories.store') }}">
                @csrf
                <span id="method-field"></span>

                <div class="form-group">
                    <label class="form-label" for="cat_name">Name <span style="color:#F87171">*</span></label>
                    <input type="text" id="cat_name" name="name" class="form-control" placeholder="e.g. Working with Us" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="cat_icon">Icon class (Remix Icon)</label>
                    <input type="text" id="cat_icon" name="icon" class="form-control" value="ri-question-line" placeholder="e.g. ri-settings-3-line">
                    <p style="font-size:0.77rem;color:var(--crm-text-muted);margin-top:0.3rem">Browse icons at <a href="https://remixicon.com" target="_blank" style="color:#FF6400">remixicon.com</a></p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="cat_order">Display Order</label>
                    <input type="number" id="cat_order" name="display_order" class="form-control" value="0" min="0">
                </div>

                <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="cat_active" name="is_active" value="1" checked style="width:16px;height:16px;accent-color:#FF6400;cursor:pointer">
                    <label for="cat_active" class="form-label" style="margin:0;cursor:pointer">Active</label>
                </div>

                <div style="display:flex;gap:0.75rem">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="ri-save-line"></i> <span id="cat-submit-label">Save Category</span></button>
                    <button type="button" id="cat-cancel" class="btn btn-secondary btn-sm" style="display:none" onclick="resetCatForm()">Cancel</button>
                </div>
            </form>
        </div>

    </div>

    @push('scripts')
    <script>
    function editCat(id, name, icon, order, isActive) {
        document.getElementById('cat-form-title').textContent = 'Edit Category';
        document.getElementById('cat-submit-label').textContent = 'Update Category';
        document.getElementById('cat-cancel').style.display = 'inline-flex';
        document.getElementById('cat_name').value = name;
        document.getElementById('cat_icon').value = icon;
        document.getElementById('cat_order').value = order;
        document.getElementById('cat_active').checked = isActive;

        const form = document.getElementById('cat-form');
        form.action = '/admin/faq-categories/' + id;

        let methodField = document.getElementById('method-field');
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('cat-form-card').scrollIntoView({ behavior: 'smooth' });
    }

    function resetCatForm() {
        document.getElementById('cat-form-title').textContent = 'Add Category';
        document.getElementById('cat-submit-label').textContent = 'Save Category';
        document.getElementById('cat-cancel').style.display = 'none';
        document.getElementById('cat-form').action = '{{ route('admin.faq-categories.store') }}';
        document.getElementById('method-field').innerHTML = '';
        document.getElementById('cat-form').reset();
        document.getElementById('cat_icon').value = 'ri-question-line';
        document.getElementById('cat_active').checked = true;
    }
    </script>
    @endpush

</x-layouts.backend>
