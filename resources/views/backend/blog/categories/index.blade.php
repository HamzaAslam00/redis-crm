<x-layouts.backend title="Blog Categories">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">Blog Categories</h1>
            <p class="page-subtitle">Organise your blog posts into categories.</p>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 360px;gap:1.5rem;align-items:start">

        {{-- Category List --}}
        <div class="crm-card" style="padding:0;overflow:hidden">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Posts</th>
                        <th>Color</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            <td>
                                <div style="font-weight:600;color:var(--crm-text);font-size:0.875rem">{{ $cat->name }}</div>
                                @if($cat->description)
                                    <div style="font-size:0.77rem;color:var(--crm-text-muted)">{{ $cat->description }}</div>
                                @endif
                                <div style="font-size:0.73rem;color:var(--crm-text-muted);margin-top:0.1rem">/blog/category/{{ $cat->slug }}</div>
                            </td>
                            <td style="color:var(--crm-text-muted);font-size:0.85rem">
                                {{ $cat->posts_count }} post{{ $cat->posts_count !== 1 ? 's' : '' }}
                            </td>
                            <td>
                                <span style="display:inline-block;width:20px;height:20px;border-radius:50%;background:{{ $cat->color }}"></span>
                            </td>
                            <td style="text-align:right">
                                <div style="display:inline-flex;align-items:center;gap:0.4rem">
                                    <a href="{{ route('admin.blog.categories.edit', $cat) }}"
                                        style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.3rem 0.7rem;border-radius:6px;background:rgba(255,100,0,0.08);border:1px solid rgba(255,100,0,0.2);color:#FF6400;font-size:0.78rem;font-weight:600;text-decoration:none">
                                        <i class="ri-pencil-line"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.blog.categories.destroy', $cat) }}"
                                        onsubmit="return confirm('Delete this category? Posts will not be deleted.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="display:inline-flex;align-items:center;padding:0.3rem 0.55rem;border-radius:6px;background:rgba(239,68,68,0.07);border:1px solid rgba(239,68,68,0.2);color:#ef4444;font-size:0.85rem;cursor:pointer">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:2.5rem;color:var(--crm-text-muted)">
                                <i class="ri-price-tag-3-line" style="font-size:2rem;display:block;margin-bottom:0.5rem;opacity:0.4"></i>
                                No categories yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Add New Category --}}
        <div class="crm-card">
            <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin-bottom:1.25rem">Add Category</h3>
            <form method="POST" action="{{ route('admin.blog.categories.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">Name <span style="color:#F87171">*</span></label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="e.g. Web Development" autofocus>
                    @error('name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="margin-top:1rem">
                    <label class="form-label" for="color">Color</label>
                    <div style="display:flex;gap:0.5rem;align-items:center">
                        <input type="color" id="color" name="color" value="{{ old('color', '#FF6400') }}"
                            style="width:40px;height:36px;border-radius:6px;border:1px solid var(--crm-border);cursor:pointer;padding:2px">
                        <input type="text" value="{{ old('color', '#FF6400') }}" style="flex:1"
                            class="form-control"
                            oninput="document.getElementById('color').value=this.value"
                            placeholder="#FF6400">
                    </div>
                </div>

                <div class="form-group" style="margin-top:1rem">
                    <label class="form-label" for="description">Description</label>
                    <input type="text" id="description" name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        value="{{ old('description') }}" placeholder="Optional short description" maxlength="255">
                    @error('description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div style="margin-top:1.5rem">
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                        <i class="ri-add-line"></i> Add Category
                    </button>
                </div>
            </form>
        </div>

    </div>

</x-layouts.backend>
