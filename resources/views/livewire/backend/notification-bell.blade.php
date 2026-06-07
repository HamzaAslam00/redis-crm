<div x-data="{ open: false }" style="position:relative">

    {{-- Bell button --}}
    <button
        @click="open = !open; if(open) $wire.loadNotifications()"
        @click.away="open = false"
        style="position:relative;width:36px;height:36px;border-radius:8px;background:var(--crm-input);border:1px solid var(--crm-border);display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--crm-text);transition:all 0.15s"
        :style="open ? 'background:rgba(255,100,0,0.12);border-color:rgba(255,100,0,0.3);color:#FF6400' : ''"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>

        @if($unreadCount > 0)
        <span style="position:absolute;top:-4px;right:-4px;width:18px;height:18px;border-radius:50%;background:#FF6400;color:#fff;font-size:0.65rem;font-weight:700;display:flex;align-items:center;justify-content:center;border:2px solid var(--crm-bg)">
            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
        </span>
        @endif
    </button>

    {{-- Dropdown panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display:none;position:absolute;right:0;top:calc(100% + 8px);width:320px;background:var(--crm-card);border:1px solid var(--crm-border);border-radius:12px;z-index:60;box-shadow:var(--crm-shadow);overflow:hidden"
        @click.away="open = false"
    >

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;padding:0.875rem 1rem;border-bottom:1px solid var(--crm-border)">
            <span style="font-family:'Syne',sans-serif;font-size:0.85rem;font-weight:700;color:var(--crm-text)">
                Notifications
                @if($unreadCount > 0)
                <span style="display:inline-flex;align-items:center;justify-content:center;min-width:18px;height:18px;padding:0 5px;border-radius:9px;background:rgba(255,100,0,0.15);color:#FF6400;font-size:0.65rem;font-weight:700;margin-left:0.35rem">{{ $unreadCount }}</span>
                @endif
            </span>
            @if($unreadCount > 0)
            <button wire:click="markAllRead" style="font-size:0.72rem;color:#FF6400;background:none;border:none;cursor:pointer;padding:0;transition:opacity 0.15s" onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">
                Mark all read
            </button>
            @endif
        </div>

        {{-- List --}}
        <div style="max-height:360px;overflow-y:auto">

            <div wire:loading.flex style="align-items:center;justify-content:center;padding:2rem;color:var(--crm-text-muted);font-size:0.8rem;gap:0.5rem">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;animation:spin 1s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                Loading...
            </div>

            <div wire:loading.remove>
                @forelse($notifications as $n)
                <div
                    wire:key="notif-{{ $n->id }}"
                    style="display:flex;align-items:flex-start;gap:0.75rem;padding:0.75rem 1rem;border-bottom:1px solid var(--crm-border);transition:background 0.1s;cursor:default;{{ $n->read_at ? 'opacity:0.55' : '' }}"
                    onmouseover="this.style.background='var(--crm-hover)'" onmouseout="this.style.background=''"
                >
                    {{-- Type icon --}}
                    <div style="flex-shrink:0;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-top:1px;
                        {{ $n->type === 'success' ? 'background:rgba(52,211,153,0.1);color:#34D399' : ($n->type === 'warning' ? 'background:rgba(251,191,36,0.1);color:#FBBF24' : ($n->type === 'error' ? 'background:rgba(248,113,113,0.1);color:#F87171' : 'background:rgba(255,100,0,0.1);color:#FF6400')) }}">
                        @if($n->type === 'success')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        @elseif($n->type === 'warning')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z" /></svg>
                        @elseif($n->type === 'error')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div style="flex:1;min-width:0">
                        <div style="font-size:0.8rem;font-weight:600;color:var(--crm-text);margin-bottom:0.15rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            {{ $n->title }}
                            @if(!$n->read_at)
                            <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#FF6400;margin-left:0.35rem;vertical-align:middle"></span>
                            @endif
                        </div>
                        @if($n->message)
                        <div style="font-size:0.73rem;color:var(--crm-text-muted);line-height:1.4;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">{{ $n->message }}</div>
                        @endif
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:0.35rem">
                            <span style="font-size:0.68rem;color:var(--crm-text-muted)">{{ $n->created_at->diffForHumans() }}</span>
                            @if(!$n->read_at)
                            <button wire:click="markRead({{ $n->id }})" style="font-size:0.68rem;color:#FF6400;background:none;border:none;cursor:pointer;padding:0;transition:opacity 0.15s" onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">Mark read</button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div style="padding:2.5rem 1rem;text-align:center">
                    <div style="width:44px;height:44px;border-radius:12px;background:var(--crm-hover);border:1px solid var(--crm-border);display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;color:var(--crm-text-muted)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                    </div>
                    <div style="font-size:0.8rem;font-weight:600;color:var(--crm-text);margin-bottom:0.25rem">All caught up</div>
                    <div style="font-size:0.73rem;color:var(--crm-text-muted)">No notifications yet.</div>
                </div>
                @endforelse
            </div>

        </div>

    </div>
</div>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>
