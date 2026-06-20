<div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        <div class="table-filters" style="flex-wrap:wrap;row-gap:0.5rem">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search description…">
            </div>

            <select wire:model.live="logFilter" class="form-control" style="width:auto;min-width:130px">
                <option value="">All Modules</option>
                @foreach($logNames as $name)
                    <option value="{{ $name }}">{{ ucfirst($name) }}</option>
                @endforeach
            </select>

            <select wire:model.live="causerFilter" class="form-control" style="width:auto;min-width:130px">
                <option value="">All Users</option>
                @foreach($causers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <input wire:model.live="dateFrom" type="date" class="form-control" style="width:auto" title="From date">
            <input wire:model.live="dateTo" type="date" class="form-control" style="width:auto" title="To date">

            @if($search || $logFilter || $causerFilter || $dateFrom || $dateTo)
                <button wire:click="$set('search','');$set('logFilter','');$set('causerFilter','');$set('dateFrom','');$set('dateTo','')"
                    class="btn btn-secondary btn-sm" title="Clear filters">
                    <i class="ri-close-line"></i> Clear
                </button>
            @endif
        </div>

        <div wire:loading.flex style="position:absolute;inset:0;background:rgba(0,0,0,0.25);backdrop-filter:blur(2px);z-index:10;align-items:center;justify-content:center">
            <div style="width:34px;height:34px;border:3px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite"></div>
        </div>

        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
            <table class="crm-table" style="min-width:700px">
                <thead>
                    <tr>
                        <th>When</th>
                        <th>User</th>
                        <th>Module</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        @php
                            $moduleColors = [
                                'projects'    => ['bg' => 'rgba(96,165,250,0.15)',  'color' => '#60A5FA'],
                                'investments' => ['bg' => 'rgba(167,139,250,0.15)', 'color' => '#A78BFA'],
                                'budget'      => ['bg' => 'rgba(52,211,153,0.15)',  'color' => '#34D399'],
                                'hosting'     => ['bg' => 'rgba(251,191,36,0.15)',  'color' => '#FBBF24'],
                                'api_keys'    => ['bg' => 'rgba(248,113,113,0.15)', 'color' => '#F87171'],
                                'credentials' => ['bg' => 'rgba(248,113,113,0.15)', 'color' => '#F87171'],
                                'users'       => ['bg' => 'rgba(244,114,182,0.15)', 'color' => '#F472B6'],
                            ];
                            $mc = $moduleColors[$log->log_name] ?? ['bg' => 'rgba(148,163,184,0.15)', 'color' => '#94A3B8'];
                        @endphp
                        <tr x-data="{ expanded: false }">
                            <td style="white-space:nowrap;font-size:0.8rem;color:var(--crm-text-muted)">
                                <div title="{{ $log->created_at->format('d M Y H:i:s') }}">{{ $log->created_at->diffForHumans() }}</div>
                                <div style="font-size:0.72rem">{{ $log->created_at->format('d M Y') }}</div>
                            </td>
                            <td style="font-size:0.825rem;font-weight:500;color:var(--crm-text)">
                                {{ $log->causer?->name ?? '—' }}
                            </td>
                            <td>
                                <span style="display:inline-block;padding:0.2rem 0.6rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:{{ $mc['bg'] }};color:{{ $mc['color'] }}">
                                    {{ ucfirst($log->log_name ?? 'system') }}
                                </span>
                            </td>
                            <td style="font-size:0.825rem;color:var(--crm-text)">
                                {{ $log->description }}
                            </td>
                            <td>
                                @php $props = $log->properties->toArray(); @endphp
                                @if(!empty($props['attributes']) || !empty($props['old']))
                                    <button x-on:click="expanded = !expanded" class="btn btn-secondary btn-sm" style="font-size:0.72rem">
                                        <i x-bind:class="expanded ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line'"></i>
                                        <span x-text="expanded ? 'Hide' : 'Changes'"></span>
                                    </button>
                                    <div x-show="expanded" x-transition style="display:none;margin-top:0.5rem">
                                        @if(!empty($props['old']))
                                            <div style="font-size:0.72rem;color:var(--crm-text-muted);margin-bottom:0.35rem">
                                                <strong>Before:</strong>
                                                <code style="display:block;background:var(--crm-input);padding:0.35rem 0.5rem;border-radius:6px;margin-top:0.2rem;font-size:0.7rem;word-break:break-all">{{ json_encode($props['old'], JSON_PRETTY_PRINT) }}</code>
                                            </div>
                                        @endif
                                        @if(!empty($props['attributes']))
                                            <div style="font-size:0.72rem;color:var(--crm-text-muted)">
                                                <strong>After:</strong>
                                                <code style="display:block;background:var(--crm-input);padding:0.35rem 0.5rem;border-radius:6px;margin-top:0.2rem;font-size:0.7rem;word-break:break-all">{{ json_encode($props['attributes'], JSON_PRETTY_PRINT) }}</code>
                                            </div>
                                        @endif
                                    </div>
                                @elseif(!empty($props))
                                    <button x-on:click="expanded = !expanded" class="btn btn-secondary btn-sm" style="font-size:0.72rem">
                                        <i x-bind:class="expanded ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line'"></i>
                                        <span x-text="expanded ? 'Hide' : 'Info'"></span>
                                    </button>
                                    <div x-show="expanded" x-transition style="display:none;margin-top:0.5rem">
                                        <code style="display:block;background:var(--crm-input);padding:0.35rem 0.5rem;border-radius:6px;font-size:0.7rem;word-break:break-all">{{ json_encode($props, JSON_PRETTY_PRINT) }}</code>
                                    </div>
                                @else
                                    <span style="font-size:0.75rem;color:var(--crm-text-muted)">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:3.5rem 1rem;color:var(--crm-text-muted)">
                                <i class="ri-time-line" style="font-size:2.5rem;display:block;margin-bottom:0.5rem;opacity:0.3"></i>
                                <span style="font-size:0.875rem">No activity logs found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination">
            <span>
                @if($logs->total() > 0)
                    Showing <strong>{{ $logs->firstItem() }}</strong>–<strong>{{ $logs->lastItem() }}</strong> of <strong>{{ $logs->total() }}</strong>
                @else
                    No results
                @endif
            </span>
            @if($logs->hasPages())
                <div style="display:flex;align-items:center;gap:0.4rem">
                    @if($logs->onFirstPage())
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-left-s-line"></i></span>
                    @else
                        <button wire:click="previousPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-s-line"></i></button>
                    @endif
                    <span style="font-size:0.8rem;padding:0 0.5rem">{{ $logs->currentPage() }} / {{ $logs->lastPage() }}</span>
                    @if($logs->hasMorePages())
                        <button wire:click="nextPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-right-s-line"></i></button>
                    @else
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-right-s-line"></i></span>
                    @endif
                </div>
            @endif
        </div>

    </div>

</div>
