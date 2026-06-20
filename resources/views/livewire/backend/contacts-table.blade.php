<div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        {{-- Toolbar --}}
        <div class="table-filters">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search name, email or message…">
            </div>

            <div style="display:flex;gap:0;border:1px solid var(--crm-border);border-radius:8px;overflow:hidden">
                @foreach(['' => 'All', 'new' => 'New', 'read' => 'Read', 'replied' => 'Replied'] as $key => $label)
                    <button wire:click="$set('statusFilter', '{{ $key }}')"
                        style="padding:0.4rem 0.9rem;border:none;font-size:0.8rem;font-weight:600;cursor:pointer;background:{{ $statusFilter === $key ? '#FF6400' : 'transparent' }};color:{{ $statusFilter === $key ? '#fff' : 'var(--crm-text-muted)' }};transition:all 0.15s">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Loading overlay --}}
        <div wire:loading.flex style="position:absolute;inset:0;background:rgba(0,0,0,0.25);backdrop-filter:blur(2px);z-index:10;align-items:center;justify-content:center">
            <div style="width:34px;height:34px;border:3px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite"></div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
            <table class="crm-table" style="min-width:680px">
                <thead>
                    <tr>
                        <th style="width:28%">
                            <button wire:click="sort('name')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Sender
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'name' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'name' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th>Service / Budget</th>
                        <th style="width:30%">Message</th>
                        <th>Status</th>
                        <th>
                            <button wire:click="sort('created_at')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Date
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'created_at' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'created_at' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th style="text-align:right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inquiry)
                        <tr style="{{ $inquiry->status === 'new' ? 'background:rgba(255,100,0,0.03)' : '' }}">

                            {{-- Sender --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:0.75rem">
                                    <div style="width:36px;height:36px;border-radius:50%;background:rgba(255,100,0,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-weight:700;font-size:0.85rem;color:#FF6400">
                                        {{ strtoupper(substr($inquiry->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;color:var(--crm-text);font-size:0.875rem;display:flex;align-items:center;gap:0.4rem">
                                            {{ $inquiry->name }}
                                            @if($inquiry->status === 'new')
                                                <span style="width:7px;height:7px;border-radius:50%;background:#FF6400;display:inline-block"></span>
                                            @endif
                                        </div>
                                        <div style="font-size:0.78rem;color:var(--crm-text-muted)">{{ $inquiry->email }}</div>
                                        @if($inquiry->phone)
                                            <div style="font-size:0.75rem;color:var(--crm-text-muted)">{{ $inquiry->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Service / Budget --}}
                            <td>
                                @if($inquiry->service)
                                    <div style="font-size:0.8rem;font-weight:600;color:var(--crm-text)">{{ $inquiry->service }}</div>
                                @endif
                                @if($inquiry->budget)
                                    <div style="font-size:0.75rem;color:var(--crm-text-muted)">{{ $inquiry->budget }}</div>
                                @endif
                                @if(!$inquiry->service && !$inquiry->budget)
                                    <span style="color:var(--crm-text-muted);font-size:0.8rem">—</span>
                                @endif
                            </td>

                            {{-- Message preview --}}
                            <td>
                                <span style="font-size:0.82rem;color:var(--crm-text-muted);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                    {{ $inquiry->message ? Str::limit($inquiry->message, 100) : '—' }}
                                </span>
                            </td>

                            {{-- Status badge --}}
                            <td>
                                @php
                                    $badgeStyle = match($inquiry->status) {
                                        'new'     => 'background:rgba(255,100,0,0.12);color:#FF6400;border:1px solid rgba(255,100,0,0.25)',
                                        'read'    => 'background:rgba(99,102,241,0.1);color:#6366f1;border:1px solid rgba(99,102,241,0.2)',
                                        'replied' => 'background:rgba(16,185,129,0.1);color:#10b981;border:1px solid rgba(16,185,129,0.2)',
                                        default   => 'background:rgba(107,114,128,0.1);color:var(--crm-text-muted);border:1px solid var(--crm-border)',
                                    };
                                @endphp
                                <span style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;padding:0.25rem 0.6rem;border-radius:20px;{{ $badgeStyle }}">
                                    {{ $inquiry->status }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td style="color:var(--crm-text-muted);font-size:0.82rem;white-space:nowrap">
                                {{ $inquiry->created_at->format('d M Y') }}<br>
                                <span style="font-size:0.75rem">{{ $inquiry->created_at->format('h:i A') }}</span>
                            </td>

                            {{-- Actions --}}
                            <td style="text-align:right">
                                <div style="display:inline-flex;align-items:center;gap:0.4rem">
                                    <a href="{{ route('admin.contacts.show', $inquiry) }}"
                                       style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.85rem;border-radius:6px;background:rgba(255,100,0,0.08);border:1px solid rgba(255,100,0,0.2);color:#FF6400;font-size:0.8rem;font-weight:600;text-decoration:none;transition:all 0.15s"
                                       onmouseover="this.style.background='rgba(255,100,0,0.15)'" onmouseout="this.style.background='rgba(255,100,0,0.08)'">
                                        <i class="ri-eye-line" style="font-size:0.85rem"></i> View
                                    </a>
                                    <button
                                        data-id="{{ $inquiry->id }}"
                                        @click="deleteWire($el, $wire)"
                                        style="display:inline-flex;align-items:center;padding:0.35rem 0.55rem;border-radius:6px;background:rgba(239,68,68,0.07);border:1px solid rgba(239,68,68,0.2);color:#ef4444;font-size:0.85rem;cursor:pointer;transition:all 0.15s"
                                        onmouseover="this.style.background='rgba(239,68,68,0.15)'" onmouseout="this.style.background='rgba(239,68,68,0.07)'">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:3rem;color:var(--crm-text-muted)">
                                <i class="ri-mail-line" style="font-size:2rem;display:block;margin-bottom:0.5rem;opacity:0.4"></i>
                                No contact messages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($inquiries->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid var(--crm-border)">
                {{ $inquiries->links() }}
            </div>
        @endif

    </div>

</div>
