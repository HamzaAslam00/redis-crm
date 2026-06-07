<x-layouts.backend title="New Project">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm" title="Back">
            <i class="ri-arrow-left-line"></i>
        </a>
        <div>
            <h1 class="page-title">New Project</h1>
            <p class="page-subtitle">A unique project code will be generated automatically.</p>
        </div>
    </div>

    <div class="crm-card">
        <form method="POST" action="{{ route('admin.projects.store') }}">
            @csrf

            <div class="form-grid-2">

                <div class="form-group">
                    <label class="form-label" for="client_name">Client Name <span style="color:#F87171">*</span></label>
                    <input type="text" id="client_name" name="client_name"
                        class="form-control @error('client_name') is-invalid @enderror"
                        value="{{ old('client_name') }}" placeholder="e.g. Acme Corp" autofocus>
                    @error('client_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Project Title <span style="color:#F87171">*</span></label>
                    <input type="text" id="title" name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" placeholder="e.g. E-Commerce Website">
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Brief overview of the project…">{{ old('description') }}</textarea>
                    @error('description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status <span style="color:#F87171">*</span></label>
                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ old('status', 'pending') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="developer_name">Developer / Assigned To</label>
                    <input type="text" id="developer_name" name="developer_name"
                        class="form-control @error('developer_name') is-invalid @enderror"
                        value="{{ old('developer_name') }}" placeholder="Team member or freelancer">
                    @error('developer_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="cost">Cost</label>
                    <input type="number" id="cost" name="cost" step="0.01" min="0"
                        class="form-control @error('cost') is-invalid @enderror"
                        value="{{ old('cost') }}" placeholder="0.00">
                    @error('cost')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="currency">Currency</label>
                    <select id="currency" name="currency" class="form-control @error('currency') is-invalid @enderror">
                        @foreach($currencies as $cur)
                            <option value="{{ $cur }}" {{ old('currency', 'PKR') === $cur ? 'selected' : '' }}>{{ $cur }}</option>
                        @endforeach
                    </select>
                    @error('currency')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="deadline">Deadline</label>
                    <input type="date" id="deadline" name="deadline"
                        class="form-control @error('deadline') is-invalid @enderror"
                        value="{{ old('deadline') }}">
                    @error('deadline')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="live_url">Live URL</label>
                    <input type="url" id="live_url" name="live_url"
                        class="form-control @error('live_url') is-invalid @enderror"
                        value="{{ old('live_url') }}" placeholder="https://example.com">
                    @error('live_url')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="testing_url">Testing / Staging URL</label>
                    <input type="url" id="testing_url" name="testing_url"
                        class="form-control @error('testing_url') is-invalid @enderror"
                        value="{{ old('testing_url') }}" placeholder="https://staging.example.com">
                    @error('testing_url')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="requirements_note">Requirements Note</label>
                    <textarea id="requirements_note" name="requirements_note" rows="4"
                        class="form-control @error('requirements_note') is-invalid @enderror"
                        placeholder="Initial requirements, client notes…">{{ old('requirements_note') }}</textarea>
                    @error('requirements_note')<p class="form-error">{{ $message }}</p>@enderror
                </div>

            </div>

            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;padding-top:1rem;border-top:1px solid var(--crm-border);margin-top:0.5rem">
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i> Create Project
                </button>
            </div>

        </form>
    </div>

</x-layouts.backend>
