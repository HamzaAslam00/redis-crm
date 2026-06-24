<x-layouts.backend title="Edit Portfolio Item">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">Edit Portfolio Item</h1>
            <p class="page-subtitle">{{ Str::limit($portfolio->title, 60) }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.portfolio.update', $portfolio) }}">
        @csrf
        @method('PUT')
        <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">

            {{-- Main --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem">

                <div class="crm-card">
                    <div class="form-grid-2">

                        <div class="form-group" style="grid-column:span 2">
                            <label class="form-label" for="title">Project Title <span style="color:#F87171">*</span></label>
                            <input type="text" id="title" name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $portfolio->title) }}" style="font-size:1.05rem;font-weight:600">
                            @error('title')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="client_name">Client Name</label>
                            <input type="text" id="client_name" name="client_name"
                                class="form-control @error('client_name') is-invalid @enderror"
                                value="{{ old('client_name', $portfolio->client_name) }}">
                            @error('client_name')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="category">Category <span style="color:#F87171">*</span></label>
                            <select id="category" name="category" class="form-control @error('category') is-invalid @enderror">
                                @foreach(['web' => 'Web Development', 'mobile' => 'Mobile App', 'marketing' => 'Digital Marketing', 'erp' => 'ERP Solution', 'ai' => 'AI Application', 'software' => 'Software Development'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('category', $portfolio->category) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('category')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="grid-column:span 2">
                            <label class="form-label" for="short_desc">Short Description <span style="color:#F87171">*</span></label>
                            <input type="text" id="short_desc" name="short_desc" maxlength="255"
                                class="form-control @error('short_desc') is-invalid @enderror"
                                value="{{ old('short_desc', $portfolio->short_desc) }}">
                            @error('short_desc')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="grid-column:span 2">
                            <label class="form-label" for="description">Full Description</label>
                            <textarea id="description" name="description" rows="8"
                                class="form-control @error('description') is-invalid @enderror"
                                style="font-size:0.875rem">{{ old('description', $portfolio->description) }}</textarea>
                            @error('description')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="grid-column:span 2">
                            <label class="form-label" for="tech_stack">Tech Stack</label>
                            <input type="text" id="tech_stack" name="tech_stack"
                                class="form-control @error('tech_stack') is-invalid @enderror"
                                value="{{ old('tech_stack', $portfolio->tech_stack ? implode(', ', $portfolio->tech_stack) : '') }}"
                                placeholder="Laravel, Vue.js, MySQL (comma-separated)">
                            @error('tech_stack')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="grid-column:span 2">
                            <label class="form-label" for="results">Key Results</label>
                            <textarea id="results" name="results" rows="4"
                                class="form-control @error('results') is-invalid @enderror">{{ old('results', $portfolio->results ? implode("\n", $portfolio->results) : '') }}</textarea>
                            <p style="font-size:0.75rem;color:var(--crm-text-muted);margin-top:0.3rem">One result per line.</p>
                            @error('results')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="slug">URL Slug</label>
                            <input type="text" id="slug" name="slug"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $portfolio->slug) }}">
                            @error('slug')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem;position:sticky;top:1.5rem">

                {{-- Settings --}}
                <div class="crm-card">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin-bottom:1rem">Settings</h3>

                    <div class="form-group">
                        <label class="form-label" for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="active" {{ old('status', $portfolio->status) === 'active' ? 'selected' : '' }}>Active (visible)</option>
                            <option value="draft" {{ old('status', $portfolio->status) === 'draft' ? 'selected' : '' }}>Draft (hidden)</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-top:1rem">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" id="display_order" name="display_order" min="0"
                            class="form-control" value="{{ old('display_order', $portfolio->display_order) }}">
                    </div>

                    <div style="display:flex;align-items:center;gap:0.5rem;margin-top:1rem;padding:0.75rem;background:rgba(255,100,0,0.05);border-radius:8px;border:1px solid rgba(255,100,0,0.15)">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#FF6400">
                        <label for="is_featured" style="font-size:0.875rem;font-weight:600;color:var(--crm-text);cursor:pointer">
                            <i class="ri-star-fill" style="color:#F59E0B;margin-right:0.2rem"></i> Mark as Featured
                        </label>
                    </div>

                    <div style="display:flex;gap:0.75rem;margin-top:1.25rem">
                        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary" style="flex:1;justify-content:center">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">
                            <i class="ri-save-line"></i> Update
                        </button>
                    </div>
                </div>

                {{-- Image --}}
                <div class="crm-card">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin-bottom:1rem">Image & URL</h3>

                    <div class="form-group" x-data="featuredImageUploader('{{ old('featured_image', $portfolio->featured_image) }}')">
                        <label class="form-label">Featured Image</label>

                        <template x-if="preview">
                            <img :src="preview" alt="Preview"
                                style="width:100%;height:130px;object-fit:cover;border-radius:8px;margin-bottom:0.75rem">
                        </template>

                        <input type="file" x-ref="fileInput" accept="image/*" @change="upload($event)" style="display:none">
                        <button type="button" @click="$refs.fileInput.click()"
                            class="btn btn-secondary btn-sm" style="width:100%;justify-content:center;margin-bottom:0.6rem"
                            :disabled="uploading">
                            <i class="ri-upload-2-line"></i>
                            <span x-text="uploading ? 'Uploading…' : 'Upload from Computer'"></span>
                        </button>

                        <input type="text" name="featured_image" x-model="url"
                            class="form-control" placeholder="or paste URL here…">
                    </div>

                    <div class="form-group" style="margin-top:1rem">
                        <label class="form-label" for="project_url">Live Project URL</label>
                        <input type="url" id="project_url" name="project_url"
                            class="form-control" value="{{ old('project_url', $portfolio->project_url) }}" placeholder="https://example.com">
                    </div>
                </div>

                {{-- Danger --}}
                <div class="crm-card" style="border-color:rgba(239,68,68,0.2)">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:#ef4444;margin-bottom:1rem">Danger Zone</h3>
                    <button type="button"
                        onclick="if(confirm('Delete this portfolio item permanently?')) document.getElementById('delete-portfolio-form').submit()"
                        class="btn btn-sm" style="background:rgba(239,68,68,0.07);border:1px solid rgba(239,68,68,0.3);color:#ef4444;width:100%;justify-content:center">
                        <i class="ri-delete-bin-line"></i> Delete Item
                    </button>
                </div>

            </div>

        </div>
    </form>

    {{-- Delete form lives OUTSIDE the update form to avoid nested form conflict --}}
    <form id="delete-portfolio-form" method="POST" action="{{ route('admin.portfolio.destroy', $portfolio) }}" style="display:none">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('featuredImageUploader', (initial = '') => ({
            url: initial,
            preview: initial || null,
            uploading: false,
            async upload(event) {
                const file = event.target.files[0];
                if (!file) return;
                this.uploading = true;
                const form = new FormData();
                form.append('file', file);
                form.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                const res = await fetch('{{ route('admin.blog.upload-media') }}', { method: 'POST', body: form });
                const data = await res.json();
                this.url = data.url;
                this.preview = data.url;
                this.uploading = false;
                event.target.value = '';
            }
        }));
    });
    </script>
    @endpush

</x-layouts.backend>
