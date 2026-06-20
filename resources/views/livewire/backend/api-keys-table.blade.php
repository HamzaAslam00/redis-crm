<div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        <div class="table-filters">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search provider or label…">
            </div>

            <select wire:model.live="typeFilter" class="form-control" style="width:auto;min-width:130px">
                <option value="">All Types</option>
                @foreach($keyTypes as $k => $label)
                    <option value="{{ $k }}">{{ $label }}</option>
                @endforeach
            </select>

            <select wire:model.live="envFilter" class="form-control" style="width:auto;min-width:130px">
                <option value="">All Envs</option>
                @foreach($environments as $k => $label)
                    <option value="{{ $k }}">{{ $label }}</option>
                @endforeach
            </select>

            <div style="display:flex;gap:0;border:1px solid var(--crm-border);border-radius:8px;overflow:hidden">
                @foreach(['active' => 'Active', 'inactive' => 'Inactive', '' => 'All'] as $key => $label)
                    <button wire:click="$set('statusFilter', '{{ $key }}')"
                        style="padding:0.4rem 0.9rem;border:none;font-size:0.8rem;font-weight:600;cursor:pointer;background:{{ $statusFilter === $key ? '#FF6400' : 'transparent' }};color:{{ $statusFilter === $key ? '#fff' : 'var(--crm-text-muted)' }};transition:all 0.15s">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

        </div>

        <div wire:loading.flex style="position:absolute;inset:0;background:rgba(0,0,0,0.25);backdrop-filter:blur(2px);z-index:10;align-items:center;justify-content:center">
            <div style="width:34px;height:34px;border:3px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite"></div>
        </div>

        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
            <table class="crm-table" style="min-width:700px">
                <thead>
                    <tr>
                        <th>Provider / Label</th>
                        <th>Type</th>
                        <th>Environment</th>
                        <th>Key Value</th>
                        <th>Expires</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($apiKeys as $key)
                        @php
                            $envColors = ['production' => ['bg' => 'rgba(248,113,113,0.15)', 'color' => '#F87171'], 'staging' => ['bg' => 'rgba(251,191,36,0.15)', 'color' => '#FBBF24'], 'development' => ['bg' => 'rgba(52,211,153,0.15)', 'color' => '#34D399']];
                            $env = $envColors[$key->environment] ?? ['bg' => 'rgba(148,163,184,0.15)', 'color' => '#94A3B8'];
                        @endphp
                        <tr>
                            <td>
                                <div style="font-size:0.875rem;font-weight:600;color:var(--crm-text)">{{ $key->provider_name }}</div>
                                <div style="font-size:0.775rem;color:var(--crm-text-muted)">{{ $key->key_label }}</div>
                            </td>
                            <td style="font-size:0.825rem;color:var(--crm-text-muted)">
                                {{ $keyTypes[$key->key_type] ?? $key->key_type }}
                            </td>
                            <td>
                                <span style="display:inline-block;padding:0.2rem 0.6rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:{{ $env['bg'] }};color:{{ $env['color'] }}">
                                    {{ ucfirst($key->environment) }}
                                </span>
                            </td>
                            <td>
                                @can('apikey.reveal')
                                    <div style="display:flex;align-items:center;gap:0.5rem"
                                        x-data="vaultReveal('{{ route('admin.api-keys.reveal', $key) }}')">
                                        <code class="vault-masked" x-show="!revealed">••••••••••••</code>
                                        <code class="vault-value" x-show="revealed" x-text="value"></code>
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            x-on:click="revealed ? hide() : reveal()">
                                            <span x-text="revealed ? 'Hide (' + timer + 's)' : 'Reveal'"></span>
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-sm" title="Copy"
                                            x-show="revealed"
                                            x-on:click="copy()">
                                            <i class="ri-clipboard-line"></i>
                                        </button>
                                    </div>
                                @else
                                    <code class="vault-masked">••••••••••••</code>
                                @endcan
                            </td>
                            <td style="font-size:0.825rem;white-space:nowrap">
                                @if($key->expires_at)
                                    <span style="color:{{ $key->is_expired ? '#F87171' : 'var(--crm-text-muted)' }}">
                                        {{ $key->expires_at->format('d M Y') }}
                                        @if($key->is_expired) <i class="ri-alarm-warning-line"></i> @endif
                                    </span>
                                @else
                                    <span style="color:var(--crm-text-muted)">—</span>
                                @endif
                            </td>
                            <td>
                                <span style="display:inline-block;padding:0.2rem 0.6rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:{{ $key->is_active ? 'rgba(52,211,153,0.15)' : 'rgba(148,163,184,0.15)' }};color:{{ $key->is_active ? '#34D399' : '#94A3B8' }}">
                                    {{ $key->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5rem">
                                    @can('apikey.edit')
                                        <a href="{{ route('admin.api-keys.edit', $key) }}" class="btn btn-secondary btn-sm" title="Edit"><i class="ri-pencil-line"></i></a>
                                    @endcan
                                    @can('apikey.delete')
                                        <button type="button" class="btn btn-danger btn-sm" title="Delete"
                                            data-id="{{ $key->id }}"
                                            x-on:click="deleteWire($el, $wire)">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:3.5rem 1rem;color:var(--crm-text-muted)">
                                <i class="ri-key-2-line" style="font-size:2.5rem;display:block;margin-bottom:0.5rem;opacity:0.3"></i>
                                <span style="font-size:0.875rem">No API keys found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination">
            <span>
                @if($apiKeys->total() > 0)
                    Showing <strong>{{ $apiKeys->firstItem() }}</strong>–<strong>{{ $apiKeys->lastItem() }}</strong> of <strong>{{ $apiKeys->total() }}</strong>
                @else
                    No results
                @endif
            </span>
            @if($apiKeys->hasPages())
                <div style="display:flex;align-items:center;gap:0.4rem">
                    @if($apiKeys->onFirstPage())
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-left-s-line"></i></span>
                    @else
                        <button wire:click="previousPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-s-line"></i></button>
                    @endif
                    <span style="font-size:0.8rem;padding:0 0.5rem">{{ $apiKeys->currentPage() }} / {{ $apiKeys->lastPage() }}</span>
                    @if($apiKeys->hasMorePages())
                        <button wire:click="nextPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-right-s-line"></i></button>
                    @else
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-right-s-line"></i></span>
                    @endif
                </div>
            @endif
        </div>

    </div>

</div>
