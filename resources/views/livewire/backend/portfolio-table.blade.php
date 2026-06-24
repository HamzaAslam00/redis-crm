<div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        {{-- Toolbar --}}
        <div class="table-filters">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search title, client…">
            </div>

            <select wire:model.live="categoryFilter" class="form-control" style="width:auto;min-width:160px;font-size:0.85rem">
                <option value="">All Categories</option>
                <option value="web">Web Development</option>
                <option value="mobile">Mobile App</option>
                <option value="marketing">Digital Marketing</option>
                <option value="erp">ERP Solution</option>
                <option value="ai">AI Application</option>
                <option value="software">Software Development</option>
            </select>

            <div style="display:flex;gap:0;border:1px solid var(--crm-border);border-radius:8px;overflow:hidden">
                @foreach(['' => 'All', 'active' => 'Active', 'draft' => 'Draft'] as $key => $label)
                    <button wire:click="$set('statusFilter', '{{ $key }}')"
                        style="padding:0.4rem 0.9rem;border:none;font-size:0.8rem;font-weight:600;cursor:pointer;background:{{ $statusFilter === $key ? '#FF6400' : 'transparent' }};color:{{ $statusFilter === $key ? '#fff' : 'var(--crm-text-muted)' }};transition:all 0.15s">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Loading --}}
        <div wire:loading.flex style="position:absolute;inset:0;background:rgba(0,0,0,0.25);backdrop-filter:blur(2px);z-index:10;align-items:center;justify-content:center">
            <div style="width:34px;height:34px;border:3px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite"></div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
            <table class="crm-table" style="min-width:740px">
                <thead>
                    <tr>
                        <th style="width:36%">
                            <button wire:click="sort('title')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Project
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'title' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'title' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>
                            <button wire:click="sort('display_order')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Order
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'display_order' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'display_order' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            {{-- Project --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:0.75rem">
                                    @if($item->featured_image)
                                        <img src="{{ $item->featured_image }}" alt=""
                                            style="width:44px;height:34px;object-fit:cover;border-radius:6px;border:1px solid var(--crm-border);flex-shrink:0">
                                    @else
                                        <div style="width:44px;height:34px;border-radius:6px;background:rgba(255,100,0,0.08);border:1px solid var(--crm-border);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                            <i class="ri-image-line" style="color:var(--crm-text-muted);font-size:1rem"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight:600;color:var(--crm-text);font-size:0.875rem">{{ Str::limit($item->title, 45) }}</div>
                                        @if($item->client_name)
                                            <div style="font-size:0.77rem;color:var(--crm-text-muted)">{{ $item->client_name }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td>
                                @php
                                    $catColor = match($item->category) {
                                        'ai'        => '#EC4899',
                                        'mobile'    => '#6366F1',
                                        'marketing' => '#10B981',
                                        'erp'       => '#F59E0B',
                                        'software'  => '#0EA5E9',
                                        default     => '#FF6400',
                                    };
                                @endphp
                                <span style="font-size:0.78rem;font-weight:600;padding:0.2rem 0.55rem;border-radius:20px;background:{{ $catColor }}18;color:{{ $catColor }};border:1px solid {{ $catColor }}33">
                                    {{ \App\Models\PortfolioItem::categoryLabel($item->category) }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td>
                                <button wire:click="toggleStatus({{ $item->id }})" title="Click to toggle"
                                    style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;padding:0.25rem 0.6rem;border-radius:20px;cursor:pointer;{{ $item->status === 'active' ? 'background:rgba(16,185,129,0.1);color:#10b981;border:1px solid rgba(16,185,129,0.2)' : 'background:rgba(107,114,128,0.1);color:var(--crm-text-muted);border:1px solid var(--crm-border)' }}">
                                    {{ $item->status }}
                                </button>
                            </td>

                            {{-- Featured --}}
                            <td>
                                <button wire:click="toggleFeatured({{ $item->id }})" title="Toggle featured"
                                    style="background:none;border:none;cursor:pointer;padding:0.2rem;font-size:1.1rem;color:{{ $item->is_featured ? '#F59E0B' : 'var(--crm-text-muted)' }}">
                                    <i class="{{ $item->is_featured ? 'ri-star-fill' : 'ri-star-line' }}"></i>
                                </button>
                            </td>

                            {{-- Order --}}
                            <td style="color:var(--crm-text-muted);font-size:0.85rem;text-align:center">
                                {{ $item->display_order }}
                            </td>

                            {{-- Actions --}}
                            <td style="text-align:right">
                                <div style="display:inline-flex;align-items:center;gap:0.4rem">
                                    <a href="{{ route('admin.portfolio.edit', $item) }}"
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
                                <i class="ri-layout-masonry-line" style="font-size:2rem;display:block;margin-bottom:0.5rem;opacity:0.4"></i>
                                No portfolio items yet.
                                <a href="{{ route('admin.portfolio.create') }}" style="display:block;margin-top:0.75rem;color:#FF6400;font-size:0.85rem">Add your first project →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($items->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid var(--crm-border)">
                {{ $items->links() }}
            </div>
        @endif

    </div>

</div>
