<x-layouts.backend title="Edit Credential">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.credentials.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">Edit Credential</h1>
            <p class="page-subtitle">{{ $credential->system_name }}</p>
        </div>
    </div>

    <div class="crm-card">
        <form method="POST" action="{{ route('admin.credentials.update', $credential) }}">
            @csrf
            @method('PUT')
            <div class="form-grid-2">

                <div class="form-group">
                    <label class="form-label" for="system_name">System Name <span style="color:#F87171">*</span></label>
                    <input type="text" id="system_name" name="system_name"
                        class="form-control @error('system_name') is-invalid @enderror"
                        value="{{ old('system_name', $credential->system_name) }}" autofocus>
                    @error('system_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="cred_type">Credential Type <span style="color:#F87171">*</span></label>
                    <select id="cred_type" name="cred_type" class="form-control @error('cred_type') is-invalid @enderror">
                        @foreach($credTypes as $k => $label)
                            <option value="{{ $k }}" {{ old('cred_type', $credential->cred_type) === $k ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('cred_type')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="owner_type">Owner Type <span style="color:#F87171">*</span></label>
                    <select id="owner_type" name="owner_type" class="form-control @error('owner_type') is-invalid @enderror">
                        @foreach($ownerTypes as $k => $label)
                            <option value="{{ $k }}" {{ old('owner_type', $credential->owner_type) === $k ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('owner_type')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="owner_name">Owner Name</label>
                    <input type="text" id="owner_name" name="owner_name"
                        class="form-control @error('owner_name') is-invalid @enderror"
                        value="{{ old('owner_name', $credential->owner_name) }}">
                    @error('owner_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="url">URL / Panel URL</label>
                    <input type="url" id="url" name="url"
                        class="form-control @error('url') is-invalid @enderror"
                        value="{{ old('url', $credential->url) }}">
                    @error('url')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" name="username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username', $credential->username) }}" autocomplete="off">
                    @error('username')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $credential->email) }}" autocomplete="off">
                    @error('email')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div style="position:relative">
                        <input type="password" id="password" name="password"
                            class="form-control vault-input @error('password') is-invalid @enderror"
                            placeholder="Leave blank to keep existing password" autocomplete="new-password">
                        <button type="button" onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password'; this.querySelector('i').className = this.previousElementSibling.type === 'password' ? 'ri-eye-line' : 'ri-eye-off-line'"
                            style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--crm-text-muted);cursor:pointer;padding:0">
                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                    <p style="font-size:0.75rem;color:var(--crm-text-muted);margin-top:0.35rem"><i class="ri-information-line"></i> Leave blank to keep existing encrypted password.</p>
                    @error('password')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="ip_address">IP Address</label>
                    <input type="text" id="ip_address" name="ip_address"
                        class="form-control @error('ip_address') is-invalid @enderror"
                        value="{{ old('ip_address', $credential->ip_address) }}">
                    @error('ip_address')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="port">Port</label>
                    <input type="text" id="port" name="port"
                        class="form-control @error('port') is-invalid @enderror"
                        value="{{ old('port', $credential->port) }}">
                    @error('port')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="command">SSH / Connection Command</label>
                    <textarea id="command" name="command" rows="2"
                        class="form-control vault-input @error('command') is-invalid @enderror">{{ old('command', $credential->command) }}</textarea>
                    @error('command')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="display:flex;align-items:center;padding-top:1.8rem">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.875rem;color:var(--crm-text)">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $credential->is_active) ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#FF6400"> Active
                    </label>
                </div>

                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="notes">Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $credential->notes) }}</textarea>
                    @error('notes')<p class="form-error">{{ $message }}</p>@enderror
                </div>

            </div>

            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;padding-top:1rem;border-top:1px solid var(--crm-border);margin-top:0.5rem">
                <a href="{{ route('admin.credentials.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Update Credential</button>
            </div>
        </form>
    </div>

</x-layouts.backend>
