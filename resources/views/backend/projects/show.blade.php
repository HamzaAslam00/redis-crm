<x-layouts.backend :title="$project->project_code">

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
        $statuses = \App\Models\Project::$statuses;
    @endphp

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.75rem">
        <div style="display:flex;align-items:center;gap:1rem">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm" title="Back">
                <i class="ri-arrow-left-line"></i>
            </a>
            <div>
                <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap">
                    <h1 class="page-title" style="margin:0">{{ $project->title }}</h1>
                    <span style="font-family:'Syne',sans-serif;font-size:0.85rem;font-weight:700;color:var(--crm-text-muted)">{{ $project->project_code }}</span>
                    <span style="display:inline-flex;align-items:center;padding:0.2rem 0.65rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:{{ $sc['bg'] }};color:{{ $sc['color'] }}">
                        {{ $statuses[$project->status] ?? $project->status }}
                    </span>
                    @if($project->is_overdue)
                        <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.2rem 0.65rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:rgba(248,113,113,0.15);color:#F87171">
                            <i class="ri-alarm-warning-line"></i> Overdue
                        </span>
                    @endif
                </div>
                <p style="font-size:0.825rem;color:var(--crm-text-muted);margin:0.3rem 0 0">
                    Client: <strong style="color:var(--crm-text)">{{ $project->client_name }}</strong>
                    @if($project->developer_name)
                        &nbsp;·&nbsp; Developer: <strong style="color:var(--crm-text)">{{ $project->developer_name }}</strong>
                    @endif
                </p>
            </div>
        </div>
        <div style="display:flex;gap:0.5rem">
            @can('project.edit')
                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-secondary">
                    <i class="ri-pencil-line"></i> Edit
                </a>
            @endcan
            @can('project.delete')
                <form id="delete-project-form" method="POST" action="{{ route('admin.projects.destroy', $project) }}">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-danger"
                        onclick="deleteForm(this)"
                        data-form="delete-project-form"
                        data-label="{{ addslashes($project->project_code) }}">
                        <i class="ri-delete-bin-line"></i> Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>

    {{-- Stats row --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1rem;margin-bottom:1.5rem">
        <div class="crm-card" style="padding:1rem 1.25rem">
            <div style="font-size:0.72rem;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.4rem">Cost</div>
            <div style="font-size:1.25rem;font-weight:700;font-family:'Syne',sans-serif;color:var(--crm-text)">
                {{ $project->cost ? number_format($project->cost, 0) . ' ' . $project->currency : '—' }}
            </div>
        </div>
        <div class="crm-card" style="padding:1rem 1.25rem">
            <div style="font-size:0.72rem;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.4rem">Deadline</div>
            <div style="font-size:1.1rem;font-weight:700;font-family:'Syne',sans-serif;color:{{ $project->is_overdue ? '#F87171' : 'var(--crm-text)' }}">
                {{ $project->deadline?->format('d M Y') ?? '—' }}
            </div>
        </div>
        <div class="crm-card" style="padding:1rem 1.25rem">
            <div style="font-size:0.72rem;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.4rem">Documents</div>
            <div style="font-size:1.25rem;font-weight:700;font-family:'Syne',sans-serif;color:var(--crm-text)">{{ $project->documents->count() }}</div>
        </div>
        <div class="crm-card" style="padding:1rem 1.25rem">
            <div style="font-size:0.72rem;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.4rem">Messages</div>
            <div style="font-size:1.25rem;font-weight:700;font-family:'Syne',sans-serif;color:var(--crm-text)">{{ $project->messages->count() }}</div>
        </div>
    </div>

    {{-- Tabs --}}
    <div x-data="{ tab: 'overview' }">

        <div style="display:flex;gap:0;border-bottom:1px solid var(--crm-border);margin-bottom:1.5rem;overflow-x:auto">
            @foreach(['overview' => 'Overview', 'documents' => 'Documents', 'messages' => 'Notes'] as $key => $label)
                <button
                    @click="tab = '{{ $key }}'"
                    :style="tab === '{{ $key }}' ? 'border-bottom:2px solid #FF6400;color:#FF6400;' : 'border-bottom:2px solid transparent;color:var(--crm-text-muted);'"
                    style="background:none;border:none;border-top:none;border-left:none;border-right:none;padding:0.75rem 1.25rem;font-size:0.875rem;font-weight:600;cursor:pointer;white-space:nowrap;transition:color 0.15s"
                >{{ $label }}</button>
            @endforeach
        </div>

        {{-- Overview tab --}}
        <div x-show="tab === 'overview'" x-transition>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">

                <div class="crm-card">
                    <h3 style="font-size:0.875rem;font-weight:600;color:var(--crm-text);margin:0 0 1rem">Project Details</h3>
                    <dl style="display:grid;grid-template-columns:140px 1fr;row-gap:0.75rem;font-size:0.85rem">
                        <dt style="color:var(--crm-text-muted)">Client</dt>
                        <dd style="color:var(--crm-text);margin:0">{{ $project->client_name }}</dd>
                        <dt style="color:var(--crm-text-muted)">Status</dt>
                        <dd style="margin:0">
                            <span style="display:inline-flex;align-items:center;padding:0.15rem 0.6rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:{{ $sc['bg'] }};color:{{ $sc['color'] }}">
                                {{ $statuses[$project->status] ?? $project->status }}
                            </span>
                        </dd>
                        <dt style="color:var(--crm-text-muted)">Developer</dt>
                        <dd style="color:var(--crm-text);margin:0">{{ $project->developer_name ?: '—' }}</dd>
                        <dt style="color:var(--crm-text-muted)">Cost</dt>
                        <dd style="color:var(--crm-text);margin:0">{{ $project->cost ? number_format($project->cost, 2) . ' ' . $project->currency : '—' }}</dd>
                        <dt style="color:var(--crm-text-muted)">Deadline</dt>
                        <dd style="color:{{ $project->is_overdue ? '#F87171' : 'var(--crm-text)' }};margin:0">{{ $project->deadline?->format('d M Y') ?? '—' }}</dd>
                        @if($project->live_url)
                            <dt style="color:var(--crm-text-muted)">Live URL</dt>
                            <dd style="margin:0"><a href="{{ $project->live_url }}" target="_blank" style="color:#FF6400;word-break:break-all">{{ $project->live_url }}</a></dd>
                        @endif
                        @if($project->testing_url)
                            <dt style="color:var(--crm-text-muted)">Staging URL</dt>
                            <dd style="margin:0"><a href="{{ $project->testing_url }}" target="_blank" style="color:#FF6400;word-break:break-all">{{ $project->testing_url }}</a></dd>
                        @endif
                    </dl>
                </div>

                <div class="crm-card">
                    <h3 style="font-size:0.875rem;font-weight:600;color:var(--crm-text);margin:0 0 1rem">Description</h3>
                    @if($project->description)
                        <p style="font-size:0.875rem;color:var(--crm-text-muted);line-height:1.65;margin:0">{{ $project->description }}</p>
                    @else
                        <p style="font-size:0.875rem;color:var(--crm-text-muted);opacity:0.5;margin:0">No description added.</p>
                    @endif

                    @if($project->requirements_note)
                        <h3 style="font-size:0.875rem;font-weight:600;color:var(--crm-text);margin:1.5rem 0 0.75rem">Requirements Note</h3>
                        <p style="font-size:0.875rem;color:var(--crm-text-muted);line-height:1.65;margin:0;white-space:pre-wrap">{{ $project->requirements_note }}</p>
                    @endif
                </div>

            </div>
        </div>

        {{-- Documents tab --}}
        <div x-show="tab === 'documents'" x-transition>
            <div class="crm-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
                    <h3 style="font-size:0.875rem;font-weight:600;color:var(--crm-text);margin:0">Documents ({{ $project->documents->count() }})</h3>
                </div>
                @forelse($project->documents as $doc)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:0.75rem;border-radius:8px;background:var(--crm-hover);margin-bottom:0.5rem">
                        <div style="display:flex;align-items:center;gap:0.75rem">
                            <i class="ri-file-line" style="font-size:1.25rem;color:var(--crm-text-muted)"></i>
                            <div>
                                <div style="font-size:0.875rem;font-weight:500;color:var(--crm-text)">{{ $doc->name }}</div>
                                <div style="font-size:0.75rem;color:var(--crm-text-muted)">{{ $doc->uploader?->name }} · {{ $doc->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $doc->path) }}" download class="btn btn-secondary btn-sm">
                            <i class="ri-download-line"></i>
                        </a>
                    </div>
                @empty
                    <p style="text-align:center;padding:2rem;color:var(--crm-text-muted);font-size:0.875rem;opacity:0.6">No documents uploaded yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Messages / Notes tab --}}
        <div x-show="tab === 'messages'" x-transition>
            <div class="crm-card">
                <h3 style="font-size:0.875rem;font-weight:600;color:var(--crm-text);margin:0 0 1rem">Project Notes</h3>
                @forelse($project->messages as $msg)
                    <div style="padding:0.875rem;border-radius:8px;background:var(--crm-hover);margin-bottom:0.75rem;border-left:3px solid {{ $msg->is_client ? '#60A5FA' : '#FF6400' }}">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.4rem">
                            <span style="font-size:0.8rem;font-weight:600;color:{{ $msg->is_client ? '#60A5FA' : '#FF6400' }}">
                                {{ $msg->is_client ? 'Client' : ($msg->user?->name ?? 'Team') }}
                            </span>
                            <span style="font-size:0.75rem;color:var(--crm-text-muted)">{{ $msg->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <p style="margin:0;font-size:0.875rem;color:var(--crm-text);line-height:1.6">{{ $msg->message }}</p>
                    </div>
                @empty
                    <p style="text-align:center;padding:2rem;color:var(--crm-text-muted);font-size:0.875rem;opacity:0.6">No notes yet.</p>
                @endforelse

                <form method="POST" action="{{ route('admin.projects.messages.store', $project) }}" style="margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid var(--crm-border)">
                    @csrf
                    <div class="form-group" style="margin-bottom:0.75rem">
                        <textarea name="message" rows="3" class="form-control" placeholder="Add a note or internal message…" required></textarea>
                    </div>
                    <div style="display:flex;align-items:center;gap:0.75rem">
                        <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;color:var(--crm-text-muted);cursor:pointer">
                            <input type="checkbox" name="is_client" value="1"> Mark as client message
                        </label>
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-left:auto">
                            <i class="ri-send-plane-line"></i> Add Note
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-layouts.backend>
