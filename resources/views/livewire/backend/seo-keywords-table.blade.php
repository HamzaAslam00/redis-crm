<div>
    {{-- Modal Form --}}
    @if($showForm)
    <div style="position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1000;display:flex;align-items:center;justify-content:center;padding:1rem">
        <div class="crm-card" style="width:100%;max-width:540px;max-height:90vh;overflow-y:auto">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
                <h3 style="font-size:1rem;font-weight:700;margin:0">{{ $editingId ? 'Edit Keyword' : 'Add Keyword' }}</h3>
                <button type="button" wire:click="$set('showForm',false)" style="border:none;background:none;font-size:1.4rem;cursor:pointer;color:var(--crm-text-muted);line-height:1">&times;</button>
            </div>

            <div class="form-group">
                <label class="form-label">Keyword *</label>
                <input type="text" wire:model="keyword" class="form-control" placeholder="e.g. web development company pakistan" autofocus>
                @error('keyword') <div style="color:#ef4444;font-size:0.78rem;margin-top:4px">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Target URL</label>
                <input type="text" wire:model="target_url" class="form-control" placeholder="/services or /about">
                @error('target_url') <div style="color:#ef4444;font-size:0.78rem;margin-top:4px">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0.75rem">
                <div class="form-group">
                    <label class="form-label">Priority</label>
                    <select wire:model="formPriority" class="form-control">
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Position</label>
                    <input type="number" wire:model="current_position" class="form-control" placeholder="#1-100" min="1" max="1000">
                </div>
                <div class="form-group">
                    <label class="form-label">Difficulty (0-100)</label>
                    <input type="number" wire:model="difficulty" class="form-control" placeholder="0-100" min="0" max="100">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Monthly Search Volume</label>
                <input type="number" wire:model="monthly_volume" class="form-control" placeholder="e.g. 1000">
            </div>

            <div class="form-group" style="margin-bottom:1.25rem">
                <label class="form-label">Notes</label>
                <textarea wire:model="notes" class="form-control" rows="2" placeholder="Any notes about this keyword..."></textarea>
            </div>

            <div style="display:flex;gap:0.75rem;justify-content:flex-end">
                <button type="button" wire:click="$set('showForm',false)" class="btn btn-secondary">Cancel</button>
                <button type="button" wire:click="save" class="btn btn-primary" data-loading-text="Saving…">
                    {{ $editingId ? 'Update' : 'Add Keyword' }}
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
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search keywords…">
            </div>
            <div style="display:flex;gap:0.5rem;align-items:center;margin-left:auto">
                <div style="display:flex;border:1px solid var(--crm-border);border-radius:8px;overflow:hidden">
                    @foreach(['' => 'All', 'high' => 'High', 'medium' => 'Medium', 'low' => 'Low'] as $val => $label)
                        <button wire:click="$set('priority','{{ $val }}')"
                            style="padding:0.4rem 0.85rem;border:none;font-size:0.78rem;font-weight:600;cursor:pointer;background:{{ $priority === $val ? '#FF6400' : 'transparent' }};color:{{ $priority === $val ? '#fff' : 'var(--crm-text-muted)' }};transition:all 0.15s">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
                <button wire:click="openCreate" class="btn btn-primary" style="white-space:nowrap">
                    <i class="ri-add-line"></i> Add Keyword
                </button>
            </div>
        </div>

        <div style="overflow-x:auto">
            <table class="crm-table" style="min-width:760px">
                <thead>
                    <tr>
                        <th>Keyword</th>
                        <th>Target URL</th>
                        <th style="width:80px;text-align:center">Priority</th>
                        <th style="width:80px;text-align:center">Position</th>
                        <th style="width:90px;text-align:center">Vol/month</th>
                        <th style="width:90px;text-align:center">Difficulty</th>
                        <th style="width:80px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keywords as $kw)
                        <tr>
                            <td>
                                <div style="font-weight:600;font-size:0.88rem">{{ $kw->keyword }}</div>
                                @if($kw->notes)
                                    <div style="font-size:0.75rem;color:var(--crm-text-muted);margin-top:2px">{{ Str::limit($kw->notes, 60) }}</div>
                                @endif
                            </td>
                            <td>
                                @if($kw->target_url)
                                    <a href="{{ url($kw->target_url) }}" target="_blank" style="font-size:0.82rem;color:#FF6400;text-decoration:none">{{ $kw->target_url }}</a>
                                @else
                                    <span style="color:var(--crm-text-muted)">—</span>
                                @endif
                            </td>
                            <td style="text-align:center">
                                <span style="font-size:0.72rem;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $kw->priorityColor() }}22;color:{{ $kw->priorityColor() }}">
                                    {{ ucfirst($kw->priority) }}
                                </span>
                            </td>
                            <td style="text-align:center;font-weight:700;font-size:0.88rem;color:{{ $kw->current_position ? ($kw->current_position <= 10 ? '#22c55e' : ($kw->current_position <= 30 ? '#f59e0b' : '#6b7280')) : 'var(--crm-text-muted)' }}">
                                {{ $kw->positionLabel() }}
                            </td>
                            <td style="text-align:center;font-size:0.85rem;color:var(--crm-text-muted)">
                                {{ $kw->monthly_volume ? number_format($kw->monthly_volume) : '—' }}
                            </td>
                            <td style="text-align:center">
                                @if($kw->difficulty !== null)
                                    <span style="font-size:0.78rem;font-weight:700;color:{{ $kw->difficultyColor() }}">
                                        {{ $kw->difficulty }} <span style="font-weight:400">({{ $kw->difficultyLabel() }})</span>
                                    </span>
                                @else
                                    <span style="color:var(--crm-text-muted)">—</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;gap:0.3rem">
                                    <button wire:click="openEdit({{ $kw->id }})"
                                        style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border:1px solid var(--crm-border);border-radius:5px;background:var(--crm-card);color:var(--crm-text);cursor:pointer;font-size:0.85rem"
                                        title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button wire:click="delete({{ $kw->id }})" wire:confirm="Remove this keyword?"
                                        style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border:1px solid var(--crm-border);border-radius:5px;background:var(--crm-card);color:#ef4444;cursor:pointer;font-size:0.85rem"
                                        title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:3rem;color:var(--crm-text-muted)">
                                <i class="ri-price-tag-3-line" style="font-size:2.5rem;display:block;margin-bottom:0.75rem;opacity:0.4"></i>
                                No keywords tracked yet. Add your first keyword to start monitoring.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($keywords->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid var(--crm-border)">
                {{ $keywords->links() }}
            </div>
        @endif
    </div>
</div>
