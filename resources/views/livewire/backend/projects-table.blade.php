<div>

    <div class="crm-card" style="padding:0;overflow:hidden">

        {{-- Toolbar --}}
        <div class="table-filters">

            <div class="search-wrap">
                <i class="ri-search-line"></i>
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    class="form-control"
                    placeholder="Search project, client, code…"
                >
            </div>

            <select wire:model.live="statusFilter" class="form-control" style="min-width:145px;width:auto">
                <option value="">All Statuses</option>
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>

            @can('project.create')
                <a href="{{ route('admin.projects.create') }}" class="btn btn-primary" style="margin-left:auto;white-space:nowrap">
                    <i class="ri-add-line"></i> New Project
                </a>
            @endcan

        </div>

        <div wire:loading.flex style="position:absolute;inset:0;background:rgba(0,0,0,0.25);backdrop-filter:blur(2px);z-index:10;align-items:center;justify-content:center">
            <div style="width:34px;height:34px;border:3px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite"></div>
        </div>

        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;position:relative">
            <table class="crm-table" style="min-width:680px">
                <thead>
                    <tr>
                        <th style="width:13%">
                            <button wire:click="sort('project_code')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Code
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'project_code' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'project_code' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th>
                            <button wire:click="sort('title')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Project
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'title' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'title' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th>Status</th>
                        <th>
                            <button wire:click="sort('deadline')" style="background:none;border:none;color:var(--crm-text-muted);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;display:inline-flex;align-items:center;gap:0.35rem;padding:0">
                                Deadline
                                <span style="display:flex;flex-direction:column;gap:1px;opacity:0.6">
                                    <i class="ri-arrow-up-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'deadline' && $sortDir === 'asc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                    <i class="ri-arrow-down-s-line" style="font-size:0.75rem;line-height:1;{{ $sortBy === 'deadline' && $sortDir === 'desc' ? 'color:#FF6400;opacity:1' : '' }}"></i>
                                </span>
                            </button>
                        </th>
                        <th>Cost</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        @php
                            $statusColors = [
                                'pending'     => ['bg' => 'rgba(251,191,36,0.15)',  'color' => '#FBBF24'],
                                'in_progress' => ['bg' => 'rgba(96,165,250,0.15)',  'color' => '#60A5FA'],
                                'in_review'   => ['bg' => 'rgba(167,139,250,0.15)', 'color' => '#A78BFA'],
                                'testing'     => ['bg' => 'rgba(34,211,238,0.15)',  'color' => '#22D3EE'],
                                'completed'   => ['bg' => 'rgba(52,211,153,0.15)',  'color' => '#34D399'],
                                'on_hold'     => ['bg' => 'rgba(251,146,60,0.15)',  'color' => '#FB923C'],
                                'cancelled'   => ['bg' => 'rgba(248,113,113,0.15)', 'color' => '#F87171'],
                            ];
                            $sc = $statusColors[$project->status] ?? $statusColors['pending'];
                        @endphp
                        <tr>
                            <td>
                                <span style="font-family:'Syne',sans-serif;font-size:0.8rem;font-weight:700;color:var(--crm-text-muted)">{{ $project->project_code }}</span>
                            </td>
                            <td>
                                <div style="min-width:0">
                                    <div style="font-size:0.875rem;font-weight:600;color:var(--crm-text)">{{ $project->title }}</div>
                                    <div style="font-size:0.775rem;color:var(--crm-text-muted)">
                                        <i class="ri-user-line" style="font-size:0.7rem"></i> {{ $project->client_name }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="display:inline-flex;align-items:center;padding:0.2rem 0.65rem;border-radius:50px;font-size:0.72rem;font-weight:600;white-space:nowrap;background:{{ $sc['bg'] }};color:{{ $sc['color'] }}">
                                    {{ $statuses[$project->status] ?? $project->status }}
                                </span>
                            </td>
                            <td style="font-size:0.825rem;white-space:nowrap">
                                @if($project->deadline)
                                    @if($project->is_overdue)
                                        <span style="color:#F87171;font-weight:600">
                                            <i class="ri-alarm-warning-line"></i> {{ $project->deadline->format('d M Y') }}
                                        </span>
                                    @else
                                        <span style="color:var(--crm-text-muted)">{{ $project->deadline->format('d M Y') }}</span>
                                    @endif
                                @else
                                    <span style="color:var(--crm-text-muted);opacity:0.5">—</span>
                                @endif
                            </td>
                            <td style="font-size:0.825rem;white-space:nowrap;color:var(--crm-text-muted)">
                                @if($project->cost)
                                    {{ number_format($project->cost, 0) }} {{ $project->currency }}
                                @else
                                    <span style="opacity:0.5">—</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5rem">
                                    <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-secondary btn-sm" title="View">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    @can('project.edit')
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-secondary btn-sm" title="Edit">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                    @endcan
                                    @can('project.delete')
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                            title="Delete"
                                            onclick="if(confirm('Delete {{ addslashes($project->project_code) }}? This cannot be undone.')) $wire.deleteProject({{ $project->id }})"
                                        ><i class="ri-delete-bin-line"></i></button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:3.5rem 1rem;color:var(--crm-text-muted)">
                                <i class="ri-folder-open-line" style="font-size:2.5rem;display:block;margin-bottom:0.5rem;opacity:0.3"></i>
                                <span style="font-size:0.875rem">No projects found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination">
            <span>
                @if($projects->total() > 0)
                    Showing <strong>{{ $projects->firstItem() }}</strong>–<strong>{{ $projects->lastItem() }}</strong> of <strong>{{ $projects->total() }}</strong>
                @else
                    No results
                @endif
            </span>
            @if($projects->hasPages())
                <div style="display:flex;align-items:center;gap:0.4rem">
                    @if($projects->onFirstPage())
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-left-s-line"></i></span>
                    @else
                        <button wire:click="previousPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-s-line"></i></button>
                    @endif
                    <span style="font-size:0.8rem;padding:0 0.5rem">{{ $projects->currentPage() }} / {{ $projects->lastPage() }}</span>
                    @if($projects->hasMorePages())
                        <button wire:click="nextPage" class="btn btn-secondary btn-sm"><i class="ri-arrow-right-s-line"></i></button>
                    @else
                        <span class="btn btn-secondary btn-sm" style="opacity:0.35;cursor:not-allowed"><i class="ri-arrow-right-s-line"></i></span>
                    @endif
                </div>
            @endif
        </div>

    </div>

</div>
