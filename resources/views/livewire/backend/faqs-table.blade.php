<div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        {{-- Toolbar --}}
        <div class="table-filters">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search question…">
            </div>
            <select wire:model.live="categoryFilter" class="form-control" style="width:auto;min-width:180px;font-size:0.85rem">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
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
                        <th style="width:42%">Question</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                        <tr>
                            <td>
                                <div style="font-weight:500;color:var(--crm-text);font-size:0.875rem">{{ Str::limit($faq->question, 90) }}</div>
                                <div style="font-size:0.77rem;color:var(--crm-text-muted);margin-top:0.15rem">{{ Str::limit(strip_tags($faq->answer), 70) }}</div>
                            </td>
                            <td>
                                @if($faq->category)
                                    <span style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.78rem;font-weight:600;padding:0.2rem 0.55rem;border-radius:20px;background:rgba(255,100,0,0.08);color:#FF6400;border:1px solid rgba(255,100,0,0.2)">
                                        <i class="{{ $faq->category->icon }}"></i>
                                        {{ $faq->category->name }}
                                    </span>
                                @else
                                    <span style="color:var(--crm-text-muted);font-size:0.8rem">—</span>
                                @endif
                            </td>
                            <td>
                                <button wire:click="toggleActive({{ $faq->id }})" title="Click to toggle"
                                    style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;padding:0.25rem 0.6rem;border-radius:20px;cursor:pointer;{{ $faq->is_active ? 'background:rgba(16,185,129,0.1);color:#10b981;border:1px solid rgba(16,185,129,0.2)' : 'background:rgba(107,114,128,0.1);color:var(--crm-text-muted);border:1px solid var(--crm-border)' }}">
                                    {{ $faq->is_active ? 'Active' : 'Hidden' }}
                                </button>
                            </td>
                            <td style="color:var(--crm-text-muted);font-size:0.85rem;text-align:center">
                                {{ $faq->display_order }}
                            </td>
                            <td style="text-align:right">
                                <div style="display:inline-flex;align-items:center;gap:0.4rem">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}"
                                        style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.85rem;border-radius:6px;background:rgba(255,100,0,0.08);border:1px solid rgba(255,100,0,0.2);color:#FF6400;font-size:0.8rem;font-weight:600;text-decoration:none;transition:all 0.15s"
                                        onmouseover="this.style.background='rgba(255,100,0,0.15)'" onmouseout="this.style.background='rgba(255,100,0,0.08)'">
                                        <i class="ri-pencil-line" style="font-size:0.85rem"></i> Edit
                                    </a>
                                    <button
                                        data-id="{{ $faq->id }}"
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
                            <td colspan="5" style="text-align:center;padding:3rem;color:var(--crm-text-muted)">
                                <i class="ri-question-line" style="font-size:2rem;display:block;margin-bottom:0.5rem;opacity:0.4"></i>
                                No FAQs yet.
                                <a href="{{ route('admin.faqs.create') }}" style="display:block;margin-top:0.75rem;color:#FF6400;font-size:0.85rem">Add your first FAQ →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($faqs->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid var(--crm-border)">
                {{ $faqs->links() }}
            </div>
        @endif

    </div>

</div>
