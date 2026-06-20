<div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        <div class="table-filters">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search client or domain…">
            </div>

            <div style="display:flex;gap:0;border:1px solid var(--crm-border);border-radius:8px;overflow:hidden">
                @foreach(['all' => 'All', 'active' => 'Active', 'inactive' => 'Inactive'] as $key => $label)
                    <button wire:click="$set('statusFilter', '{{ $key }}')"
                        style="padding:0.4rem 0.9rem;border:none;font-size:0.8rem;font-weight:600;cursor:pointer;background:{{ $statusFilter === $key ? '#FF6400' : 'transparent' }};color:{{ $statusFilter === $key ? '#fff' : 'var(--crm-text-muted)' }};transition:all 0.15s">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            @can('hosting.create')
                <a href="{{ route('admin.hosting.create') }}" class="btn btn-primary" style="margin-left:auto;white-space:nowrap">
                    <i class="ri-add-line"></i> Add Client
                </a>
            @endcan
        </div>

        <div wire:loading.flex style="position:absolute;inset:0;background:rgba(0,0,0,0.25);backdrop-filter:blur(2px);z-index:10;align-items:center;justify-content:center">
            <div style="width:34px;height:34px;border:3px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite"></div>
        </div>

        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
            <table class="crm-table" style="min-width:720px">
                <thead>
                    <tr>
                        <th>
                            <button wire:click="sort('client_name')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Client / Domain
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'client_name' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'client_name' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th>Usage</th>
                        <th>Provider</th>
                        <th>Renewal Status</th>
                        <th>
                            <button wire:click="sort('starting_date')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Next Renewal
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1"></i>
                                </span>
                            </button>
                        </th>
                        <th>Amount</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        @php
                            $renewalStatus = $client->renewal_status;
                            $daysUntil     = $client->days_until_renewal;
                            $nextRenewal   = $client->next_renewal_date;

                            $statusBadge = match($renewalStatus) {
                                'ok'       => ['bg' => 'rgba(52,211,153,0.15)',  'color' => '#34D399', 'label' => 'OK'],
                                'due_soon' => ['bg' => 'rgba(251,191,36,0.15)',  'color' => '#FBBF24', 'label' => 'Due Soon'],
                                'overdue'  => ['bg' => 'rgba(248,113,113,0.15)', 'color' => '#F87171', 'label' => 'Overdue'],
                                'inactive' => ['bg' => 'rgba(148,163,184,0.15)', 'color' => '#94A3B8', 'label' => 'Inactive'],
                                default    => ['bg' => 'rgba(148,163,184,0.15)', 'color' => '#94A3B8', 'label' => '—'],
                            };

                            $usageLabels = \App\Models\HostingClient::$serverUsages;
                        @endphp
                        <tr>
                            <td>
                                <div style="min-width:0">
                                    <div style="font-size:0.875rem;font-weight:600;color:var(--crm-text)">{{ $client->client_name }}</div>
                                    <div style="font-size:0.775rem;color:var(--crm-text-muted);display:flex;align-items:center;gap:0.35rem">
                                        <i class="ri-global-line" style="font-size:0.7rem"></i>
                                        {{ $client->domain_name }}
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.8rem;color:var(--crm-text-muted);white-space:nowrap">
                                {{ $usageLabels[$client->server_usage] ?? $client->server_usage }}
                            </td>
                            <td style="font-size:0.825rem;color:var(--crm-text-muted)">{{ $client->hosting_provider ?: '—' }}</td>
                            <td>
                                <span style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.2rem 0.65rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:{{ $statusBadge['bg'] }};color:{{ $statusBadge['color'] }}">
                                    {{ $statusBadge['label'] }}
                                    @if($renewalStatus !== 'inactive' && $renewalStatus !== 'ok')
                                        @if($daysUntil < 0)
                                            ({{ abs($daysUntil) }}d ago)
                                        @else
                                            ({{ $daysUntil }}d)
                                        @endif
                                    @endif
                                </span>
                            </td>
                            <td style="font-size:0.825rem;white-space:nowrap;color:{{ $renewalStatus === 'overdue' ? '#F87171' : ($renewalStatus === 'due_soon' ? '#FBBF24' : 'var(--crm-text-muted)') }}">
                                {{ $client->is_active ? $nextRenewal->format('d M Y') : '—' }}
                            </td>
                            <td style="font-size:0.825rem;color:var(--crm-text-muted);white-space:nowrap">
                                {{ number_format($client->amount, 0) }} {{ $client->currency }}
                                <span style="font-size:0.7rem;opacity:0.7">/ {{ \App\Models\HostingClient::$renewDurations[$client->renew_duration] ?? '' }}</span>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5rem">
                                    @can('hosting.edit')
                                        <a href="{{ route('admin.hosting.edit', $client) }}" class="btn btn-secondary btn-sm" title="Edit"><i class="ri-pencil-line"></i></a>
                                    @endcan
                                    @can('hosting.delete')
                                        <button type="button" class="btn btn-danger btn-sm" title="Delete"
                                            data-id="{{ $client->id }}"
                                            x-on:click="deleteWire($el, $wire)"><i class="ri-delete-bin-line"></i></button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:3.5rem 1rem;color:var(--crm-text-muted)">
                                <i class="ri-server-line" style="font-size:2.5rem;display:block;margin-bottom:0.5rem;opacity:0.3"></i>
                                <span style="font-size:0.875rem">No hosting clients found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination">
            <span>
                @if($clients->total() > 0)
                    Showing <strong>{{ $clients->firstItem() }}</strong>–<strong>{{ $clients->lastItem() }}</strong> of <strong>{{ $clients->total() }}</strong>
                @else
                    No results
                @endif
            </span>
            @if($clients->hasPages())
                <div style="display:flex;align-items:center;gap:0.4rem">
                    @if($clients->onFirstPage())
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-left-s-line"></i></span>
                    @else
                        <button wire:click="previousPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-s-line"></i></button>
                    @endif
                    <span style="font-size:0.8rem;padding:0 0.5rem">{{ $clients->currentPage() }} / {{ $clients->lastPage() }}</span>
                    @if($clients->hasMorePages())
                        <button wire:click="nextPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-right-s-line"></i></button>
                    @else
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-right-s-line"></i></span>
                    @endif
                </div>
            @endif
        </div>

    </div>

</div>
