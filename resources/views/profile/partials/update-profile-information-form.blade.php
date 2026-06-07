<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem">
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
