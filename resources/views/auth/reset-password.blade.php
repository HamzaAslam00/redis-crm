<x-guest-layout>
    <h2 class="auth-heading">Reset Password</h2>
    <p class="auth-sub">Choose a strong new password for your account.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                required autofocus autocomplete="username">
            @error('email')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">New Password</label>
            <input id="password" type="password" name="password"
                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="Minimum 8 characters"
                required autocomplete="new-password">
            @error('password')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                class="form-control"
                placeholder="Repeat your new password"
                required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:0.75rem 1rem;font-size:0.9rem">
            Reset Password
        </button>
    </form>
</x-guest-layout>
