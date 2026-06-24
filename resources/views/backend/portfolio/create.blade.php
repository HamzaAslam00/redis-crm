<x-layouts.backend title="Add Portfolio Item">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">Add Portfolio Item</h1>
            <p class="page-subtitle">Add a new case study or project to your public portfolio.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.portfolio.store') }}">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">

            {{-- Main --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem">

                <div class="crm-card">
                    <div class="form-grid-2">

                        <div class="form-group" style="grid-column:span 2">
                            <label class="form-label" for="title">Project Title <span style="color:#F87171">*</span></label>
                            <input type="text" id="title" name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" placeholder="e.g. PakBazar E-Commerce Platform" autofocus style="font-size:1.05rem;font-weight:600">
                            @error('title')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="client_name">Client Name</label>
                            <input type="text" id="client_name" name="client_name"
                                class="form-control @error('client_name') is-invalid @enderror"
                                value="{{ old('client_name') }}" placeholder="e.g. ABC Corp">
                            @error('client_name')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="category">Category <span style="color:#F87171">*</span></label>
                            <select id="category" name="category" class="form-control @error('category') is-invalid @enderror">
                                <option value="web" {{ old('category') === 'web' ? 'selected' : '' }}>Web Development</option>
                                <option value="mobile" {{ old('category') === 'mobile' ? 'selected' : '' }}>Mobile App</option>
                                <option value="marketing" {{ old('category') === 'marketing' ? 'selected' : '' }}>Digital Marketing</option>
                                <option value="erp" {{ old('category') === 'erp' ? 'selected' : '' }}>ERP Solution</option>
                                <option value="ai" {{ old('category') === 'ai' ? 'selected' : '' }}>AI Application</option>
                                <option value="software" {{ old('category') === 'software' ? 'selected' : '' }}>Software Development</option>
                            </select>
                            @error('category')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="grid-column:span 2">
                            <label class="form-label" for="short_desc">Short Description <span style="color:#F87171">*</span></label>
                            <input type="text" id="short_desc" name="short_desc" maxlength="255"
                                class="form-control @error('short_desc') is-invalid @enderror"
                                value="{{ old('short_desc') }}" placeholder="1-2 sentence summary shown on portfolio card">
                            @error('short_desc')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="grid-column:span 2">
                            <label class="form-label" for="description">Full Description</label>
                            <textarea id="description" name="description" rows="8"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Detailed case study description. HTML supported." style="font-size:0.875rem">{{ old('description') }}</textarea>
                            @error('description')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="grid-column:span 2">
                            <label class="form-label" for="tech_stack">Tech Stack</label>
                            <input type="text" id="tech_stack" name="tech_stack"
                                class="form-control @error('tech_stack') is-invalid @enderror"
                                value="{{ old('tech_stack') }}" placeholder="Laravel, Vue.js, MySQL, Redis (comma-separated)">
                            <p style="font-size:0.75rem;color:var(--crm-text-muted);margin-top:0.3rem">Comma-separated list of technologies.</p>
                            @error('tech_stack')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="grid-column:span 2">
                            <label class="form-label" for="results">Key Results</label>
                            <textarea id="results" name="results" rows="4"
                                class="form-control @error('results') is-invalid @enderror"
                                placeholder="One result per line:&#10;Reduced load time by 60%&#10;Increased conversions by 35%">{{ old('results') }}</textarea>
                            <p style="font-size:0.75rem;color:var(--crm-text-muted);margin-top:0.3rem">One result per line. Shown as bullet points.</p>
                            @error('results')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem;position:sticky;top:1.5rem">

                {{-- Save --}}
                <div class="crm-card">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin-bottom:1rem">Settings</h3>

                    <div class="form-group">
                        <label class="form-label" for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active (visible)</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (hidden)</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-top:1rem">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" id="display_order" name="display_order" min="0"
                            class="form-control" value="{{ old('display_order', 0) }}" placeholder="0">
                        <p style="font-size:0.75rem;color:var(--crm-text-muted);margin-top:0.3rem">Lower = shown first.</p>
                    </div>

                    <div style="display:flex;align-items:center;gap:0.5rem;margin-top:1rem;padding:0.75rem;background:rgba(255,100,0,0.05);border-radius:8px;border:1px solid rgba(255,100,0,0.15)">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#FF6400">
                        <label for="is_featured" style="font-size:0.875rem;font-weight:600;color:var(--crm-text);cursor:pointer">
                            <i class="ri-star-fill" style="color:#F59E0B;margin-right:0.2rem"></i> Mark as Featured
                        </label>
                    </div>

                    <div style="display:flex;gap:0.75rem;margin-top:1.25rem">
                        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary" style="flex:1;justify-content:center">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">
                            <i class="ri-save-line"></i> Save
                        </button>
                    </div>
                </div>

                {{-- Images --}}
                <div class="crm-card">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin-bottom:1rem">Image</h3>

                    <div class="form-group">
                        <label class="form-label" for="featured_image">Featured Image URL</label>
                        <input type="text" id="featured_image" name="featured_image"
                            class="form-control @error('featured_image') is-invalid @enderror"
                            value="{{ old('featured_image') }}" placeholder="https://… or /storage/…">
                        @error('featured_image')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group" style="margin-top:1rem">
                        <label class="form-label" for="project_url">Live Project URL</label>
                        <input type="url" id="project_url" name="project_url"
                            class="form-control @error('project_url') is-invalid @enderror"
                            value="{{ old('project_url') }}" placeholder="https://example.com">
                        @error('project_url')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

            </div>

        </div>
    </form>

</x-layouts.backend>
