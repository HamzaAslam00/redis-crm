<div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        {{-- Toolbar --}}
        <div class="table-filters">
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search title or excerpt…">
            </div>

            <select wire:model.live="categoryFilter" class="form-control" style="width:auto;min-width:160px;font-size:0.85rem">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <div style="display:flex;gap:0;border:1px solid var(--crm-border);border-radius:8px;overflow:hidden">
                @foreach(['' => 'All', 'published' => 'Published', 'draft' => 'Draft', 'archived' => 'Archived'] as $key => $label)
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
            <table class="crm-table" style="min-width:720px">
                <thead>
                    <tr>
                        <th style="width:35%">
                            <button wire:click="sort('title')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Title
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'title' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'title' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>
                            <button wire:click="sort('views_count')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Views
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'views_count' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'views_count' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th>
                            <button wire:click="sort('created_at')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Date
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'created_at' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'created_at' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            {{-- Title --}}
                            <td>
                                <div style="font-weight:600;color:var(--crm-text);font-size:0.875rem;margin-bottom:0.2rem">
                                    {{ Str::limit($post->title, 60) }}
                                </div>
                                @if($post->excerpt)
                                    <div style="font-size:0.77rem;color:var(--crm-text-muted)">{{ Str::limit($post->excerpt, 80) }}</div>
                                @endif
                                <div style="font-size:0.75rem;color:var(--crm-text-muted);margin-top:0.15rem">
                                    By {{ $post->author->name ?? '—' }}
                                </div>
                            </td>

                            {{-- Category --}}
                            <td>
                                @if($post->category)
                                    <span style="font-size:0.78rem;font-weight:600;padding:0.2rem 0.55rem;border-radius:20px;background:rgba(99,102,241,0.1);color:#6366f1;border:1px solid rgba(99,102,241,0.2)">
                                        {{ $post->category->name }}
                                    </span>
                                @else
                                    <span style="color:var(--crm-text-muted);font-size:0.8rem">—</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @php
                                    $badge = match($post->status) {
                                        'published' => 'background:rgba(16,185,129,0.1);color:#10b981;border:1px solid rgba(16,185,129,0.2)',
                                        'draft'     => 'background:rgba(107,114,128,0.1);color:var(--crm-text-muted);border:1px solid var(--crm-border)',
                                        'archived'  => 'background:rgba(239,68,68,0.07);color:#ef4444;border:1px solid rgba(239,68,68,0.2)',
                                        default     => '',
                                    };
                                @endphp
                                <button wire:click="toggleStatus({{ $post->id }})"
                                    title="Click to toggle"
                                    style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;padding:0.25rem 0.6rem;border-radius:20px;cursor:pointer;{{ $badge }}">
                                    {{ $post->status }}
                                </button>
                            </td>

                            {{-- Views --}}
                            <td style="color:var(--crm-text-muted);font-size:0.82rem">
                                <i class="ri-eye-line" style="font-size:0.8rem"></i>
                                {{ number_format($post->views_count) }}
                            </td>

                            {{-- Date --}}
                            <td style="color:var(--crm-text-muted);font-size:0.82rem;white-space:nowrap">
                                {{ $post->created_at->format('d M Y') }}
                                @if($post->published_at)
                                    <br><span style="font-size:0.73rem;color:#10b981">Published {{ $post->published_at->diffForHumans() }}</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td style="text-align:right">
                                <div style="display:inline-flex;align-items:center;gap:0.4rem">
                                    <a href="{{ route('admin.blog.posts.edit', $post) }}"
                                        style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.85rem;border-radius:6px;background:rgba(255,100,0,0.08);border:1px solid rgba(255,100,0,0.2);color:#FF6400;font-size:0.8rem;font-weight:600;text-decoration:none;transition:all 0.15s"
                                        onmouseover="this.style.background='rgba(255,100,0,0.15)'" onmouseout="this.style.background='rgba(255,100,0,0.08)'">
                                        <i class="ri-pencil-line" style="font-size:0.85rem"></i> Edit
                                    </a>
                                    <button
                                        data-id="{{ $post->id }}"
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
                                <i class="ri-article-line" style="font-size:2rem;display:block;margin-bottom:0.5rem;opacity:0.4"></i>
                                No blog posts yet.
                                <a href="{{ route('admin.blog.posts.create') }}" style="display:block;margin-top:0.75rem;color:#FF6400;font-size:0.85rem">Create your first post →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid var(--crm-border)">
                {{ $posts->links() }}
            </div>
        @endif

    </div>

</div>
