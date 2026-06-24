<div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        {{-- Toolbar --}}
        <div class="table-filters">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search name, company…">
            </div>
        </div>

        {{-- Loading --}}
        <div wire:loading.flex style="position:absolute;inset:0;background:rgba(0,0,0,0.25);backdrop-filter:blur(2px);z-index:10;align-items:center;justify-content:center">
            <div style="width:34px;height:34px;border:3px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite"></div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
            <table class="crm-table" style="min-width:680px">
                <thead>
                    <tr>
                        <th style="width:30%">Person</th>
                        <th style="width:38%">Quote</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.75rem">
                                    <div style="width:38px;height:38px;border-radius:50%;background:{{ $item->avatar_color }};display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;color:#fff;flex-shrink:0">
                                        {{ $item->displayInitials() }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;color:var(--crm-text);font-size:0.875rem">{{ $item->name }}</div>
                                        @if($item->role || $item->company)
                                            <div style="font-size:0.77rem;color:var(--crm-text-muted)">
                                                {{ implode(', ', array_filter([$item->role, $item->company])) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="color:var(--crm-text-muted);font-size:0.83rem;font-style:italic">
                                "{{ Str::limit($item->quote, 80) }}"
                            </td>
                            <td>
                                <span style="color:#F59E0B;letter-spacing:1px;font-size:0.85rem">
                                    {{ str_repeat('★', $item->rating) }}{{ str_repeat('☆', 5 - $item->rating) }}
                                </span>
                            </td>
                            <td>
                                <button wire:click="toggleActive({{ $item->id }})" title="Click to toggle"
                                    style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;padding:0.25rem 0.6rem;border-radius:20px;cursor:pointer;{{ $item->is_active ? 'background:rgba(16,185,129,0.1);color:#10b981;border:1px solid rgba(16,185,129,0.2)' : 'background:rgba(107,114,128,0.1);color:var(--crm-text-muted);border:1px solid var(--crm-border)' }}">
                                    {{ $item->is_active ? 'Active' : 'Hidden' }}
                                </button>
                            </td>
                            <td style="color:var(--crm-text-muted);font-size:0.85rem;text-align:center">
                                {{ $item->display_order }}
                            </td>
                            <td style="text-align:right">
                                <div style="display:inline-flex;align-items:center;gap:0.4rem">
                                    <a href="{{ route('admin.testimonials.edit', $item) }}"
                                        style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.85rem;border-radius:6px;background:rgba(255,100,0,0.08);border:1px solid rgba(255,100,0,0.2);color:#FF6400;font-size:0.8rem;font-weight:600;text-decoration:none;transition:all 0.15s"
                                        onmouseover="this.style.background='rgba(255,100,0,0.15)'" onmouseout="this.style.background='rgba(255,100,0,0.08)'">
                                        <i class="ri-pencil-line" style="font-size:0.85rem"></i> Edit
                                    </a>
                                    <button
                                        data-id="{{ $item->id }}"
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
                                <i class="ri-chat-quote-line" style="font-size:2rem;display:block;margin-bottom:0.5rem;opacity:0.4"></i>
                                No testimonials yet.
                                <a href="{{ route('admin.testimonials.create') }}" style="display:block;margin-top:0.75rem;color:#FF6400;font-size:0.85rem">Add your first testimonial →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid var(--crm-border)">
                {{ $items->links() }}
            </div>
        @endif

    </div>

</div>
