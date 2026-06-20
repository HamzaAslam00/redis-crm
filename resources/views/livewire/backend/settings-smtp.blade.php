<div>

    {{-- SMTP Fields --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem">

        <div class="form-group">
            <label class="form-label">SMTP Host</label>
            <input wire:model="smtp_host" type="text" class="form-control" placeholder="smtp.gmail.com">
            @error('smtp_host')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Port</label>
            <input wire:model="smtp_port" type="number" class="form-control" placeholder="587">
            @error('smtp_port')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Username</label>
            <input wire:model="smtp_username" type="text" class="form-control" placeholder="you@gmail.com" autocomplete="off">
            @error('smtp_username')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <div style="position:relative">
                <input wire:model="smtp_password"
                    type="{{ $showPassword ? 'text' : 'password' }}"
                    class="form-control"
                    placeholder="App password"
                    autocomplete="new-password"
                    style="padding-right:2.75rem">
                <button type="button" wire:click="$toggle('showPassword')"
                    style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--crm-text-muted);cursor:pointer;padding:0;line-height:1">
                    <i class="{{ $showPassword ? 'ri-eye-off-line' : 'ri-eye-line' }}" style="font-size:1rem"></i>
                </button>
            </div>
            @error('smtp_password')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Encryption</label>
            <select wire:model="smtp_encryption" class="form-control">
                <option value="tls">TLS (recommended)</option>
                <option value="ssl">SSL</option>
                <option value="none">None</option>
            </select>
            @error('smtp_encryption')<p class="form-error">{{ $message }}</p>@enderror
        </div>

    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;padding-top:1rem;border-top:1px solid var(--crm-border)">

        <div class="form-group">
            <label class="form-label">From Email Address</label>
            <input wire:model="smtp_from_address" type="email" class="form-control" placeholder="noreply@redissolution.com">
            @error('smtp_from_address')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">From Name</label>
            <input wire:model="smtp_from_name" type="text" class="form-control" placeholder="Redis Solution">
            @error('smtp_from_name')<p class="form-error">{{ $message }}</p>@enderror
        </div>

    </div>

    {{-- Notification Recipients --}}
    <div style="padding-top:1rem;border-top:1px solid var(--crm-border);margin-bottom:1.5rem">
        <p style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin:0 0 1rem">
            <i class="ri-inbox-line" style="color:#FF6400"></i> Notification Recipients
        </p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">

            <div class="form-group">
                <label class="form-label">Primary Email (To)</label>
                <input wire:model="mail_to" type="email" class="form-control" placeholder="admin@redissolution.com">
                <p style="font-size:0.72rem;color:var(--crm-text-muted);margin-top:0.3rem">
                    All system emails (contact forms, renewals, alerts) will be sent here.
                </p>
                @error('mail_to')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">CC Addresses</label>
                <input wire:model="mail_cc" type="text" class="form-control" placeholder="email1@example.com, email2@example.com">
                <p style="font-size:0.72rem;color:var(--crm-text-muted);margin-top:0.3rem">
                    Multiple emails — separate with commas.
                </p>
                @error('mail_cc')<p class="form-error">{{ $message }}</p>@enderror
            </div>

        </div>
    </div>

    {{-- Actions --}}
    <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap">

        <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap">
            <button type="button" wire:click="sendTestEmail" wire:loading.attr="disabled" wire:target="sendTestEmail"
                class="btn btn-secondary"
                style="display:inline-flex;align-items:center;gap:0.4rem">
                <span wire:loading.remove wire:target="sendTestEmail">
                    <i class="ri-mail-send-line"></i> Send Test Email
                </span>
                <span wire:loading wire:target="sendTestEmail" style="display:none;align-items:center;gap:0.4rem">
                    <span style="width:14px;height:14px;border:2px solid var(--crm-border);border-top-color:#FF6400;border-radius:50%;animation:spin 0.7s linear infinite;display:inline-block;vertical-align:middle;margin-right:0.35rem"></span>Sending…
                </span>
            </button>
            <input wire:model="mail_test_to" type="email" class="form-control"
                placeholder="info@redissolution.com"
                style="width:220px;height:36px;font-size:0.82rem"
                title="Test email will be sent to this address">
            @error('mail_test_to')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <button type="button" wire:click="save" wire:loading.attr="disabled" wire:target="save"
            class="btn btn-primary"
            style="display:inline-flex;align-items:center;gap:0.4rem">
            <span wire:loading.remove wire:target="save"><i class="ri-save-line"></i> Save SMTP Settings</span>
            <span wire:loading wire:target="save">Saving…</span>
        </button>

    </div>

    {{-- Gmail hint --}}
    <div style="margin-top:1.25rem;padding:0.875rem 1rem;background:rgba(99,102,241,0.07);border:1px solid rgba(99,102,241,0.2);border-radius:8px;font-size:0.8rem;color:var(--crm-text-muted);line-height:1.6">
        <strong style="color:var(--crm-text)"><i class="ri-information-line" style="color:#6366f1"></i> Gmail users:</strong>
        Use an <strong>App Password</strong> (not your account password). Go to Google Account → Security → 2-Step Verification → App passwords.
        Host: <code style="background:var(--crm-hover);padding:0.1rem 0.4rem;border-radius:4px">smtp.gmail.com</code> · Port: <code style="background:var(--crm-hover);padding:0.1rem 0.4rem;border-radius:4px">587</code> · Encryption: <code style="background:var(--crm-hover);padding:0.1rem 0.4rem;border-radius:4px">TLS</code>
    </div>

</div>
