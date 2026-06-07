<x-layouts.backend title="Edit Investment">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.investments.show', $investment) }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">Edit Investment</h1>
            <p class="page-subtitle" style="color:var(--crm-text-muted)">{{ $investment->person_name }}</p>
        </div>
    </div>

    <div class="crm-card">
        <form method="POST" action="{{ route('admin.investments.update', $investment) }}">
            @csrf @method('PUT')

            <div class="form-grid-2">

                <div class="form-group">
                    <label class="form-label" for="person_name">Person / Partner Name <span style="color:#F87171">*</span></label>
                    <input type="text" id="person_name" name="person_name"
                        class="form-control @error('person_name') is-invalid @enderror"
                        value="{{ old('person_name', $investment->person_name) }}">
                    @error('person_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status <span style="color:#F87171">*</span></label>
                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ old('status', $investment->status) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="amount">Investment Amount</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0"
                        class="form-control @error('amount') is-invalid @enderror"
                        value="{{ old('amount', $investment->amount) }}">
                    @error('amount')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="currency">Currency</label>
                    <select id="currency" name="currency" class="form-control @error('currency') is-invalid @enderror">
                        @foreach($currencies as $cur)
                            <option value="{{ $cur }}" {{ old('currency', $investment->currency) === $cur ? 'selected' : '' }}>{{ $cur }}</option>
                        @endforeach
                    </select>
                    @error('currency')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="start_date">Start Date <span style="color:#F87171">*</span></label>
                    <input type="date" id="start_date" name="start_date"
                        class="form-control @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date', $investment->start_date->format('Y-m-d')) }}">
                    @error('start_date')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="expected_end_date">Expected End Date</label>
                    <input type="date" id="expected_end_date" name="expected_end_date"
                        class="form-control @error('expected_end_date') is-invalid @enderror"
                        value="{{ old('expected_end_date', $investment->expected_end_date?->format('Y-m-d')) }}">
                    @error('expected_end_date')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="idea_details">Idea / Project Details <span style="color:#F87171">*</span></label>
                    <textarea id="idea_details" name="idea_details" rows="5"
                        class="form-control @error('idea_details') is-invalid @enderror">{{ old('idea_details', $investment->idea_details) }}</textarea>
                    @error('idea_details')<p class="form-error">{{ $message }}</p>@enderror
                </div>

            </div>

            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;padding-top:1rem;border-top:1px solid var(--crm-border);margin-top:0.5rem">
                <a href="{{ route('admin.investments.show', $investment) }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Save Changes</button>
            </div>

        </form>
    </div>

</x-layouts.backend>
