<div>
    {{-- Modal Form --}}
    @if($showForm)
    <div style="position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1000;display:flex;align-items:center;justify-content:center;padding:1rem">
        <div class="crm-card" style="width:100%;max-width:580px;max-height:90vh;overflow-y:auto">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
                <h3 style="font-size:1rem;font-weight:700;margin:0">{{ $editingId ? 'Edit Backlink' : 'Add Backlink' }}</h3>
                <button type="button" wire:click="$set('showForm',false)" style="border:none;background:none;font-size:1.4rem;cursor:pointer;color:var(--crm-text-muted);line-height:1">&times;</button>
            </div>

            <div class="form-group">
                <label class="form-label">Source URL * <span style="font-weight:400;color:var(--crm-text-muted)">(the page linking TO you)</span></label>
                <input type="url" wire:model="source_url" class="form-control" placeholder="https://example.com/your-article">
                @error('source_url') <div style="color:#ef4444;font-size:0.78rem;margin-top:4px">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
                <div class="form-group">
                    <label class="form-label">Target URL * <span style="font-weight:400;color:var(--crm-text-muted)">(your page)</span></label>
                    <input type="text" wire:model="target_url" class="form-control" placeholder="/ or /services">
                    @error('target_url') <div style="color:#ef4444;font-size:0.78rem;margin-top:4px">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Anchor Text</label>
                    <input type="text" wire:model="anchor_text" class="form-control" placeholder="click here / redis solution">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0.75rem">
                <div class="form-group">
                    <label class="form-label">Link Type</label>
                    <select wire:model="link_type" class="form-control">
                        <option value="dofollow">Dofollow</option>
                        <option value="nofollow">Nofollow</option>
                        <option value="sponsored">Sponsored</option>
                        <option value="ugc">UGC</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Domain Authority</label>
                    <input type="number" wire:model="domain_authority" class="form-control" placeholder="0-100" min="0" max="100">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select wire:model="formStatus" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="broken">Broken</option>
                        <option value="lost">Lost</option>
                    </select>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
                <div class="form-group">
                    <label class="form-label">Discovered Date *</label>
                    <input type="date" wire:model="discovered_at" class="form-control">
                    @error('discovered_at') <div style="color:#ef4444;font-size:0.78rem;margin-top:4px">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Last Checked</label>
                    <input type="date" wire:model="last_checked_at" class="form-control">
                </div>
            </div>

            <div class="form-group" style="margin-bottom:1.25rem">
                <label class="form-label">Notes</label>
                <textarea wire:model="notes" class="form-control" rows="2" placeholder="Context about this backlink..."></textarea>
            </div>

            <div style="display:flex;gap:0.75rem;justify-content:flex-end">
                <button type="button" wire:click="$set('showForm',false)" class="btn btn-secondary">Cancel</button>
                <button type="button" wire:click="save" class="btn btn-primary" data-loading-text="Saving…">
                    {{ $editingId ? 'Update' : 'Add Backlink' }}
                </button>
            </div>
        </div>
    </div>
    @endif

    <div class="crm-card" style="padding:0;overflow:hidden">
        {{-- Toolbar --}}
        <div class="table-filters">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search domain, anchor, URL…">
            </div>
            <div style="display:flex;gap:0.5rem;align-items:center;margin-left:auto">
                <div style="display:flex;border:1px solid var(--crm-border);border-radius:8px;overflow:hidden">
                    @foreach(['' => 'All', 'active' => 'Active', 'pending' => 'Pending', 'broken' => 'Broken', 'lost' => 'Lost'] as $val => $label)
                        <button wire:click="$set('statusFilter','{{ $val }}')"
                            style="padding:0.4rem 0.7rem;border:none;font-size:0.78rem;font-weight:600;cursor:pointer;background:{{ $statusFilter === $val ? '#FF6400' : 'transparent' }};color:{{ $statusFilter === $val ? '#fff' : 'var(--crm-text-muted)' }};transition:all 0.15s">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
                <button wire:click="openCreate" class="btn btn-primary" style="white-space:nowrap">
                    <i class="ri-add-line"></i> Add Backlink
                </button>
            </div>
        </div>

        <div style="overflow-x:auto">
            <table class="crm-table" style="min-width:820px">
                <thead>
                    <tr>
                        <th>Source Domain</th>
                        <th>Anchor Text</th>
                        <th style="width:90px;text-align:center">Target</th>
                        <th style="width:80px;text-align:center">Type</th>
                        <th style="width:50px;text-align:center">DA</th>
                        <th style="width:90px;text-align:center">Status</th>
                        <th style="width:100px">Discovered</th>
                        <th style="width:80px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backlinks as $bl)
                        <tr>
                            <td>
                                <a href="{{ $bl->source_url }}" target="_blank" style="font-weight:600;font-size:0.88rem;color:#FF6400;text-decoration:none">
                                    {{ $bl->source_domain }}
                                </a>
                                <div style="font-size:0.72rem;color:var(--crm-text-muted);margin-top:1px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:200px" title="{{ $bl->source_url }}">
                                    {{ $bl->source_url }}
                                </div>
                            </td>
                            <td style="font-size:0.85rem">{{ $bl->anchor_text ?: '—' }}</td>
                            <td style="text-align:center;font-size:0.78rem;color:var(--crm-text-muted);font-family:monospace">{{ $bl->target_url }}</td>
                            <td style="text-align:center">
                                <span style="font-size:0.72rem;font-weight:700;padding:2px 7px;border-radius:20px;background:{{ $bl->linkTypeColor() }}22;color:{{ $bl->linkTypeColor() }}">
                                    {{ ucfirst($bl->link_type) }}
                                </span>
                            </td>
                            <td style="text-align:center;font-weight:700;font-size:0.88rem">
                                {{ $bl->domain_authority ?? '—' }}
                            </td>
                            <td style="text-align:center">
                                <span style="font-size:0.72rem;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $bl->statusColor() }}22;color:{{ $bl->statusColor() }}">
                                    {{ $bl->statusLabel() }}
                                </span>
                            </td>
                            <td style="font-size:0.82rem;color:var(--crm-text-muted)">
                                {{ $bl->discovered_at->format('d M Y') }}
                            </td>
                            <td>
                                <div style="display:flex;gap:0.3rem">
                                    <button wire:click="openEdit({{ $bl->id }})"
                                        style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border:1px solid var(--crm-border);border-radius:5px;background:var(--crm-card);color:var(--crm-text);cursor:pointer;font-size:0.85rem">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button wire:click="delete({{ $bl->id }})" wire:confirm="Remove this backlink?"
                                        style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border:1px solid var(--crm-border);border-radius:5px;background:var(--crm-card);color:#ef4444;cursor:pointer;font-size:0.85rem">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:3rem;color:var(--crm-text-muted)">
                                <i class="ri-links-line" style="font-size:2.5rem;display:block;margin-bottom:0.75rem;opacity:0.4"></i>
                                No backlinks logged yet. Add your first backlink to start tracking.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($backlinks->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid var(--crm-border)">
                {{ $backlinks->links() }}
            </div>
        @endif
    </div>
</div>
