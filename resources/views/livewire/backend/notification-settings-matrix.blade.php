<div>

    <div style="overflow-x:auto">
        <table class="crm-table">
            <thead>
                <tr>
                    <th style="width:40%">Event</th>
                    <th style="width:30%">Description</th>
                    <th style="text-align:center;width:15%">
                        <i class="ri-notification-3-line" style="color:#FF6400"></i> In-App
                    </th>
                    <th style="text-align:center;width:15%">
                        <i class="ri-mail-line" style="color:#FF6400"></i> Email
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>
                            <span style="font-weight:600;color:var(--crm-text);font-size:0.875rem">{{ $event->label }}</span>
                        </td>
                        <td style="font-size:0.8rem;color:var(--crm-text-muted)">
                            {{ $event->description }}
                        </td>
                        <td style="text-align:center">
                            @php $inApp = $settings[$event->event_key]['in_app_enabled'] ?? false; @endphp
                            <button
                                wire:click="toggle('{{ $event->event_key }}', 'in_app_enabled')"
                                wire:loading.attr="disabled"
                                style="width:44px;height:24px;border-radius:50px;position:relative;border:none;cursor:pointer;transition:background 0.2s;background:{{ $inApp ? '#FF6400' : 'var(--crm-border)' }}"
                                title="{{ $inApp ? 'Disable' : 'Enable' }}">
                                <span style="position:absolute;top:2px;width:20px;height:20px;border-radius:50%;background:#fff;transition:left 0.2s;box-shadow:0 1px 4px rgba(0,0,0,0.2);left:{{ $inApp ? '22px' : '2px' }}"></span>
                            </button>
                        </td>
                        <td style="text-align:center">
                            @php $emailOn = $settings[$event->event_key]['email_enabled'] ?? false; @endphp
                            <button
                                wire:click="toggle('{{ $event->event_key }}', 'email_enabled')"
                                wire:loading.attr="disabled"
                                style="width:44px;height:24px;border-radius:50px;position:relative;border:none;cursor:pointer;transition:background 0.2s;background:{{ $emailOn ? '#FF6400' : 'var(--crm-border)' }}"
                                title="{{ $emailOn ? 'Disable' : 'Enable' }}">
                                <span style="position:absolute;top:2px;width:20px;height:20px;border-radius:50%;background:#fff;transition:left 0.2s;box-shadow:0 1px 4px rgba(0,0,0,0.2);left:{{ $emailOn ? '22px' : '2px' }}"></span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:2rem;color:var(--crm-text-muted)">
                            No notification events found. Run <code>php artisan db:seed --class=NotificationSettingsSeeder</code>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1rem;padding:0.75rem 1rem;background:rgba(99,102,241,0.07);border:1px solid rgba(99,102,241,0.2);border-radius:8px;font-size:0.8rem;color:var(--crm-text-muted)">
        <i class="ri-information-line" style="color:#6366f1"></i>
        Changes save <strong style="color:var(--crm-text)">instantly</strong> when you toggle — no save button needed.
        Email notifications require SMTP to be configured in the <strong style="color:var(--crm-text)">SMTP</strong> tab.
    </div>

</div>
