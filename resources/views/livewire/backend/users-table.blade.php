<div>

    {{-- Single unified card: filters + table + pagination --}}
    <div class="crm-card" style="padding:0;overflow:hidden">

        {{-- Toolbar --}}
        <div class="table-filters">

            {{-- Search --}}
            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    class="form-control"
                    placeholder="Search by name or email…"
                >
            </div>

            {{-- Role filter --}}
            <select wire:model.live="roleFilter" class="form-control" style="min-width:150px;width:auto">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucwords(str_replace('-', ' ', $role->name)) }}</option>
                @endforeach
            </select>

            @can('user.create')
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="white-space:nowrap;margin-left:auto">
                    <i class="ri-user-add-line"></i> Add User
                </a>
            @endcan

        </div>

        {{-- Loading overlay --}}
        <div wire:loading.flex style="position:absolute;inset:0;background:rgba(0,0,0,0.25);backdrop-filter:blur(2px);z-index:10;align-items:center;justify-content:center">
            <div style="width:34px;height:34px;border:3px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite"></div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
            <table class="crm-table" style="min-width:580px">
                <thead>
                    <tr>
                        <th style="width:40%">
                            <button wire:click="sort('name')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                User
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'name' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'name' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th>Role</th>
                        <th>
                            <button wire:click="sort('created_at')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Joined
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
                    @forelse($users as $user)
                        @php
                            $roleName   = $user->roles->first()?->name ?? 'no-role';
                            $roleColor  = match($roleName) {
                                'super-admin'     => ['bg' => 'rgba(255,100,0,0.15)',   'color' => '#FF6400'],
                                'admin'           => ['bg' => 'rgba(139,92,246,0.15)',  'color' => '#8B5CF6'],
                                'manager'         => ['bg' => 'rgba(16,185,129,0.15)', 'color' => '#10B981'],
                                'content-manager' => ['bg' => 'rgba(251,191,36,0.15)', 'color' => '#FBBF24'],
                                default           => ['bg' => 'rgba(148,163,184,0.15)','color' => '#94A3B8'],
                            };
                            $initials = collect(explode(' ', $user->name))
                                ->map(fn($w) => strtoupper($w[0] ?? ''))
                                ->take(2)->implode('');
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.75rem">
                                    <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#FF6400,#FF8C00);display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;color:#fff;flex-shrink:0">
                                        {{ $initials }}
                                    </div>
                                    <div style="min-width:0">
                                        <div style="font-size:0.875rem;font-weight:600;color:var(--crm-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $user->name }}</div>
                                        <div style="font-size:0.775rem;color:var(--crm-text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="display:inline-flex;align-items:center;padding:0.2rem 0.7rem;border-radius:50px;font-size:0.75rem;font-weight:600;white-space:nowrap;background:{{ $roleColor['bg'] }};color:{{ $roleColor['color'] }}">
                                    {{ $roleName === 'no-role' ? 'No Role' : ucwords(str_replace('-', ' ', $roleName)) }}
                                </span>
                            </td>
                            <td style="font-size:0.825rem;color:var(--crm-text-muted);white-space:nowrap">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5rem">
                                    @can('user.edit')
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary btn-sm" title="Edit">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                    @endcan
                                    @can('user.delete')
                                        @if(!$user->hasRole('super-admin') && $user->id !== auth()->id())
                                            <button
                                                type="button"
                                                class="btn btn-danger btn-sm"
                                                title="Delete"
                                                onclick="if(confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')) $wire.deleteUser({{ $user->id }})"
                                            ><i class="ri-delete-bin-line"></i></button>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:3.5rem 1rem;color:var(--crm-text-muted)">
                                <i class="ri-user-search-line" style="font-size:2.5rem;display:block;margin-bottom:0.5rem;opacity:0.3"></i>
                                <span style="font-size:0.875rem">No users found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="table-pagination">
            <span>
                @if($users->total() > 0)
                    Showing <strong>{{ $users->firstItem() }}</strong>–<strong>{{ $users->lastItem() }}</strong> of <strong>{{ $users->total() }}</strong>
                @else
                    No results
                @endif
            </span>
            @if($users->hasPages())
                <div style="display:flex;align-items:center;gap:0.4rem">
                    @if($users->onFirstPage())
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-left-s-line"></i></span>
                    @else
                        <button wire:click="previousPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-s-line"></i></button>
                    @endif
                    <span style="font-size:0.8rem;padding:0 0.5rem">{{ $users->currentPage() }} / {{ $users->lastPage() }}</span>
                    @if($users->hasMorePages())
                        <button wire:click="nextPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-right-s-line"></i></button>
                    @else
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-right-s-line"></i></span>
                    @endif
                </div>
            @endif
        </div>

    </div>

</div>
