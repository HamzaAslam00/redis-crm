<x-layouts.backend title="Edit Hosting Client">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.hosting.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">Edit Hosting Client</h1>
            <p class="page-subtitle" style="color:var(--crm-text-muted)">{{ $client->client_name }} — {{ $client->domain_name }}</p>
        </div>
    </div>

    <div class="crm-card">
        <form method="POST" action="{{ route('admin.hosting.update', $client) }}">
            @csrf @method('PUT')
            <div class="form-grid-2">

                <div class="form-group">
                    <label class="form-label" for="client_name">Client Name <span style="color:#F87171">*</span></label>
                    <input type="text" id="client_name" name="client_name"
                        class="form-control @error('client_name') is-invalid @enderror"
                        value="{{ old('client_name', $client->client_name) }}">
                    @error('client_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="domain_name">Domain Name <span style="color:#F87171">*</span></label>
                    <input type="text" id="domain_name" name="domain_name"
                        class="form-control @error('domain_name') is-invalid @enderror"
                        value="{{ old('domain_name', $client->domain_name) }}">
                    @error('domain_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="server_usage">Service Type <span style="color:#F87171">*</span></label>
                    <select id="server_usage" name="server_usage" class="form-control @error('server_usage') is-invalid @enderror">
                        @foreach($serverUsages as $key => $label)
                            <option value="{{ $key }}" {{ old('server_usage', $client->server_usage) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('server_usage')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="hosting_provider">Hosting Provider</label>
                    <input type="text" id="hosting_provider" name="hosting_provider"
                        class="form-control @error('hosting_provider') is-invalid @enderror"
                        value="{{ old('hosting_provider', $client->hosting_provider) }}">
                    @error('hosting_provider')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="starting_date">Starting Date <span style="color:#F87171">*</span></label>
                    <input type="date" id="starting_date" name="starting_date"
                        class="form-control @error('starting_date') is-invalid @enderror"
                        value="{{ old('starting_date', $client->starting_date->format('Y-m-d')) }}">
                    @error('starting_date')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="renew_duration">Renewal Cycle <span style="color:#F87171">*</span></label>
                    <select id="renew_duration" name="renew_duration" class="form-control @error('renew_duration') is-invalid @enderror">
                        @foreach($renewDurations as $key => $label)
                            <option value="{{ $key }}" {{ old('renew_duration', $client->renew_duration) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('renew_duration')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="amount">Amount (per cycle) <span style="color:#F87171">*</span></label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0"
                        class="form-control @error('amount') is-invalid @enderror"
                        value="{{ old('amount', $client->amount) }}">
                    @error('amount')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="currency">Currency</label>
                    <select id="currency" name="currency" class="form-control @error('currency') is-invalid @enderror">
                        @foreach($currencies as $cur)
                            <option value="{{ $cur }}" {{ old('currency', $client->currency) === $cur ? 'selected' : '' }}>{{ $cur }}</option>
                        @endforeach
                    </select>
                    @error('currency')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="server_ip">Server IP</label>
                    <input type="text" id="server_ip" name="server_ip"
                        class="form-control @error('server_ip') is-invalid @enderror"
                        value="{{ old('server_ip', $client->server_ip) }}">
                    @error('server_ip')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="display:flex;align-items:center;gap:1.5rem;padding-top:1.8rem">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.875rem;color:var(--crm-text)">
                        <input type="checkbox" name="auto_renew" value="1" {{ old('auto_renew', $client->auto_renew) ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#FF6400"> Auto Renew
                    </label>
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.875rem;color:var(--crm-text)">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $client->is_active) ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#FF6400"> Active
                    </label>
                </div>

                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="notes">Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $client->notes) }}</textarea>
                    @error('notes')<p class="form-error">{{ $message }}</p>@enderror
                </div>

            </div>

            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;padding-top:1rem;border-top:1px solid var(--crm-border);margin-top:0.5rem">
                <a href="{{ route('admin.hosting.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Save Changes</button>
            </div>
        </form>
    </div>

</x-layouts.backend>
