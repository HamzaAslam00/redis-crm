<div>

    {{-- Reminder Modal --}}
    @if($showReminderModal)
        <div style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem"
             x-data="{ channels: $wire.entangle('reminderChannels') }"
             x-on:keydown.escape.window="$wire.closeReminderModal()">

            {{-- Backdrop --}}
            <div style="position:absolute;inset:0;background:var(--crm-modal-overlay);backdrop-filter:blur(4px)"
                 x-on:click="$wire.closeReminderModal()"></div>

            {{-- Modal box --}}
            <div style="position:relative;background:var(--crm-card);border:1px solid var(--crm-border);border-radius:16px;padding:1.75rem;width:100%;max-width:460px;z-index:1;box-shadow:var(--crm-shadow)">

                {{-- Header --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid var(--crm-border)">
                    <div>
                        <h3 style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--crm-text);margin:0 0 0.15rem;display:flex;align-items:center;gap:0.45rem">
                            <i class="ri-alarm-line" style="color:#FF6400;font-size:1.1rem"></i> Set Reminder
                        </h3>
                        <p style="font-size:0.75rem;color:var(--crm-text-muted);margin:0">Alert yourself on a date via selected channels</p>
                    </div>
                    <button type="button" wire:click="closeReminderModal"
                        style="background:var(--crm-hover);border:1px solid var(--crm-border);color:var(--crm-text-muted);font-size:1rem;cursor:pointer;line-height:1;padding:0.4rem;border-radius:8px;display:flex;align-items:center">
                        <i class="ri-close-line"></i>
                    </button>
                </div>

                {{-- Date + Time row --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1.1rem">
                    <div class="form-group" style="margin:0">
                        <label class="form-label" style="font-size:0.78rem">Date</label>
                        <input type="date" wire:model="reminderDate" class="form-control"
                            min="{{ now()->format('Y-m-d') }}">
                        @error('reminderDate')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="margin:0">
                        <label class="form-label" style="font-size:0.78rem">Time</label>
                        <input type="time" wire:model="reminderTime" class="form-control">
                        @error('reminderTime')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Channels — Alpine-driven for instant toggle feedback --}}
                <div class="form-group" style="margin-bottom:1.1rem">
                    <label class="form-label" style="font-size:0.78rem;margin-bottom:0.5rem;display:block">
                        Alert via <span style="color:var(--crm-text-muted);font-weight:400">(select one or more)</span>
                    </label>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0.5rem">

                        {{-- In-App --}}
                        <label x-bind:style="channels.includes('system')
                                ? 'border-color:#FF6400;background:rgba(255,100,0,0.1);color:#FF6400'
                                : 'border-color:var(--crm-border);background:var(--crm-hover);color:var(--crm-text)'"
                            style="display:flex;flex-direction:column;align-items:center;gap:0.35rem;cursor:pointer;font-size:0.78rem;font-weight:600;padding:0.7rem 0.5rem;border-radius:10px;border:1.5px solid;transition:all 0.15s;user-select:none;text-align:center">
                            <input type="checkbox" value="system" style="display:none"
                                x-bind:checked="channels.includes('system')"
                                x-on:change="channels.includes('system') ? channels.splice(channels.indexOf('system'),1) : channels.push('system')">
                            <i class="ri-notification-3-line"
                               x-bind:style="channels.includes('system') ? 'font-size:1.3rem;color:#FF6400' : 'font-size:1.3rem;color:var(--crm-text-muted)'"></i>
                            In-App
                        </label>

                        {{-- Email --}}
                        <label x-bind:style="channels.includes('email')
                                ? 'border-color:#FF6400;background:rgba(255,100,0,0.1);color:#FF6400'
                                : 'border-color:var(--crm-border);background:var(--crm-hover);color:var(--crm-text)'"
                            style="display:flex;flex-direction:column;align-items:center;gap:0.35rem;cursor:pointer;font-size:0.78rem;font-weight:600;padding:0.7rem 0.5rem;border-radius:10px;border:1.5px solid;transition:all 0.15s;user-select:none;text-align:center">
                            <input type="checkbox" value="email" style="display:none"
                                x-bind:checked="channels.includes('email')"
                                x-on:change="channels.includes('email') ? channels.splice(channels.indexOf('email'),1) : channels.push('email')">
                            <i class="ri-mail-send-line"
                               x-bind:style="channels.includes('email') ? 'font-size:1.3rem;color:#FF6400' : 'font-size:1.3rem;color:var(--crm-text-muted)'"></i>
                            Email
                        </label>

                        {{-- WhatsApp --}}
                        <label x-bind:style="channels.includes('whatsapp')
                                ? 'border-color:#25D366;background:rgba(37,211,102,0.1);color:#25D366'
                                : 'border-color:var(--crm-border);background:var(--crm-hover);color:var(--crm-text)'"
                            style="display:flex;flex-direction:column;align-items:center;gap:0.35rem;cursor:pointer;font-size:0.78rem;font-weight:600;padding:0.7rem 0.5rem;border-radius:10px;border:1.5px solid;transition:all 0.15s;user-select:none;text-align:center">
                            <input type="checkbox" value="whatsapp" style="display:none"
                                x-bind:checked="channels.includes('whatsapp')"
                                x-on:change="channels.includes('whatsapp') ? channels.splice(channels.indexOf('whatsapp'),1) : channels.push('whatsapp')">
                            <i class="ri-whatsapp-line"
                               x-bind:style="channels.includes('whatsapp') ? 'font-size:1.3rem;color:#25D366' : 'font-size:1.3rem;color:var(--crm-text-muted)'"></i>
                            WhatsApp
                        </label>

                    </div>
                    @error('reminderChannels')<div class="form-error" style="margin-top:0.4rem">{{ $message }}</div>@enderror

                    {{-- WhatsApp setup warning — Alpine-driven so it reacts instantly --}}
                    @if(!auth()->user()->phone || !auth()->user()->callmebot_key)
                        <div x-show="channels.includes('whatsapp')" x-cloak
                            style="margin-top:0.6rem;padding:0.55rem 0.75rem;background:rgba(251,191,36,0.08);border:1px solid rgba(251,191,36,0.25);border-radius:8px;font-size:0.73rem;color:#FBBF24;display:flex;align-items:flex-start;gap:0.4rem">
                            <i class="ri-alert-line" style="margin-top:1px;flex-shrink:0"></i>
                            <span>WhatsApp requires your phone number and Callmebot key.
                                <a href="{{ route('profile.edit') }}" style="color:#FF6400;text-decoration:underline;font-weight:600">Set up in Profile →</a>
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Optional reminder note --}}
                <div class="form-group" style="margin-bottom:1.4rem">
                    <label class="form-label" style="font-size:0.78rem">Custom reminder note <span style="color:var(--crm-text-muted);font-weight:400">(optional)</span></label>
                    <input type="text" wire:model="reminderMessage" class="form-control"
                        placeholder="e.g. Follow up with client before meeting">
                </div>

                {{-- Actions --}}
                <div style="display:flex;align-items:center;gap:0.5rem;justify-content:flex-end;padding-top:1rem;border-top:1px solid var(--crm-border)">
                    @if($reminderExists)
                        <button type="button" wire:click="removeReminder({{ $reminderNoteId }})"
                            class="btn btn-secondary" style="color:#F87171;border-color:rgba(248,113,113,0.4);margin-right:auto">
                            <i class="ri-delete-bin-line"></i> Remove Reminder
                        </button>
                    @endif
                    <button type="button" wire:click="closeReminderModal" class="btn btn-secondary">Cancel</button>
                    <button type="button" wire:click="saveReminder" class="btn btn-primary">
                        <i class="ri-alarm-line"></i> Save
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- Filters --}}
    <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem">
        <div class="search-wrap" style="flex:1;min-width:200px;max-width:360px">
            <i class="ri-search-line"></i>
            <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search notes…">
        </div>

        @if(count($allTags) > 0)
            <select wire:model.live="tagFilter" class="form-control" style="width:auto;min-width:130px">
                <option value="">All Tags</option>
                @foreach($allTags as $tag)
                    <option value="{{ $tag }}">{{ $tag }}</option>
                @endforeach
            </select>
        @endif

        @if($isSuperAdmin)
            <select wire:model.live="userFilter" class="form-control" style="width:auto;min-width:150px">
                <option value="">All Users</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        @endif

    </div>

    {{-- Notes Grid --}}
    @if($notes->isEmpty())
        <div class="crm-card" style="text-align:center;padding:4rem 1rem;color:var(--crm-text-muted)">
            <i class="ri-sticky-note-line" style="font-size:3rem;display:block;margin-bottom:0.75rem;opacity:0.3"></i>
            <p style="font-size:0.9rem">No notes yet. Create your first note!</p>
            @can('note.create')
                <a href="{{ route('admin.notes.create') }}" class="btn btn-primary" style="margin-top:1rem">
                    <i class="ri-add-line"></i> New Note
                </a>
            @endcan
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1rem">
            @foreach($notes as $note)
                @php
                    $bg = $note->color ?: '#ffffff';
                    $isDark = false; // note cards always on light bg for readability
                @endphp
                <div style="background:{{ $bg }};border-radius:12px;padding:1.25rem;border:1px solid rgba(0,0,0,0.08);position:relative;display:flex;flex-direction:column;min-height:180px;transition:box-shadow 0.15s"
                    onmouseenter="this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)'"
                    onmouseleave="this.style.boxShadow='none'">

                    {{-- Pin badge --}}
                    @if($note->is_pinned)
                        <span style="position:absolute;top:0.75rem;right:0.75rem;color:#FF6400;font-size:1rem" title="Pinned"><i class="ri-pushpin-fill"></i></span>
                    @endif

                    {{-- Owner badge (super-admin only) --}}
                    @if($isSuperAdmin && $note->user)
                        <div style="margin-bottom:0.5rem">
                            <span style="display:inline-flex;align-items:center;gap:0.25rem;background:rgba(0,0,0,0.07);color:#555;font-size:0.68rem;font-weight:600;padding:0.15rem 0.55rem;border-radius:50px">
                                <i class="ri-user-3-line" style="font-size:0.65rem"></i>
                                {{ $note->user->name }}
                            </span>
                        </div>
                    @endif

                    {{-- Title --}}
                    @if($note->title)
                        <h3 style="font-size:0.9rem;font-weight:700;color:#1a1a1a;margin:0 0 0.5rem;padding-right:1.5rem">{{ $note->title }}</h3>
                    @endif

                    {{-- Content preview --}}
                    <div style="font-size:0.8rem;color:#444;line-height:1.55;flex:1;overflow:hidden;display:-webkit-box;-webkit-line-clamp:5;-webkit-box-orient:vertical">
                        {!! strip_tags($note->content) !!}
                    </div>

                    {{-- Tags --}}
                    @if($note->tags)
                        <div style="display:flex;flex-wrap:wrap;gap:0.3rem;margin-top:0.75rem">
                            @foreach($note->tags as $tag)
                                <span style="background:rgba(0,0,0,0.07);color:#555;font-size:0.7rem;padding:0.15rem 0.5rem;border-radius:50px">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Reminder status badge --}}
                    @php $reminder = $note->reminder; @endphp
                    @if($reminder)
                        @php
                            $badgeColor = match($reminder->status) {
                                'pending' => ['bg' => 'rgba(255,100,0,0.12)', 'color' => '#FF6400', 'icon' => 'ri-alarm-line'],
                                'sent'    => ['bg' => 'rgba(52,211,153,0.12)',  'color' => '#34D399', 'icon' => 'ri-checkbox-circle-line'],
                                default   => ['bg' => 'rgba(248,113,113,0.12)','color' => '#F87171', 'icon' => 'ri-alarm-warning-line'],
                            };
                        @endphp
                        <div style="margin-top:0.6rem">
                            <span style="display:inline-flex;align-items:center;gap:0.3rem;font-size:0.68rem;font-weight:600;padding:0.2rem 0.55rem;border-radius:50px;background:{{ $badgeColor['bg'] }};color:{{ $badgeColor['color'] }}">
                                <i class="{{ $badgeColor['icon'] }}" style="font-size:0.65rem"></i>
                                @if($reminder->status === 'pending')
                                    Alert: {{ $reminder->remind_at->format('d M, h:i A') }}
                                @elseif($reminder->status === 'sent')
                                    Reminded {{ $reminder->remind_at->format('d M') }}
                                @else
                                    Alert failed
                                @endif
                            </span>
                        </div>
                    @endif

                    {{-- Footer --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:0.75rem;padding-top:0.75rem;border-top:1px solid rgba(0,0,0,0.08)">
                        <span style="font-size:0.7rem;color:#888">{{ $note->updated_at->diffForHumans() }}</span>
                        <div style="display:flex;align-items:center;gap:0.35rem">
                            {{-- Reminder bell --}}
                            <button type="button" wire:click="openReminderModal({{ $note->id }})"
                                class="btn btn-secondary btn-sm" title="Set Reminder"
                                style="padding:0.2rem 0.45rem;background:{{ $reminder && $reminder->status === 'pending' ? 'rgba(255,100,0,0.12)' : 'rgba(0,0,0,0.06)' }};border-color:{{ $reminder && $reminder->status === 'pending' ? 'rgba(255,100,0,0.3)' : 'rgba(0,0,0,0.1)' }};color:{{ $reminder && $reminder->status === 'pending' ? '#FF6400' : '#555' }}">
                                <i class="{{ $reminder && $reminder->status === 'pending' ? 'ri-alarm-fill' : 'ri-alarm-line' }}" style="font-size:0.8rem"></i>
                            </button>
                            <button wire:click="togglePin({{ $note->id }})" class="btn btn-secondary btn-sm" title="{{ $note->is_pinned ? 'Unpin' : 'Pin' }}"
                                style="padding:0.2rem 0.45rem;background:rgba(0,0,0,0.06);border-color:rgba(0,0,0,0.1);color:#555">
                                <i class="{{ $note->is_pinned ? 'ri-pushpin-fill' : 'ri-pushpin-line' }}" style="font-size:0.8rem"></i>
                            </button>
                            @can('note.edit')
                                <a href="{{ route('admin.notes.edit', $note) }}" class="btn btn-secondary btn-sm"
                                    style="padding:0.2rem 0.45rem;background:rgba(0,0,0,0.06);border-color:rgba(0,0,0,0.1);color:#555">
                                    <i class="ri-pencil-line" style="font-size:0.8rem"></i>
                                </a>
                            @endcan
                            @can('note.delete')
                                <button type="button" class="btn btn-danger btn-sm"
                                    style="padding:0.2rem 0.45rem"
                                    data-id="{{ $note->id }}"
                                    x-on:click="deleteWire($el, $wire)">
                                    <i class="ri-delete-bin-line" style="font-size:0.8rem"></i>
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
