<div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        <div class="table-filters">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search by person name…">
            </div>

            <select wire:model.live="statusFilter" class="form-control" style="min-width:140px;width:auto">
                <option value="">All Statuses</option>
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>

            @can('investment.create')
                <a href="{{ route('admin.investments.create') }}" class="btn btn-primary" style="margin-left:auto;white-space:nowrap">
                    <i class="ri-add-line"></i> New Investment
                </a>
            @endcan
        </div>

        <div wire:loading.flex style="position:absolute;inset:0;background:rgba(0,0,0,0.25);backdrop-filter:blur(2px);z-index:10;align-items:center;justify-content:center">
            <div style="width:34px;height:34px;border:3px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite"></div>
        </div>

        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
            <table class="crm-table" style="min-width:600px">
                <thead>
                    <tr>
                        <th>
                            <button wire:click="sort('person_name')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Person
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'person_name' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'person_name' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th>Status</th>
                        <th>Invested</th>
                        <th>Spent</th>
                        <th>Remaining</th>
                        <th>
                            <button wire:click="sort('start_date')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Started
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'start_date' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'start_date' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($investments as $inv)
                        @php
                            $sc = match($inv->status) {
                                'active'    => ['bg' => 'rgba(52,211,153,0.15)',   'color' => '#34D399'],
                                'completed' => ['bg' => 'rgba(96,165,250,0.15)',   'color' => '#60A5FA'],
                                'paused'    => ['bg' => 'rgba(251,191,36,0.15)',   'color' => '#FBBF24'],
                                'cancelled' => ['bg' => 'rgba(248,113,113,0.15)',  'color' => '#F87171'],
                                default     => ['bg' => 'rgba(148,163,184,0.15)',  'color' => '#94A3B8'],
                            };
                            $spent     = (float) ($inv->expenses_sum_amount ?? 0);
                            $invested  = (float) ($inv->amount ?? 0);
                            $remaining = $invested - $spent;
                        @endphp
                        <tr>
                            <td style="font-size:0.875rem;font-weight:600;color:var(--crm-text)">{{ $inv->person_name }}</td>
                            <td>
                                <span style="display:inline-flex;align-items:center;padding:0.2rem 0.65rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:{{ $sc['bg'] }};color:{{ $sc['color'] }}">
                                    {{ $statuses[$inv->status] ?? $inv->status }}
                                </span>
                            </td>
                            <td style="font-size:0.825rem;color:var(--crm-text-muted)">
                                {{ $invested ? number_format($invested, 0) . ' ' . $inv->currency : '—' }}
                            </td>
                            <td style="font-size:0.825rem;color:#F87171">
                                {{ $spent ? number_format($spent, 0) . ' ' . $inv->currency : '—' }}
                            </td>
                            <td style="font-size:0.825rem;color:{{ $remaining >= 0 ? '#34D399' : '#F87171' }};font-weight:600">
                                {{ number_format($remaining, 0) }} {{ $inv->currency }}
                            </td>
                            <td style="font-size:0.825rem;color:var(--crm-text-muted);white-space:nowrap">
                                {{ $inv->start_date->format('d M Y') }}
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5rem">
                                    <a href="{{ route('admin.investments.show', $inv) }}" class="btn btn-secondary btn-sm" title="View">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    @can('investment.edit')
                                        <a href="{{ route('admin.investments.edit', $inv) }}" class="btn btn-secondary btn-sm" title="Edit">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                    @endcan
                                    @can('investment.delete')
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                            title="Delete"
                                            onclick="if(confirm('Delete this investment? All expenses will be removed.')) $wire.deleteInvestment({{ $inv->id }})"
                                        ><i class="ri-delete-bin-line"></i></button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:3.5rem 1rem;color:var(--crm-text-muted)">
                                <i class="ri-briefcase-line" style="font-size:2.5rem;display:block;margin-bottom:0.5rem;opacity:0.3"></i>
                                <span style="font-size:0.875rem">No investments found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination">
            <span>
                @if($investments->total() > 0)
                    Showing <strong>{{ $investments->firstItem() }}</strong>–<strong>{{ $investments->lastItem() }}</strong> of <strong>{{ $investments->total() }}</strong>
                @else
                    No results
                @endif
            </span>
            @if($investments->hasPages())
                <div style="display:flex;align-items:center;gap:0.4rem">
                    @if($investments->onFirstPage())
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-left-s-line"></i></span>
                    @else
                        <button wire:click="previousPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-s-line"></i></button>
                    @endif
                    <span style="font-size:0.8rem;padding:0 0.5rem">{{ $investments->currentPage() }} / {{ $investments->lastPage() }}</span>
                    @if($investments->hasMorePages())
                        <button wire:click="nextPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-right-s-line"></i></button>
                    @else
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-right-s-line"></i></span>
                    @endif
                </div>
            @endif
        </div>

    </div>

</div>
