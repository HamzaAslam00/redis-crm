<x-guest-layout>
    <h2 class="auth-heading">Forgot Password</h2>
    <p class="auth-sub">Enter your email and we'll send you a reset link.</p>

    @if(session('status'))
    <div class="auth-alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                placeholder="admin@redissolution.com" required autofocus>
            @error('email')
            <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:0.75rem 1rem;font-size:0.9rem">
            Send Reset Link
        </button>

        <div style="text-align:center;margin-top:1.25rem">
            <a href="{{ route('login') }}"
                style="font-size:0.78rem;color:rgba(255,255,255,0.25);text-decoration:none;transition:color 0.15s;display:inline-flex;align-items:center;gap:0.35rem"
                onmouseover="this.style.color='rgba(255,100,0,0.7)'" onmouseout="this.style.color='rgba(255,255,255,0.25)'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                Back to login
            </a>
        </div>
    </form>
</x-guest-layout>
