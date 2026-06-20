<x-layouts.backend title="Add API Key">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.api-keys.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">Add API Key</h1>
            <p class="page-subtitle">Store a new encrypted API key or token.</p>
        </div>
    </div>

    <div class="crm-card">
        <form method="POST" action="{{ route('admin.api-keys.store') }}">
            @csrf
            <div class="form-grid-2">

                <div class="form-group">
                    <label class="form-label" for="provider_name">Provider <span style="color:#F87171">*</span></label>
                    <input type="text" id="provider_name" name="provider_name"
                        class="form-control @error('provider_name') is-invalid @enderror"
                        value="{{ old('provider_name') }}" placeholder="e.g. OpenAI, Stripe, Twilio" autofocus>
                    @error('provider_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="key_label">Key Label <span style="color:#F87171">*</span></label>
                    <input type="text" id="key_label" name="key_label"
                        class="form-control @error('key_label') is-invalid @enderror"
                        value="{{ old('key_label') }}" placeholder="e.g. OpenAI GPT-4 Production">
                    @error('key_label')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="key_value">Key Value <span style="color:#F87171">*</span></label>
                    <div style="position:relative">
                        <input type="password" id="key_value" name="key_value"
                            class="form-control vault-input @error('key_value') is-invalid @enderror"
                            value="{{ old('key_value') }}" placeholder="Paste your API key here" autocomplete="off">
                        <button type="button" onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password'; this.querySelector('i').className = this.previousElementSibling.type === 'password' ? 'ri-eye-line' : 'ri-eye-off-line'"
                            style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--crm-text-muted);cursor:pointer;padding:0">
                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                    <p style="font-size:0.75rem;color:var(--crm-text-muted);margin-top:0.35rem"><i class="ri-shield-keyhole-line"></i> Encrypted with AES-256 before saving.</p>
                    @error('key_value')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="key_type">Key Type <span style="color:#F87171">*</span></label>
                    <select id="key_type" name="key_type" class="form-control @error('key_type') is-invalid @enderror">
                        @foreach($keyTypes as $k => $label)
                            <option value="{{ $k }}" {{ old('key_type', 'api_key') === $k ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('key_type')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="environment">Environment <span style="color:#F87171">*</span></label>
                    <select id="environment" name="environment" class="form-control @error('environment') is-invalid @enderror">
                        @foreach($environments as $k => $label)
                            <option value="{{ $k }}" {{ old('environment', 'production') === $k ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('environment')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="expires_at">Expires At</label>
                    <input type="date" id="expires_at" name="expires_at"
                        class="form-control @error('expires_at') is-invalid @enderror"
                        value="{{ old('expires_at') }}">
                    @error('expires_at')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="display:flex;align-items:center;padding-top:1.8rem">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.875rem;color:var(--crm-text)">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#FF6400"> Active
                    </label>
                </div>

                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="notes">Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="form-control @error('notes') is-invalid @enderror"
                        placeholder="Optional notes about this key…">{{ old('notes') }}</textarea>
                    @error('notes')<p class="form-error">{{ $message }}</p>@enderror
                </div>

            </div>

            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;padding-top:1rem;border-top:1px solid var(--crm-border);margin-top:0.5rem">
                <a href="{{ route('admin.api-keys.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Save Key</button>
            </div>
        </form>
    </div>

</x-layouts.backend>
