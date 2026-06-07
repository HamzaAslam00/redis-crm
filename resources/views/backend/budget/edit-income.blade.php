<x-layouts.backend title="Edit Income">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.budget.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">Edit Income</h1>
        </div>
    </div>

    <div class="crm-card">
        <form method="POST" action="{{ route('admin.budget.incomes.update', $income) }}">
            @csrf @method('PUT')
            <div class="form-grid-2">

                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="source">Source <span style="color:#F87171">*</span></label>
                    <input type="text" id="source" name="source"
                        class="form-control @error('source') is-invalid @enderror"
                        value="{{ old('source', $income->source) }}">
                    @error('source')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="amount">Amount <span style="color:#F87171">*</span></label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0.01"
                        class="form-control @error('amount') is-invalid @enderror"
                        value="{{ old('amount', $income->amount) }}">
                    @error('amount')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="currency">Currency</label>
                    <select id="currency" name="currency" class="form-control @error('currency') is-invalid @enderror">
                        @foreach($currencies as $cur)
                            <option value="{{ $cur }}" {{ old('currency', $income->currency) === $cur ? 'selected' : '' }}>{{ $cur }}</option>
                        @endforeach
                    </select>
                    @error('currency')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="date">Date <span style="color:#F87171">*</span></label>
                    <input type="date" id="date" name="date"
                        class="form-control @error('date') is-invalid @enderror"
                        value="{{ old('date', $income->date->format('Y-m-d')) }}">
                    @error('date')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="note">Note</label>
                    <input type="text" id="note" name="note"
                        class="form-control @error('note') is-invalid @enderror"
                        value="{{ old('note', $income->note) }}">
                    @error('note')<p class="form-error">{{ $message }}</p>@enderror
                </div>

            </div>
            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;padding-top:1rem;border-top:1px solid var(--crm-border);margin-top:0.5rem">
                <a href="{{ route('admin.budget.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Save Changes</button>
            </div>
        </form>
    </div>

</x-layouts.backend>
