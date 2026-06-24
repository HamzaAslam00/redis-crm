<x-layouts.backend title="Proposal — {{ $proposal->proposal_number }}">

    <x-backend.page-header title="{{ $proposal->proposal_number }}" subtitle="{{ $proposal->client_name }} — {{ $proposal->project_title }}">
        <div style="display:flex;gap:0.5rem;align-items:center">
            @if($proposal->status === 'draft')
                <a href="{{ route('admin.proposals.edit', $proposal) }}" class="btn btn-secondary">
                    <i class="ri-edit-line"></i> Edit
                </a>
            @endif
            <a href="{{ route('admin.proposals.preview', $proposal) }}" class="btn btn-secondary" target="_blank">
                <i class="ri-eye-line"></i> Preview PDF
            </a>
            <a href="{{ route('admin.proposals.pdf', $proposal) }}" class="btn btn-primary" target="_blank">
                <i class="ri-download-line"></i> Download PDF
            </a>
        </div>
    </x-backend.page-header>

    <x-backend.breadcrumb :items="[
        'Proposals'                => route('admin.proposals.index'),
        $proposal->proposal_number => null,
    ]" />

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">

        {{-- Main --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">

            {{-- Client & Project --}}
            <div class="crm-card">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem">
                    <div>
                        <h4 style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--crm-text-muted);margin:0 0 0.75rem">Prepared For</h4>
                        <div style="font-weight:700;font-size:1rem">{{ $proposal->client_name }}</div>
                        @if($proposal->client_company)<div style="color:var(--crm-text-muted);font-size:0.88rem">{{ $proposal->client_company }}</div>@endif
                        @if($proposal->client_email)<div style="font-size:0.85rem;margin-top:0.3rem"><i class="ri-mail-line"></i> {{ $proposal->client_email }}</div>@endif
                        @if($proposal->client_phone)<div style="font-size:0.85rem"><i class="ri-phone-line"></i> {{ $proposal->client_phone }}</div>@endif
                        @if($proposal->platform)
                            <div style="margin-top:0.5rem">
                                <span style="font-size:0.78rem;background:var(--crm-bg);padding:0.2rem 0.6rem;border-radius:20px;border:1px solid var(--crm-border)">
                                    {{ \App\Models\Proposal::platforms()[$proposal->platform] ?? $proposal->platform }}
                                    @if($proposal->fiverr_username) · {{ '@'.$proposal->fiverr_username }} @endif
                                </span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h4 style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--crm-text-muted);margin:0 0 0.75rem">Project</h4>
                        <div style="font-weight:700;font-size:1rem">{{ $proposal->project_title }}</div>
                        @if($proposal->project_description)
                            <div style="font-size:0.85rem;color:var(--crm-text-muted);margin-top:0.4rem;line-height:1.55">{!! $proposal->project_description !!}</div>
                        @endif
                        <div style="display:flex;gap:1.25rem;margin-top:0.75rem;flex-wrap:wrap">
                            @if($proposal->timeline)
                                <div style="font-size:0.82rem"><i class="ri-calendar-line" style="color:#FF6400"></i> {{ $proposal->timeline }}</div>
                            @endif
                            @if($proposal->revision_rounds !== null)
                                <div style="font-size:0.82rem"><i class="ri-refresh-line" style="color:#FF6400"></i> {{ $proposal->revision_rounds }} Revisions</div>
                            @endif
                            @if($proposal->valid_until)
                                <div style="font-size:0.82rem"><i class="ri-time-line" style="color:{{ $proposal->valid_until->isPast() ? '#ef4444' : '#FF6400' }}"></i>
                                    Valid until {{ $proposal->valid_until->format('d M Y') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Line Items --}}
            @php $hasDelivery = $proposal->items->filter(fn($i) => !empty($i->delivery_days))->isNotEmpty(); @endphp
            <div class="crm-card" style="padding:0;overflow:hidden">
                <div style="padding:1.25rem;border-bottom:1px solid var(--crm-border)">
                    <h3 style="font-size:0.95rem;font-weight:700;margin:0">Scope of Work</h3>
                </div>
                <table class="crm-table">
                    <thead>
                        <tr>
                            <th style="width:36px">#</th>
                            <th>Service / Deliverable</th>
                            @if($hasDelivery)
                                <th style="width:110px;text-align:center">Delivery Days</th>
                            @endif
                            <th style="width:130px;text-align:right">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proposal->items as $index => $item)
                            <tr>
                                <td style="color:var(--crm-text-muted);font-size:0.8rem">{{ $index + 1 }}</td>
                                <td>
                                    <div style="font-weight:600">{{ $item->title }}</div>
                                    @if($item->description)
                                        <div style="font-size:0.8rem;color:var(--crm-text-muted);margin-top:0.2rem">{{ $item->description }}</div>
                                    @endif
                                </td>
                                @if($hasDelivery)
                                    <td style="text-align:center;font-size:0.85rem;color:var(--crm-text-muted)">
                                        {{ $item->delivery_days ?: '—' }}
                                    </td>
                                @endif
                                <td style="text-align:right;font-weight:700;color:#FF6400">
                                    {{ $proposal->currency }} {{ number_format($item->total, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @if($proposal->milestone_mode && !empty($proposal->milestones))
                            @foreach($proposal->milestones as $ms)
                                <tr style="border-top:1px solid var(--crm-border)">
                                    <td colspan="{{ $hasDelivery ? 3 : 2 }}" style="text-align:right;font-size:0.85rem;color:var(--crm-text-muted);padding:0.5rem 1rem">
                                        {{ $ms['label'] ?? '' }}
                                    </td>
                                    <td style="text-align:right;padding:0.5rem 1rem;font-weight:600">
                                        {{ $proposal->currency }} {{ number_format((float)($ms['amount'] ?? 0), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        <tr style="background:#FF640012;border-top:2px solid var(--crm-border)">
                            <td colspan="{{ $hasDelivery ? 3 : 2 }}" style="text-align:right;font-weight:800;font-size:1rem;padding:0.75rem 1rem;color:#FF6400">TOTAL</td>
                            <td style="text-align:right;font-weight:800;font-size:1.05rem;padding:0.75rem 1rem;color:#FF6400">
                                {{ $proposal->currency }} {{ number_format($proposal->total_amount, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Terms --}}
            @if($proposal->terms_conditions)
                <div class="crm-card">
                    <h3 style="font-size:0.9rem;font-weight:700;margin:0 0 0.75rem">Terms & Conditions</h3>
                    <div style="font-size:0.85rem;line-height:1.7;white-space:pre-line;color:var(--crm-text-muted)">{{ $proposal->terms_conditions }}</div>
                </div>
            @endif

            {{-- Internal Notes --}}
            @if($proposal->notes)
                <div class="crm-card" style="border-left:3px solid #f59e0b">
                    <h3 style="font-size:0.85rem;font-weight:700;margin:0 0 0.5rem;color:#f59e0b">
                        <i class="ri-sticky-note-line"></i> Internal Notes <span style="font-weight:400;font-size:0.78rem">(not shown in PDF)</span>
                    </h3>
                    <div style="font-size:0.85rem;line-height:1.6;white-space:pre-line">{{ $proposal->notes }}</div>
                </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:1.5rem">

            {{-- Status Card --}}
            <div class="crm-card">
                <h3 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--crm-text-muted);margin:0 0 1rem">Status</h3>
                <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:1.25rem">
                    <span style="display:inline-flex;align-items:center;padding:0.35rem 1rem;border-radius:20px;font-size:0.85rem;font-weight:700;background:{{ $proposal->statusColor() }}22;color:{{ $proposal->statusColor() }}">
                        {{ $proposal->statusLabel() }}
                    </span>
                </div>

                <form method="POST" action="{{ route('admin.proposals.status', $proposal) }}">
                    @csrf @method('PATCH')
                    <div class="form-group" style="margin-bottom:0.75rem">
                        <label class="form-label" style="font-size:0.8rem">Change Status</label>
                        <select name="status" class="form-control" style="font-size:0.85rem">
                            @foreach(['draft' => 'Draft', 'sent' => 'Sent', 'viewed' => 'Viewed', 'accepted' => 'Accepted', 'rejected' => 'Rejected', 'expired' => 'Expired'] as $key => $label)
                                <option value="{{ $key }}" {{ $proposal->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-secondary" style="width:100%;justify-content:center;font-size:0.85rem" data-loading-text="Updating…">
                        Update Status
                    </button>
                </form>
            </div>

            {{-- Quick Actions --}}
            <div class="crm-card">
                <h3 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--crm-text-muted);margin:0 0 1rem">Actions</h3>
                <div style="display:flex;flex-direction:column;gap:0.6rem">
                    <a href="{{ route('admin.proposals.preview', $proposal) }}" target="_blank" class="btn btn-secondary" style="justify-content:center">
                        <i class="ri-eye-line"></i> Preview PDF
                    </a>
                    <a href="{{ route('admin.proposals.pdf', $proposal) }}" target="_blank" class="btn btn-primary" style="justify-content:center">
                        <i class="ri-download-line"></i> Download PDF
                    </a>
                    @if($proposal->status === 'draft')
                        <a href="{{ route('admin.proposals.edit', $proposal) }}" class="btn btn-secondary" style="justify-content:center">
                            <i class="ri-edit-line"></i> Edit Proposal
                        </a>
                    @endif
                    <form method="POST" action="{{ route('admin.proposals.duplicate', $proposal) }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary" style="width:100%;justify-content:center" data-loading-text="Duplicating…">
                            <i class="ri-file-copy-line"></i> Duplicate
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.proposals.destroy', $proposal) }}"
                        onsubmit="return confirm('Delete this proposal? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center" data-loading-text="Deleting…">
                            <i class="ri-delete-bin-line"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            {{-- Meta --}}
            <div class="crm-card">
                <h3 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--crm-text-muted);margin:0 0 0.75rem">Info</h3>
                <div style="display:flex;flex-direction:column;gap:0.5rem;font-size:0.82rem">
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:var(--crm-text-muted)">Created by</span>
                        <span>{{ $proposal->creator?->name ?? '—' }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:var(--crm-text-muted)">Created</span>
                        <span>{{ $proposal->created_at->format('d M Y') }}</span>
                    </div>
                    @if($proposal->sent_at)
                        <div style="display:flex;justify-content:space-between">
                            <span style="color:var(--crm-text-muted)">Sent</span>
                            <span>{{ $proposal->sent_at->format('d M Y') }}</span>
                        </div>
                    @endif
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:var(--crm-text-muted)">PDF Sections</span>
                        <span>{{ collect($proposal->sections_enabled ?? [])->filter()->count() ?: 7 }}/7 enabled</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-layouts.backend>
