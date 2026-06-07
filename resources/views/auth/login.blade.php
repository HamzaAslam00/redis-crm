<x-guest-layout>
    @if(session('status'))
    <div class="auth-alert-success">{{ session('status') }}</div>
    @endif

    <h2 class="auth-heading">Welcome back</h2>
    <p class="auth-sub">Sign in to your CRM account to continue.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                placeholder="admin@redissolution.com"
                required autofocus autocomplete="username">
            @error('email')
            <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input id="password" type="password" name="password"
                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="••••••••"
                required autocomplete="current-password">
            @error('password')
            <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
            <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer">
                <input type="checkbox" name="remember" id="remember_me"
                    style="width:16px;height:16px;accent-color:#FF6400;cursor:pointer;border-radius:4px">
                <span style="font-size:0.825rem;color:rgba(255,255,255,0.4)">Remember me</span>
            </label>

            @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}"
                style="font-size:0.78rem;color:rgba(255,100,0,0.7);transition:color 0.15s;text-decoration:none"
                onmouseover="this.style.color='#FF6400'" onmouseout="this.style.color='rgba(255,100,0,0.7)'">
                Forgot password?
            </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:0.75rem 1rem;font-size:0.9rem">
            Sign In
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
        </button>
    </form>
</x-guest-layout>
