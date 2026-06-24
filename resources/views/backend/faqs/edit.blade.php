<x-layouts.backend title="Edit FAQ">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">Edit FAQ</h1>
            <p class="page-subtitle">{{ Str::limit($faq->question, 70) }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
        @csrf
        @method('PUT')
        <div style="display:grid;grid-template-columns:1fr 260px;gap:1.5rem;align-items:start">

            <div class="crm-card">
                <div style="display:flex;flex-direction:column;gap:1.25rem">

                    <div class="form-group">
                        <label class="form-label" for="faq_category_id">Category</label>
                        <select id="faq_category_id" name="faq_category_id" class="form-control @error('faq_category_id') is-invalid @enderror">
                            <option value="">— No Category —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('faq_category_id', $faq->faq_category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('faq_category_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="question">Question <span style="color:#F87171">*</span></label>
                        <input type="text" id="question" name="question" maxlength="500"
                            class="form-control @error('question') is-invalid @enderror"
                            value="{{ old('question', $faq->question) }}" autofocus>
                        @error('question')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="answer">Answer <span style="color:#F87171">*</span></label>
                        <textarea id="answer" name="answer" rows="6"
                            class="form-control @error('answer') is-invalid @enderror">{{ old('answer', $faq->answer) }}</textarea>
                        @error('answer')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:1rem">

                <div class="crm-card">
                    <h3 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:var(--crm-text-muted);margin:0 0 1rem">Settings</h3>

                    <div class="form-group">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" id="display_order" name="display_order" min="0"
                            class="form-control" value="{{ old('display_order', $faq->display_order) }}">
                    </div>

                    <div style="display:flex;align-items:center;gap:0.75rem;margin-top:0.5rem">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', $faq->is_active) ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#FF6400;cursor:pointer">
                        <label for="is_active" class="form-label" style="margin:0;cursor:pointer">Show on website</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%">
                    <i class="ri-save-line"></i> Update FAQ
                </button>

                <button type="button" class="btn btn-danger" style="width:100%"
                    onclick="if(confirm('Delete this FAQ permanently?')) document.getElementById('delete-faq-form').submit()">
                    <i class="ri-delete-bin-line"></i> Delete
                </button>

                <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary" style="width:100%;text-align:center">
                    Cancel
                </a>

            </div>

        </div>
    </form>

    {{-- Delete form outside the edit form to avoid _method conflict --}}
    <form id="delete-faq-form" method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" style="display:none">
        @csrf
        @method('DELETE')
    </form>

</x-layouts.backend>
