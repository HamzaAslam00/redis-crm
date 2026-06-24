<x-layouts.backend title="Edit Testimonial">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">Edit Testimonial</h1>
            <p class="page-subtitle">{{ $testimonial->name }}{{ $testimonial->company ? ' — '.$testimonial->company : '' }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}">
        @csrf
        @method('PUT')
        <div style="display:grid;grid-template-columns:1fr 280px;gap:1.5rem;align-items:start">

            <div class="crm-card">
                <div class="form-grid-2">

                    <div class="form-group">
                        <label class="form-label" for="name">Full Name <span style="color:#F87171">*</span></label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $testimonial->name) }}" autofocus>
                        @error('name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="role">Job Title</label>
                        <input type="text" id="role" name="role"
                            class="form-control @error('role') is-invalid @enderror"
                            value="{{ old('role', $testimonial->role) }}">
                        @error('role')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="company">Company</label>
                        <input type="text" id="company" name="company"
                            class="form-control @error('company') is-invalid @enderror"
                            value="{{ old('company', $testimonial->company) }}">
                        @error('company')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="rating">Rating <span style="color:#F87171">*</span></label>
                        <select id="rating" name="rating" class="form-control @error('rating') is-invalid @enderror">
                            @foreach([5,4,3,2,1] as $r)
                                <option value="{{ $r }}" {{ old('rating', $testimonial->rating) == $r ? 'selected' : '' }}>
                                    {{ str_repeat('★', $r) }}{{ str_repeat('☆', 5-$r) }} ({{ $r }}/5)
                                </option>
                            @endforeach
                        </select>
                        @error('rating')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group" style="grid-column:span 2">
                        <label class="form-label" for="quote">Testimonial Quote <span style="color:#F87171">*</span></label>
                        <textarea id="quote" name="quote" rows="4"
                            class="form-control @error('quote') is-invalid @enderror"
                            maxlength="1000">{{ old('quote', $testimonial->quote) }}</textarea>
                        @error('quote')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="initials">Initials (optional)</label>
                        <input type="text" id="initials" name="initials" maxlength="5"
                            class="form-control @error('initials') is-invalid @enderror"
                            value="{{ old('initials', $testimonial->initials) }}"
                            placeholder="Auto-generated from name">
                        @error('initials')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="avatar_color">Avatar Color</label>
                        <div style="display:flex;align-items:center;gap:0.75rem">
                            <input type="color" id="avatar_color" name="avatar_color"
                                class="form-control @error('avatar_color') is-invalid @enderror"
                                value="{{ old('avatar_color', $testimonial->avatar_color) }}" style="width:52px;height:38px;padding:2px;cursor:pointer">
                            <span style="font-size:0.8rem;color:var(--crm-text-muted)">Background color for the avatar circle</span>
                        </div>
                        @error('avatar_color')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:1rem">

                <div class="crm-card">
                    <h3 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:var(--crm-text-muted);margin:0 0 1rem">Settings</h3>

                    <div class="form-group">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" id="display_order" name="display_order" min="0"
                            class="form-control" value="{{ old('display_order', $testimonial->display_order) }}">
                    </div>

                    <div style="display:flex;align-items:center;gap:0.75rem;margin-top:0.5rem">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#FF6400;cursor:pointer">
                        <label for="is_active" class="form-label" style="margin:0;cursor:pointer">Show on website</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%">
                    <i class="ri-save-line"></i> Update Testimonial
                </button>

                <button type="button" class="btn btn-danger" style="width:100%"
                    onclick="if(confirm('Delete this testimonial permanently?')) document.getElementById('delete-testimonial-form').submit()">
                    <i class="ri-delete-bin-line"></i> Delete
                </button>

                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary" style="width:100%;text-align:center">
                    Cancel
                </a>

            </div>

        </div>
    </form>

    {{-- Delete form outside the edit form to avoid _method conflict --}}
    <form id="delete-testimonial-form" method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" style="display:none">
        @csrf
        @method('DELETE')
    </form>

</x-layouts.backend>
