<x-layouts.backend title="My Profile">

    <x-backend.page-header title="My Profile" description="Manage your account information and security settings." />

    {{-- Avatar + Name hero strip --}}
    <div class="crm-card" style="display:flex;align-items:center;gap:1.25rem;margin-bottom:1.5rem;padding:1.25rem 1.5rem">
        <div style="width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#FF6400,#FFB800);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:700;color:#fff;flex-shrink:0">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div>
            <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--crm-text)">{{ Auth::user()->name }}</div>
            <div style="font-size:0.8rem;color:var(--crm-text-muted);margin-top:0.15rem">{{ Auth::user()->email }}</div>
        </div>
        <div style="margin-left:auto">
            @foreach(Auth::user()->getRoleNames() as $role)
            <span style="display:inline-flex;align-items:center;padding:0.25rem 0.75rem;border-radius:999px;font-size:0.7rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;background:rgba(255,100,0,0.12);color:#FF6400;border:1px solid rgba(255,100,0,0.2)">{{ $role }}</span>
            @endforeach
        </div>
    </div>

    <div style="display:grid;gap:1.25rem">

        {{-- Profile Information --}}
        <div class="crm-card">
            <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--crm-border)">
                <h3 style="font-family:'Syne',sans-serif;font-size:0.95rem;font-weight:700;color:var(--crm-text);margin:0">Profile Information</h3>
                <p style="font-size:0.8rem;color:var(--crm-text-muted);margin:0.2rem 0 0">Update your name and email address.</p>
            </div>
            <div style="padding:1.5rem">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Change Password --}}
        <div class="crm-card">
            <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--crm-border)">
                <h3 style="font-family:'Syne',sans-serif;font-size:0.95rem;font-weight:700;color:var(--crm-text);margin:0">Change Password</h3>
                <p style="font-size:0.8rem;color:var(--crm-text-muted);margin:0.2rem 0 0">Use a long, random password to keep your account secure.</p>
            </div>
            <div style="padding:1.5rem">
                @include('profile.partials.update-password-form')
            </div>
        </div>

    </div>

</x-layouts.backend>
