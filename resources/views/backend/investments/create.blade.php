<x-layouts.backend title="New Investment">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.investments.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">New Investment</h1>
            <p class="page-subtitle">Record an investment venture or partnership.</p>
        </div>
    </div>

    <div class="crm-card">
        <form method="POST" action="{{ route('admin.investments.store') }}">
            @csrf

            <div class="form-grid-2">

                <div class="form-group">
                    <label class="form-label" for="person_name">Person / Partner Name <span style="color:#F87171">*</span></label>
                    <input type="text" id="person_name" name="person_name"
                        class="form-control @error('person_name') is-invalid @enderror"
                        value="{{ old('person_name') }}" placeholder="Investor or partner name" autofocus>
                    @error('person_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status <span style="color:#F87171">*</span></label>
                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ old('status', 'active') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="amount">Investment Amount</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0"
                        class="form-control @error('amount') is-invalid @enderror"
                        value="{{ old('amount') }}" placeholder="0.00">
                    @error('amount')<p class="form-error">{{ $message }}</p>@enderror
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
                    <label class="form-label" for="start_date">Start Date <span style="color:#F87171">*</span></label>
                    <input type="date" id="start_date" name="start_date"
                        class="form-control @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date', now()->format('Y-m-d')) }}">
                    @error('start_date')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="expected_end_date">Expected End Date</label>
                    <input type="date" id="expected_end_date" name="expected_end_date"
                        class="form-control @error('expected_end_date') is-invalid @enderror"
                        value="{{ old('expected_end_date') }}">
                    @error('expected_end_date')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="idea_details">Idea / Project Details <span style="color:#F87171">*</span></label>
                    <textarea id="idea_details" name="idea_details" rows="5"
                        class="form-control @error('idea_details') is-invalid @enderror"
                        placeholder="Describe the business idea, investment plan, or project…">{{ old('idea_details') }}</textarea>
                    @error('idea_details')<p class="form-error">{{ $message }}</p>@enderror
                </div>

            </div>

            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;padding-top:1rem;border-top:1px solid var(--crm-border);margin-top:0.5rem">
                <a href="{{ route('admin.investments.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Create Investment</button>
            </div>

        </form>
    </div>

</x-layouts.backend>
