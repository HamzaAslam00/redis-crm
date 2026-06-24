<x-layouts.backend title="Edit Category">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.blog.categories.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">Edit Category</h1>
            <p class="page-subtitle">{{ $category->name }}</p>
        </div>
    </div>

    <div style="max-width:480px">
        <div class="crm-card">
            <form method="POST" action="{{ route('admin.blog.categories.update', $category) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Name <span style="color:#F87171">*</span></label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $category->name) }}" autofocus>
                    @error('name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="margin-top:1rem">
                    <label class="form-label" for="color">Color</label>
                    <div style="display:flex;gap:0.5rem;align-items:center">
                        <input type="color" id="color" name="color" value="{{ old('color', $category->color) }}"
                            style="width:40px;height:36px;border-radius:6px;border:1px solid var(--crm-border);cursor:pointer;padding:2px">
                        <input type="text" value="{{ old('color', $category->color) }}" style="flex:1"
                            class="form-control"
                            oninput="document.getElementById('color').value=this.value"
                            placeholder="#FF6400">
                    </div>
                </div>

                <div class="form-group" style="margin-top:1rem">
                    <label class="form-label" for="description">Description</label>
                    <input type="text" id="description" name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        value="{{ old('description', $category->description) }}" maxlength="255">
                    @error('description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex;gap:0.75rem;margin-top:1.5rem">
                    <a href="{{ route('admin.blog.categories.index') }}" class="btn btn-secondary" style="flex:1;justify-content:center">Cancel</a>
                    <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">
                        <i class="ri-save-line"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.backend>
