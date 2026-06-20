<x-layouts.backend title="New Note">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.notes.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">New Note</h1>
            <p class="page-subtitle">Create a private note visible only to you.</p>
        </div>
    </div>

    <div class="crm-card">
        <form method="POST" action="{{ route('admin.notes.store') }}">
            @csrf

            <div class="form-group" style="margin-bottom:1.25rem">
                <label class="form-label" for="title">Title</label>
                <input type="text" id="title" name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}" placeholder="Optional title…" autofocus>
                @error('title')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group" style="margin-bottom:1.25rem">
                <label class="form-label" for="content">Content <span style="color:#F87171">*</span></label>
                <textarea id="content" name="content" rows="12"
                    class="form-control @error('content') is-invalid @enderror"
                    placeholder="Write your note…">{{ old('content') }}</textarea>
                @error('content')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-grid-2" style="margin-bottom:1.25rem">

                <div class="form-group">
                    <label class="form-label" for="tags_input">Tags</label>
                    <input type="text" id="tags_input" name="tags_input"
                        class="form-control @error('tags') is-invalid @enderror"
                        value="{{ old('tags_input') }}" placeholder="Comma-separated: work, idea, todo">
                    <p style="font-size:0.75rem;color:var(--crm-text-muted);margin-top:0.35rem">Separate tags with commas</p>
                    @error('tags')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Card Color</label>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-top:0.35rem">
                        @foreach($colors as $hex => $name)
                            <label title="{{ $name }}" style="cursor:pointer">
                                <input type="radio" name="color" value="{{ $hex }}" {{ old('color', '#ffffff') === $hex ? 'checked' : '' }} style="display:none">
                                <span style="display:block;width:28px;height:28px;border-radius:50%;background:{{ $hex }};border:2px solid {{ old('color', '#ffffff') === $hex ? '#FF6400' : 'rgba(0,0,0,0.15)' }};transition:border-color 0.15s"></span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-group" style="display:flex;align-items:center;padding-top:1.6rem">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.875rem;color:var(--crm-text)">
                        <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#FF6400"> Pin this note
                    </label>
                </div>

            </div>

            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;padding-top:1rem;border-top:1px solid var(--crm-border);margin-top:0.5rem">
                <a href="{{ route('admin.notes.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Save Note</button>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('input[name="color"]').forEach(radio => {
            radio.addEventListener('change', () => {
                document.querySelectorAll('input[name="color"]').forEach(r => {
                    r.nextElementSibling.style.borderColor = 'rgba(0,0,0,0.15)';
                });
                radio.nextElementSibling.style.borderColor = '#FF6400';
            });
        });
    </script>

</x-layouts.backend>
