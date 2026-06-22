<div>
<style>
.act-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border: 1px solid var(--crm-border);
    border-radius: 6px;
    background: var(--crm-card);
    color: var(--crm-text);
    text-decoration: none;
    cursor: pointer;
    font-size: 0.92rem;
    line-height: 1;
    padding: 0;
    transition: background 0.15s, border-color 0.15s, color 0.15s;
}
.act-btn:hover           { background: var(--crm-hover, rgba(0,0,0,0.06)); border-color: #FF6400; color: #FF6400; }
.act-btn.act-pdf:hover   { border-color: #FF6400; color: #FF6400; }
.act-btn.act-del         { color: var(--crm-text); }
.act-btn.act-del:hover   { background: #fef2f2; border-color: #ef4444; color: #ef4444; }
</style>

    <div class="crm-card" style="padding:0;overflow:hidden">

        {{-- Toolbar --}}
        <div class="table-filters">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search client, project, proposal #…">
            </div>

            <div style="display:flex;gap:0.5rem;align-items:center;margin-left:auto">
                {{-- Status filter --}}
                <div style="display:flex;gap:0;border:1px solid var(--crm-border);border-radius:8px;overflow:hidden">
                    @foreach(['' => 'All', 'draft' => 'Draft', 'sent' => 'Sent', 'viewed' => 'Viewed', 'accepted' => 'Accepted', 'rejected' => 'Rejected'] as $key => $label)
                        <button wire:click="$set('statusFilter', '{{ $key }}')"
                            style="padding:0.4rem 0.85rem;border:none;font-size:0.78rem;font-weight:600;cursor:pointer;background:{{ $statusFilter === $key ? '#FF6400' : 'transparent' }};color:{{ $statusFilter === $key ? '#fff' : 'var(--crm-text-muted)' }};transition:all 0.15s">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                {{-- Platform filter --}}
                <select wire:model.live="platformFilter" class="form-control" style="width:auto;font-size:0.82rem;padding:0.4rem 0.7rem">
                    <option value="">All Platforms</option>
                    @foreach(\App\Models\Proposal::platforms() as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>

                <a href="{{ route('admin.proposals.create') }}" class="btn btn-primary" style="white-space:nowrap">
                    <i class="ri-add-line"></i> New Proposal
                </a>
            </div>
        </div>

        {{-- Loading overlay --}}
        <div wire:loading.flex style="position:absolute;inset:0;background:rgba(0,0,0,0.25);backdrop-filter:blur(2px);z-index:10;align-items:center;justify-content:center">
            <div style="width:34px;height:34px;border:3px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite"></div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
            <table class="crm-table" style="min-width:860px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Platform</th>
                        <th>Project</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Valid Until</th>
                        <th style="width:160px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proposals as $proposal)
                        <tr>
                            <td>
                                <a href="{{ route('admin.proposals.show', $proposal) }}"
                                    style="font-weight:700;font-size:0.78rem;color:#FF6400;text-decoration:none;font-family:monospace">
                                    {{ $proposal->proposal_number }}
                                </a>
                            </td>
                            <td>
                                <div style="font-weight:600;font-size:0.9rem">{{ $proposal->client_name }}</div>
                                @if($proposal->client_company)
                                    <div style="font-size:0.78rem;color:var(--crm-text-muted)">{{ $proposal->client_company }}</div>
                                @endif
                            </td>
                            <td>
                                @if($proposal->platform)
                                    <span style="font-size:0.8rem;color:var(--crm-text-muted)">
                                        {{ \App\Models\Proposal::platforms()[$proposal->platform] ?? $proposal->platform }}
                                    </span>
                                    @if($proposal->fiverr_username)
                                        <div style="font-size:0.75rem;color:var(--crm-text-muted)">@{{ $proposal->fiverr_username }}</div>
                                    @endif
                                @else
                                    <span style="color:var(--crm-text-muted)">—</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size:0.88rem;font-weight:500;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                    {{ $proposal->project_title }}
                                </div>
                            </td>
                            <td>
                                <span style="font-weight:700;font-size:0.88rem">
                                    {{ $proposal->currency }} {{ number_format($proposal->total_amount, 2) }}
                                </span>
                            </td>
                            <td>
                                <span style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.25rem 0.65rem;border-radius:20px;font-size:0.75rem;font-weight:700;background:{{ $proposal->statusColor() }}22;color:{{ $proposal->statusColor() }}">
                                    {{ $proposal->statusLabel() }}
                                </span>
                            </td>
                            <td>
                                @if($proposal->valid_until)
                                    <span style="font-size:0.82rem;color:{{ $proposal->valid_until->isPast() ? '#ef4444' : 'var(--crm-text-muted)' }}">
                                        {{ $proposal->valid_until->format('d M Y') }}
                                    </span>
                                @else
                                    <span style="color:var(--crm-text-muted)">—</span>
                                @endif
                            </td>
                            <td>
                                <div x-data="{
                                        tip:'', tipX:0, tipY:0,
                                        show(e,t){ const r=e.currentTarget.getBoundingClientRect(); this.tip=t; this.tipX=r.left+r.width/2; this.tipY=r.top-6; },
                                        hide(){ this.tip=''; }
                                    }"
                                    style="display:flex;gap:0.3rem;align-items:center">

                                    {{-- Fixed-position tooltip --}}
                                    <div x-show="tip" x-cloak
                                        :style="`position:fixed;z-index:9999;top:${tipY}px;left:${tipX}px;transform:translate(-50%,-100%);background:#111;color:#fff;font-size:0.68rem;font-weight:600;padding:3px 9px;border-radius:4px;pointer-events:none;white-space:nowrap`"
                                        x-text="tip"></div>

                                    <a href="{{ route('admin.proposals.show', $proposal) }}"
                                        class="act-btn"
                                        @mouseenter="show($event,'View Proposal')" @mouseleave="hide()">
                                        <i class="ri-eye-line"></i>
                                    </a>

                                    @if($proposal->status === 'draft')
                                        <a href="{{ route('admin.proposals.edit', $proposal) }}"
                                            class="act-btn"
                                            @mouseenter="show($event,'Edit')" @mouseleave="hide()">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.proposals.pdf', $proposal) }}" target="_blank"
                                        class="act-btn act-pdf"
                                        @mouseenter="show($event,'Download PDF')" @mouseleave="hide()"
                                        style="color:#FF6400;border-color:#FF640044">
                                        <i class="ri-file-pdf-line"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.proposals.duplicate', $proposal) }}" style="display:contents">
                                        @csrf
                                        <button type="submit" class="act-btn"
                                            @mouseenter="show($event,'Duplicate')" @mouseleave="hide()">
                                            <i class="ri-file-copy-line"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.proposals.destroy', $proposal) }}" style="display:contents"
                                        onsubmit="return confirm('Delete this proposal? This cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="act-btn act-del"
                                            @mouseenter="show($event,'Delete')" @mouseleave="hide()">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:3rem;color:var(--crm-text-muted)">
                                <i class="ri-file-list-3-line" style="font-size:2.5rem;display:block;margin-bottom:0.75rem;opacity:0.4"></i>
                                No proposals found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($proposals->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid var(--crm-border)">
                {{ $proposals->links() }}
            </div>
        @endif
    </div>
</div>
