<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem">
        <div class="form-group" style="margin-bottom:0">
            <label class="form-label" for="name">Full Name</label>
            <input id="name" name="name" type="text" class="form-control {{ $errors->get('name') ? 'is-invalid' : '' }}"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @foreach($errors->get('name') as $error)
                <div class="form-error">{{ $error }}</div>
            @endforeach
        </div>

        <div class="form-group" style="margin-bottom:0">
            <label class="form-label" for="email">Email Address</label>
            <input id="email" name="email" type="email" class="form-control {{ $errors->get('email') ? 'is-invalid' : '' }}"
                value="{{ old('email', $user->email) }}" required autocomplete="username">
            @foreach($errors->get('email') as $error)
                <div class="form-error">{{ $error }}</div>
            @endforeach

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top:0.5rem;font-size:0.75rem;color:#FBBF24">
                    Your email address is unverified.
                    <button form="send-verification" style="background:none;border:none;color:#FF6400;font-size:0.75rem;cursor:pointer;text-decoration:underline;padding:0">
                        Resend verification email
                    </button>
                </div>
                @if (session('status') === 'verification-link-sent')
                    <div style="margin-top:0.4rem;font-size:0.75rem;color:#34D399">Verification link sent to your email.</div>
                @endif
            @endif
        </div>
    </div>

    {{-- WhatsApp Alerts --}}
    <div style="border:1px solid var(--crm-border);border-radius:10px;padding:1rem 1.25rem;margin-bottom:1.25rem;background:rgba(37,211,102,0.04)">
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.75rem">
            <i class="ri-whatsapp-line" style="color:#25D366;font-size:1.1rem"></i>
            <span style="font-size:0.85rem;font-weight:700;color:var(--crm-text)">WhatsApp Alerts (Callmebot — free)</span>
        </div>
        <div style="font-size:0.78rem;color:var(--crm-text-muted);margin-bottom:0.85rem;line-height:1.55">
            To receive WhatsApp reminders:
            <ol style="margin:0.4rem 0 0 1rem;padding:0">
                <li>Save <strong style="color:var(--crm-text)">+34 644 10 28 72</strong> in your phone as <em>CallMeBot</em></li>
                <li>Send <code style="background:rgba(0,0,0,0.08);padding:0.1rem 0.3rem;border-radius:3px">I allow callmebot to send me messages</code> on WhatsApp</li>
                <li>Note: If you don't receive the ApiKey in 2 minutes, please try again after 24hs</li>
                <li>Copy the API key the bot sends back and paste it below</li>
            </ol>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
            <div class="form-group" style="margin:0">
                <label class="form-label" for="phone">WhatsApp Number <span style="color:var(--crm-text-muted);font-weight:400">(with country code)</span></label>
                <input id="phone" name="phone" type="text" class="form-control {{ $errors->get('phone') ? 'is-invalid' : '' }}"
                    value="{{ old('phone', $user->phone) }}" placeholder="+92 300 1234567">
                @foreach($errors->get('phone') as $error)
                    <div class="form-error">{{ $error }}</div>
                @endforeach
            </div>
            <div class="form-group" style="margin:0">
                <label class="form-label" for="callmebot_key">Callmebot API Key</label>
                <input id="callmebot_key" name="callmebot_key" type="text" class="form-control {{ $errors->get('callmebot_key') ? 'is-invalid' : '' }}"
                    value="{{ old('callmebot_key', $user->callmebot_key) }}" placeholder="e.g. 123456">
                @foreach($errors->get('callmebot_key') as $error)
                    <div class="form-error">{{ $error }}</div>
                @endforeach
            </div>
        </div>
    </div>

    <div style="display:flex;align-items:center;gap:1rem">
        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            Save Changes
        </button>

        @if (session('status') === 'profile-updated')
            <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)"
                style="font-size:0.8rem;color:#34D399;display:flex;align-items:center;gap:0.35rem">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                Profile updated.
            </span>
        @endif
    </div>
</form>
