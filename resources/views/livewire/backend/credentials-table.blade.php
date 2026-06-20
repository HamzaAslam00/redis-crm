<div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        <div class="table-filters">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search system, URL, IP…">
            </div>

            <select wire:model.live="typeFilter" class="form-control" style="width:auto;min-width:140px">
                <option value="">All Types</option>
                @foreach($credTypes as $k => $label)
                    <option value="{{ $k }}">{{ $label }}</option>
                @endforeach
            </select>

            <select wire:model.live="ownerFilter" class="form-control" style="width:auto;min-width:120px">
                <option value="">All Owners</option>
                @foreach($ownerTypes as $k => $label)
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
            <table class="crm-table" style="min-width:780px">
                <thead>
                    <tr>
                        <th>System</th>
                        <th>Type</th>
                        <th>Owner</th>
                        <th>Connection Info</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($credentials as $cred)
                        @php
                            $iconClass = \App\Models\Credential::$credTypeIcons[$cred->cred_type] ?? 'ri-lock-line';
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.5rem;min-width:0">
                                    <i class="{{ $iconClass }}" style="font-size:1.1rem;color:#FF6400;flex-shrink:0"></i>
                                    <div style="min-width:0">
                                        <div style="font-size:0.875rem;font-weight:600;color:var(--crm-text)">{{ $cred->system_name }}</div>
                                        @if($cred->url)
                                            <div style="font-size:0.75rem;color:var(--crm-text-muted);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:160px">{{ $cred->url }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.825rem;color:var(--crm-text-muted)">
                                {{ $credTypes[$cred->cred_type] ?? $cred->cred_type }}
                            </td>
                            <td>
                                <span style="display:inline-block;padding:0.2rem 0.6rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:{{ $cred->owner_type === 'client' ? 'rgba(96,165,250,0.15)' : 'rgba(167,139,250,0.15)' }};color:{{ $cred->owner_type === 'client' ? '#60A5FA' : '#A78BFA' }}">
                                    {{ $cred->owner_name ?: ucfirst($cred->owner_type) }}
                                </span>
                            </td>
                            <td style="font-size:0.8rem;color:var(--crm-text-muted)">
                                @if($cred->username)
                                    <div style="display:flex;align-items:center;gap:0.3rem">
                                        <i class="ri-user-line" style="font-size:0.75rem"></i>
                                        <code style="font-size:0.78rem">{{ $cred->username }}</code>
                                    </div>
                                @endif
                                @if($cred->ip_address)
                                    <div style="display:flex;align-items:center;gap:0.3rem;margin-top:0.2rem">
                                        <i class="ri-server-line" style="font-size:0.75rem"></i>
                                        <code style="font-size:0.78rem" onclick="navigator.clipboard.writeText('{{ $cred->ip_address }}');window.toast('IP copied','success')" style="cursor:pointer" title="Click to copy">{{ $cred->ip_address }}{{ $cred->port ? ':'.$cred->port : '' }}</code>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @can('credential.reveal')
                                    <div style="display:flex;align-items:center;gap:0.5rem"
                                        x-data="vaultReveal('{{ route('admin.credentials.reveal', $cred) }}')">
                                        <code class="vault-masked" x-show="!revealed">••••••••</code>
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
                                    <code class="vault-masked">••••••••</code>
                                @endcan
                            </td>
                            <td>
                                <span style="display:inline-block;padding:0.2rem 0.6rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:{{ $cred->is_active ? 'rgba(52,211,153,0.15)' : 'rgba(148,163,184,0.15)' }};color:{{ $cred->is_active ? '#34D399' : '#94A3B8' }}">
                                    {{ $cred->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5rem">
                                    @can('credential.edit')
                                        <a href="{{ route('admin.credentials.edit', $cred) }}" class="btn btn-secondary btn-sm" title="Edit"><i class="ri-pencil-line"></i></a>
                                    @endcan
                                    @can('credential.delete')
                                        <button type="button" class="btn btn-danger btn-sm" title="Delete"
                                            data-id="{{ $cred->id }}"
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
                                <i class="ri-shield-keyhole-line" style="font-size:2.5rem;display:block;margin-bottom:0.5rem;opacity:0.3"></i>
                                <span style="font-size:0.875rem">No credentials found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination">
            <span>
                @if($credentials->total() > 0)
                    Showing <strong>{{ $credentials->firstItem() }}</strong>–<strong>{{ $credentials->lastItem() }}</strong> of <strong>{{ $credentials->total() }}</strong>
                @else
                    No results
                @endif
            </span>
            @if($credentials->hasPages())
                <div style="display:flex;align-items:center;gap:0.4rem">
                    @if($credentials->onFirstPage())
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-left-s-line"></i></span>
                    @else
                        <button wire:click="previousPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-s-line"></i></button>
                    @endif
                    <span style="font-size:0.8rem;padding:0 0.5rem">{{ $credentials->currentPage() }} / {{ $credentials->lastPage() }}</span>
                    @if($credentials->hasMorePages())
                        <button wire:click="nextPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-right-s-line"></i></button>
                    @else
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-right-s-line"></i></span>
                    @endif
                </div>
            @endif
        </div>

    </div>

</div>
