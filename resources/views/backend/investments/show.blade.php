<x-layouts.backend :title="'Investment — ' . $investment->person_name">

    @php
        $sc = match($investment->status) {
            'active'    => ['bg' => 'rgba(52,211,153,0.15)',  'color' => '#34D399'],
            'completed' => ['bg' => 'rgba(96,165,250,0.15)',  'color' => '#60A5FA'],
            'paused'    => ['bg' => 'rgba(251,191,36,0.15)',  'color' => '#FBBF24'],
            'cancelled' => ['bg' => 'rgba(248,113,113,0.15)', 'color' => '#F87171'],
            default     => ['bg' => 'rgba(148,163,184,0.15)', 'color' => '#94A3B8'],
        };
        $totalSpent = $investment->expenses->sum('amount');
        $remaining  = (float)($investment->amount ?? 0) - $totalSpent;
    @endphp

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.75rem">
        <div style="display:flex;align-items:center;gap:1rem">
            <a href="{{ route('admin.investments.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
            <div>
                <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap">
                    <h1 class="page-title" style="margin:0">{{ $investment->person_name }}</h1>
                    <span style="display:inline-flex;align-items:center;padding:0.2rem 0.65rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:{{ $sc['bg'] }};color:{{ $sc['color'] }}">
                        {{ \App\Models\Investment::$statuses[$investment->status] ?? $investment->status }}
                    </span>
                </div>
                <p style="font-size:0.8rem;color:var(--crm-text-muted);margin:0.25rem 0 0">
                    Started {{ $investment->start_date->format('d M Y') }}
                    @if($investment->expected_end_date)
                        &nbsp;·&nbsp; Expected end: {{ $investment->expected_end_date->format('d M Y') }}
                    @endif
                </p>
            </div>
        </div>
        <div style="display:flex;gap:0.5rem">
            @can('investment.edit')
                <a href="{{ route('admin.investments.edit', $investment) }}" class="btn btn-secondary"><i class="ri-pencil-line"></i> Edit</a>
            @endcan
            @can('investment.delete')
                <form id="delete-investment-form" method="POST" action="{{ route('admin.investments.destroy', $investment) }}">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-danger"
                        onclick="deleteForm(this)"
                        data-form="delete-investment-form"
                        data-label="this investment">
                        <i class="ri-delete-bin-line"></i> Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>

    {{-- Summary cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1rem;margin-bottom:1.5rem">
        <div class="crm-card" style="padding:1rem 1.25rem">
            <div style="font-size:0.72rem;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.4rem">Total Invested</div>
            <div style="font-size:1.25rem;font-weight:700;font-family:'Syne',sans-serif;color:var(--crm-text)">
                {{ $investment->amount ? number_format($investment->amount, 0) . ' ' . $investment->currency : '—' }}
            </div>
        </div>
        <div class="crm-card" style="padding:1rem 1.25rem">
            <div style="font-size:0.72rem;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.4rem">Total Spent</div>
            <div style="font-size:1.25rem;font-weight:700;font-family:'Syne',sans-serif;color:#F87171">
                {{ number_format($totalSpent, 0) }} {{ $investment->currency }}
            </div>
        </div>
        <div class="crm-card" style="padding:1rem 1.25rem">
            <div style="font-size:0.72rem;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.4rem">Remaining</div>
            <div style="font-size:1.25rem;font-weight:700;font-family:'Syne',sans-serif;color:{{ $remaining >= 0 ? '#34D399' : '#F87171' }}">
                {{ number_format($remaining, 0) }} {{ $investment->currency }}
            </div>
        </div>
        <div class="crm-card" style="padding:1rem 1.25rem">
            <div style="font-size:0.72rem;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.4rem">Expenses</div>
            <div style="font-size:1.25rem;font-weight:700;font-family:'Syne',sans-serif;color:var(--crm-text)">{{ $investment->expenses->count() }}</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1.6fr;gap:1rem;align-items:start">

        {{-- Idea Details --}}
        <div class="crm-card">
            <h3 style="font-size:0.875rem;font-weight:600;color:var(--crm-text);margin:0 0 1rem">Idea Details</h3>
            <p style="font-size:0.875rem;color:var(--crm-text-muted);line-height:1.65;margin:0;white-space:pre-wrap">{{ $investment->idea_details }}</p>
        </div>

        {{-- Expenses --}}
        <div class="crm-card" style="padding:0;overflow:hidden">
            <div style="padding:1rem 1.5rem;border-bottom:1px solid var(--crm-border);display:flex;align-items:center;justify-content:space-between">
                <h3 style="font-size:0.875rem;font-weight:600;color:var(--crm-text);margin:0">Expenses</h3>
                @can('investment.create')
                    <button type="button" class="btn btn-primary btn-sm"
                        onclick="document.getElementById('add-expense-form').classList.toggle('hidden')"
                    ><i class="ri-add-line"></i> Add Expense</button>
                @endcan
            </div>

            {{-- Add expense form --}}
            @can('investment.create')
                <div id="add-expense-form" class="hidden" style="padding:1rem 1.5rem;border-bottom:1px solid var(--crm-border);background:var(--crm-hover)">
                    <form method="POST" action="{{ route('admin.investments.expenses.store', $investment) }}">
                        @csrf
                        <div class="form-grid-2" style="gap:0.75rem">
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label">Purpose <span style="color:#F87171">*</span></label>
                                <input type="text" name="spend_purpose" class="form-control" placeholder="e.g. Software License">
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label">Amount <span style="color:#F87171">*</span></label>
                                <input type="number" name="amount" step="0.01" min="0.01" class="form-control" placeholder="0.00">
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label">Date <span style="color:#F87171">*</span></label>
                                <input type="date" name="date" class="form-control" value="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label">Details <span style="color:#F87171">*</span></label>
                                <input type="text" name="details" class="form-control" placeholder="What was this for?">
                            </div>
                            <div class="form-group" style="grid-column:span 2;margin-bottom:0">
                                <label class="form-label">Output / Result</label>
                                <input type="text" name="output" class="form-control" placeholder="What was achieved?">
                            </div>
                        </div>
                        <div style="display:flex;justify-content:flex-end;gap:0.5rem;margin-top:0.75rem">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('add-expense-form').classList.add('hidden')">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="ri-save-line"></i> Save Expense</button>
                        </div>
                    </form>
                </div>
            @endcan

            <div style="overflow-x:auto">
                <table class="crm-table" style="min-width:500px">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Purpose</th>
                            <th>Amount</th>
                            <th>Output</th>
                            @can('investment.delete')<th style="text-align:right">Action</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($investment->expenses->sortByDesc('date') as $expense)
                            <tr>
                                <td style="font-size:0.8rem;white-space:nowrap;color:var(--crm-text-muted)">{{ $expense->date->format('d M Y') }}</td>
                                <td>
                                    <div style="font-size:0.875rem;font-weight:500;color:var(--crm-text)">{{ $expense->spend_purpose }}</div>
                                    <div style="font-size:0.75rem;color:var(--crm-text-muted)">{{ Str::limit($expense->details, 50) }}</div>
                                </td>
                                <td style="font-size:0.875rem;font-weight:600;color:#F87171;white-space:nowrap">{{ number_format($expense->amount, 0) }} {{ $investment->currency }}</td>
                                <td style="font-size:0.8rem;color:var(--crm-text-muted)">{{ $expense->output ? Str::limit($expense->output, 40) : '—' }}</td>
                                @can('investment.delete')
                                    <td>
                                        <form id="del-exp-{{ $expense->id }}" method="POST" action="{{ route('admin.investments.expenses.destroy', [$investment, $expense]) }}" style="display:flex;justify-content:flex-end">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteForm(this)"
                                                data-form="del-exp-{{ $expense->id }}"
                                                data-label="this expense">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;padding:2rem;color:var(--crm-text-muted);font-size:0.875rem;opacity:0.6">No expenses added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-layouts.backend>
