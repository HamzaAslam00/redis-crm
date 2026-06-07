<div>

    {{-- Summary strip --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.25rem">
        <div class="crm-card" style="padding:1rem 1.25rem">
            <div style="font-size:0.7rem;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.35rem">
                {{ $monthFilter ? 'Month Income' : 'Total Income' }}
            </div>
            <div style="font-size:1.3rem;font-weight:700;font-family:'Syne',sans-serif;color:#34D399">
                PKR {{ number_format($summary['total_income'], 0) }}
            </div>
        </div>
        <div class="crm-card" style="padding:1rem 1.25rem">
            <div style="font-size:0.7rem;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.35rem">
                {{ $monthFilter ? 'Month Expenses' : 'Total Expenses' }}
            </div>
            <div style="font-size:1.3rem;font-weight:700;font-family:'Syne',sans-serif;color:#F87171">
                PKR {{ number_format($summary['total_expense'], 0) }}
            </div>
        </div>
        <div class="crm-card" style="padding:1rem 1.25rem">
            <div style="font-size:0.7rem;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.35rem">Net</div>
            <div style="font-size:1.3rem;font-weight:700;font-family:'Syne',sans-serif;color:{{ $summary['net'] >= 0 ? '#34D399' : '#F87171' }}">
                {{ $summary['net'] >= 0 ? '+' : '' }}PKR {{ number_format($summary['net'], 0) }}
            </div>
        </div>
    </div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        {{-- Toolbar --}}
        <div class="table-filters">

            {{-- Tabs --}}
            <div style="display:flex;gap:0;border:1px solid var(--crm-border);border-radius:8px;overflow:hidden">
                <button wire:click="$set('tab', 'expenses')"
                    style="padding:0.4rem 1rem;border:none;font-size:0.8rem;font-weight:600;cursor:pointer;background:{{ $tab === 'expenses' ? '#FF6400' : 'transparent' }};color:{{ $tab === 'expenses' ? '#fff' : 'var(--crm-text-muted)' }};transition:all 0.15s">
                    Expenses
                </button>
                <button wire:click="$set('tab', 'incomes')"
                    style="padding:0.4rem 1rem;border:none;font-size:0.8rem;font-weight:600;cursor:pointer;background:{{ $tab === 'incomes' ? '#FF6400' : 'transparent' }};color:{{ $tab === 'incomes' ? '#fff' : 'var(--crm-text-muted)' }};transition:all 0.15s">
                    Income
                </button>
            </div>

            <input wire:model.live="monthFilter" type="month" class="form-control" style="width:auto;min-width:150px">

            @if($tab === 'expenses')
                <select wire:model.live="typeFilter" class="form-control" style="min-width:140px;width:auto">
                    <option value="">All Types</option>
                    @foreach($types as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            @endif

            <div style="margin-left:auto;display:flex;gap:0.5rem">
                @can('budget.create')
                    @if($tab === 'expenses')
                        <a href="{{ route('admin.budget.expenses.create') }}" class="btn btn-primary" style="white-space:nowrap">
                            <i class="ri-add-line"></i> Add Expense
                        </a>
                    @else
                        <a href="{{ route('admin.budget.incomes.create') }}" class="btn btn-primary" style="white-space:nowrap">
                            <i class="ri-add-line"></i> Add Income
                        </a>
                    @endif
                @endcan
            </div>

        </div>

        <div wire:loading.flex style="position:absolute;inset:0;background:rgba(0,0,0,0.25);backdrop-filter:blur(2px);z-index:10;align-items:center;justify-content:center">
            <div style="width:34px;height:34px;border:3px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite"></div>
        </div>

        {{-- Expenses Table --}}
        @if($tab === 'expenses')
            <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
                <table class="crm-table" style="min-width:580px">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Reason</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th style="text-align:right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses ?? [] as $expense)
                            @php
                                $typeColors = \App\Models\BudgetExpense::$typeColors;
                                $tc = $typeColors[$expense->type] ?? '#94A3B8';
                            @endphp
                            <tr>
                                <td style="font-size:0.825rem;white-space:nowrap;color:var(--crm-text-muted)">{{ $expense->date->format('d M Y') }}</td>
                                <td style="font-size:0.875rem;color:var(--crm-text)">{{ $expense->reason }}</td>
                                <td>
                                    <span style="display:inline-flex;align-items:center;padding:0.15rem 0.6rem;border-radius:50px;font-size:0.7rem;font-weight:600;background:{{ $tc }}26;color:{{ $tc }}">
                                        {{ \App\Models\BudgetExpense::$types[$expense->type] ?? $expense->type }}
                                    </span>
                                </td>
                                <td style="font-size:0.875rem;font-weight:600;color:#F87171;white-space:nowrap">
                                    {{ number_format($expense->amount, 0) }} {{ $expense->currency }}
                                </td>
                                <td style="font-size:0.8rem;color:var(--crm-text-muted)">{{ $expense->note ?: '—' }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5rem">
                                        @can('budget.edit')
                                            <a href="{{ route('admin.budget.expenses.edit', $expense) }}" class="btn btn-secondary btn-sm" title="Edit"><i class="ri-pencil-line"></i></a>
                                        @endcan
                                        @can('budget.delete')
                                            <button type="button" class="btn btn-danger btn-sm" title="Delete"
                                                onclick="if(confirm('Delete this expense?')) $wire.deleteExpense({{ $expense->id }})"><i class="ri-delete-bin-line"></i></button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:3.5rem 1rem;color:var(--crm-text-muted)">
                                    <i class="ri-money-dollar-circle-line" style="font-size:2.5rem;display:block;margin-bottom:0.5rem;opacity:0.3"></i>
                                    <span style="font-size:0.875rem">No expenses recorded</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-pagination">
                <span>
                    @if(($expenses?->total() ?? 0) > 0)
                        Showing <strong>{{ $expenses->firstItem() }}</strong>–<strong>{{ $expenses->lastItem() }}</strong> of <strong>{{ $expenses->total() }}</strong>
                    @else
                        No results
                    @endif
                </span>
                @if($expenses?->hasPages())
                    <div style="display:flex;align-items:center;gap:0.4rem">
                        @if($expenses->onFirstPage())
                            <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-left-s-line"></i></span>
                        @else
                            <button wire:click="previousPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-s-line"></i></button>
                        @endif
                        <span style="font-size:0.8rem;padding:0 0.5rem">{{ $expenses->currentPage() }} / {{ $expenses->lastPage() }}</span>
                        @if($expenses->hasMorePages())
                            <button wire:click="nextPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-right-s-line"></i></button>
                        @else
                            <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-right-s-line"></i></span>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        {{-- Income Table --}}
        @if($tab === 'incomes')
            <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
                <table class="crm-table" style="min-width:520px">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Source</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th style="text-align:right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incomes ?? [] as $income)
                            <tr>
                                <td style="font-size:0.825rem;white-space:nowrap;color:var(--crm-text-muted)">{{ $income->date->format('d M Y') }}</td>
                                <td style="font-size:0.875rem;color:var(--crm-text)">{{ $income->source }}</td>
                                <td style="font-size:0.875rem;font-weight:600;color:#34D399;white-space:nowrap">
                                    +{{ number_format($income->amount, 0) }} {{ $income->currency }}
                                </td>
                                <td style="font-size:0.8rem;color:var(--crm-text-muted)">{{ $income->note ?: '—' }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5rem">
                                        @can('budget.edit')
                                            <a href="{{ route('admin.budget.incomes.edit', $income) }}" class="btn btn-secondary btn-sm" title="Edit"><i class="ri-pencil-line"></i></a>
                                        @endcan
                                        @can('budget.delete')
                                            <button type="button" class="btn btn-danger btn-sm" title="Delete"
                                                onclick="if(confirm('Delete this income record?')) $wire.deleteIncome({{ $income->id }})"><i class="ri-delete-bin-line"></i></button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;padding:3.5rem 1rem;color:var(--crm-text-muted)">
                                    <i class="ri-bank-line" style="font-size:2.5rem;display:block;margin-bottom:0.5rem;opacity:0.3"></i>
                                    <span style="font-size:0.875rem">No income recorded</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-pagination">
                <span>
                    @if(($incomes?->total() ?? 0) > 0)
                        Showing <strong>{{ $incomes->firstItem() }}</strong>–<strong>{{ $incomes->lastItem() }}</strong> of <strong>{{ $incomes->total() }}</strong>
                    @else
                        No results
                    @endif
                </span>
                @if($incomes?->hasPages())
                    <div style="display:flex;align-items:center;gap:0.4rem">
                        @if($incomes->onFirstPage())
                            <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-left-s-line"></i></span>
                        @else
                            <button wire:click="previousPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-s-line"></i></button>
                        @endif
                        <span style="font-size:0.8rem;padding:0 0.5rem">{{ $incomes->currentPage() }} / {{ $incomes->lastPage() }}</span>
                        @if($incomes->hasMorePages())
                            <button wire:click="nextPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-right-s-line"></i></button>
                        @else
                            <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-right-s-line"></i></span>
                        @endif
                    </div>
                @endif
            </div>
        @endif

    </div>

</div>
