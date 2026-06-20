<x-layouts.backend :title="'Contact — ' . $contact->name">

    @php
        $statusColors = [
            'new'     => ['bg' => 'rgba(255,100,0,0.12)',    'color' => '#FF6400'],
            'read'    => ['bg' => 'rgba(99,102,241,0.12)',   'color' => '#6366f1'],
            'replied' => ['bg' => 'rgba(16,185,129,0.12)',   'color' => '#10b981'],
        ];
        $sc = $statusColors[$contact->status] ?? ['bg' => 'rgba(107,114,128,0.1)', 'color' => 'var(--crm-text-muted)'];
    @endphp

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.75rem">
        <div style="display:flex;align-items:center;gap:1rem">
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
            <div>
                <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap">
                    <h1 class="page-title" style="margin:0">{{ $contact->name }}</h1>
                    <span style="display:inline-flex;align-items:center;padding:0.2rem 0.65rem;border-radius:50px;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;background:{{ $sc['bg'] }};color:{{ $sc['color'] }}">
                        {{ $contact->status }}
                    </span>
                </div>
                <p style="font-size:0.8rem;color:var(--crm-text-muted);margin:0.25rem 0 0">
                    Received {{ $contact->created_at->format('d M Y \a\t h:i A') }}
                    @if($contact->read_at)
                        &nbsp;·&nbsp; Read {{ $contact->read_at->diffForHumans() }}
                    @endif
                </p>
            </div>
        </div>

        {{-- Status changer + delete --}}
        <div style="display:flex;align-items:center;gap:0.5rem">
            <form method="POST" action="{{ route('admin.contacts.status', $contact) }}" style="display:flex;align-items:center">
                @csrf @method('PATCH')
                <select name="status" class="form-control" style="min-width:130px;width:auto" onchange="this.form.submit()">
                    @foreach(['new' => 'New', 'read' => 'Read', 'replied' => 'Replied'] as $val => $label)
                        <option value="{{ $val }}" {{ $contact->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
            <form id="contact-delete-form" method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display:none">
                @csrf @method('DELETE')
            </form>
            <button
                onclick="deleteForm(this)"
                data-form="contact-delete-form"
                data-label="{{ $contact->name }}"
                class="btn btn-secondary btn-sm"
                style="color:#ef4444;border-color:rgba(239,68,68,0.3);padding:0.4rem 0.65rem"
                title="Delete this message">
                <i class="ri-delete-bin-line"></i>
            </button>
        </div>
    </div>

    @if(session('replied'))
        <div class="alert alert-success" style="margin-bottom:1.25rem">
            <i class="ri-check-line"></i> Reply sent successfully to <strong>{{ $contact->email }}</strong>.
        </div>
    @endif

    @if(session('notes_saved'))
        <div class="alert alert-success" style="margin-bottom:1.25rem">
            <i class="ri-check-line"></i> Notes saved.
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 340px;gap:1.25rem;align-items:start">

        {{-- LEFT: Message + Reply --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">

            {{-- Contact Info card --}}
            <div class="crm-card">
                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.25rem">
                    <i class="ri-user-line" style="color:#FF6400;font-size:1rem"></i>
                    <span style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">Contact Info</span>
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:1.25rem">
                    <div>
                        <div style="font-size:0.72rem;font-weight:600;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem">Name</div>
                        <div style="font-weight:600;color:var(--crm-text)">{{ $contact->name }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.72rem;font-weight:600;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem">Email</div>
                        <a href="mailto:{{ $contact->email }}" style="color:#FF6400;font-size:0.875rem;text-decoration:none">{{ $contact->email }}</a>
                    </div>
                    @if($contact->phone)
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem">Phone</div>
                            <a href="tel:{{ $contact->phone }}" style="color:var(--crm-text);font-size:0.875rem;text-decoration:none">{{ $contact->phone }}</a>
                        </div>
                    @endif
                    @if($contact->service)
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem">Service Interest</div>
                            <div style="font-size:0.875rem;color:var(--crm-text)">{{ $contact->service }}</div>
                        </div>
                    @endif
                    @if($contact->budget)
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem">Budget</div>
                            <div style="font-size:0.875rem;color:var(--crm-text)">{{ $contact->budget }}</div>
                        </div>
                    @endif
                    @if($contact->website_url)
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;color:var(--crm-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem">Website</div>
                            <a href="{{ $contact->website_url }}" target="_blank" rel="noopener" style="color:#FF6400;font-size:0.875rem;text-decoration:none;word-break:break-all">{{ $contact->website_url }}</a>
                        </div>
                    @endif
                </div>

                {{-- Message --}}
                <div style="border-top:1px solid var(--crm-border);padding-top:1.25rem">
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin-bottom:0.75rem">Message</div>
                    <div style="background:var(--crm-hover);border-left:3px solid #FF6400;border-radius:0 8px 8px 0;padding:1rem 1.25rem;font-size:0.9rem;color:var(--crm-text);line-height:1.7;white-space:pre-wrap">{{ $contact->message ?: '(no message)' }}</div>
                </div>
            </div>

            {{-- Reply Form --}}
            <div class="crm-card">
                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.25rem">
                    <i class="ri-reply-line" style="color:#FF6400;font-size:1rem"></i>
                    <span style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">Send Reply</span>
                </div>

                <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}">
                    @csrf

                    <div class="form-group" style="margin-bottom:1rem">
                        <label class="form-label">To</label>
                        <input type="text" class="form-control" value="{{ $contact->name }} &lt;{{ $contact->email }}&gt;" disabled style="opacity:0.6">
                    </div>

                    <div class="form-group" style="margin-bottom:1.25rem">
                        <label class="form-label">Your Reply <span style="color:#ef4444">*</span></label>
                        <textarea name="body" rows="10" class="form-control @error('body') is-invalid @enderror" required
                            placeholder="Type your reply here…"
                            style="resize:vertical;min-height:200px">{{ old('body') }}</textarea>
                        @error('body')
                            <div style="color:#ef4444;font-size:0.8rem;margin-top:0.3rem">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display:flex;align-items:center;justify-content:flex-end">
                        <button type="submit" class="btn btn-primary" data-loading-text="Sending…">
                            <i class="ri-send-plane-line"></i> Send Reply
                        </button>
                    </div>
                </form>
            </div>

            {{-- Reply History --}}
            @if($contact->replies->isNotEmpty())
                <div class="crm-card">
                    <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.25rem">
                        <i class="ri-history-line" style="color:#FF6400;font-size:1rem"></i>
                        <span style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">Reply History ({{ $contact->replies->count() }})</span>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:1rem">
                        @foreach($contact->replies->sortByDesc('sent_at') as $reply)
                            <div style="border:1px solid var(--crm-border);border-radius:10px;overflow:hidden">
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:0.75rem 1rem;background:var(--crm-hover);border-bottom:1px solid var(--crm-border)">
                                    <div>
                                        <span style="font-size:0.8rem;font-weight:600;color:var(--crm-text)">{{ $reply->subject }}</span>
                                        <span style="font-size:0.75rem;color:var(--crm-text-muted);margin-left:0.5rem">by {{ $reply->sender?->name ?? 'Admin' }}</span>
                                    </div>
                                    <span style="font-size:0.75rem;color:var(--crm-text-muted)">{{ $reply->sent_at->format('d M Y, h:i A') }}</span>
                                </div>
                                <div style="padding:1rem;font-size:0.85rem;color:var(--crm-text);line-height:1.65;white-space:pre-wrap">{{ $reply->body }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        {{-- RIGHT: Admin Notes --}}
        <div style="position:sticky;top:80px">
            <div class="crm-card">
                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem">
                    <i class="ri-sticky-note-line" style="color:#FF6400;font-size:1rem"></i>
                    <span style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">Admin Notes</span>
                </div>
                <form method="POST" action="{{ route('admin.contacts.notes', $contact) }}">
                    @csrf @method('PATCH')
                    <textarea name="admin_notes" rows="8" class="form-control"
                        style="resize:vertical;min-height:160px;font-size:0.85rem"
                        placeholder="Internal notes (not visible to client)…">{{ old('admin_notes', $contact->admin_notes) }}</textarea>
                    <button type="submit" class="btn btn-secondary" style="margin-top:0.75rem;width:100%">
                        <i class="ri-save-line"></i> Save Notes
                    </button>
                </form>

                <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid var(--crm-border)">
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin-bottom:0.75rem">Quick Info</div>
                    <div style="display:flex;flex-direction:column;gap:0.5rem;font-size:0.8rem;color:var(--crm-text-muted)">
                        <div style="display:flex;justify-content:space-between">
                            <span>Replies sent</span>
                            <strong style="color:var(--crm-text)">{{ $contact->replies->count() }}</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between">
                            <span>Received</span>
                            <strong style="color:var(--crm-text)">{{ $contact->created_at->diffForHumans() }}</strong>
                        </div>
                        @if($contact->read_at)
                            <div style="display:flex;justify-content:space-between">
                                <span>First read</span>
                                <strong style="color:var(--crm-text)">{{ $contact->read_at->diffForHumans() }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-layouts.backend>
