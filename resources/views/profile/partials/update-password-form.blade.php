<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;margin-bottom:1.25rem">
        <div class="form-group" style="margin-bottom:0">
            <label class="form-label" for="update_password_current_password">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="form-control {{ $errors->updatePassword->get('current_password') ? 'is-invalid' : '' }}"
                autocomplete="current-password">
            @foreach($errors->updatePassword->get('current_password') as $error)
                <div class="form-error">{{ $error }}</div>
            @endforeach
        </div>

        <div class="form-group" style="margin-bottom:0">
            <label class="form-label" for="update_password_password">New Password</label>
            <input id="update_password_password" name="password" type="password"
                class="form-control {{ $errors->updatePassword->get('password') ? 'is-invalid' : '' }}"
                autocomplete="new-password">
            @foreach($errors->updatePassword->get('password') as $error)
                <div class="form-error">{{ $error }}</div>
            @endforeach
        </div>

        <div class="form-group" style="margin-bottom:0">
            <label class="form-label" for="update_password_password_confirmation">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control {{ $errors->updatePassword->get('password_confirmation') ? 'is-invalid' : '' }}"
                autocomplete="new-password">
            @foreach($errors->updatePassword->get('password_confirmation') as $error)
                <div class="form-error">{{ $error }}</div>
            @endforeach
        </div>
    </div>

    <div style="display:flex;align-items:center;gap:1rem">
        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
            Update Password
        </button>

        @if (session('status') === 'password-updated')
            <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)"
                style="font-size:0.8rem;color:#34D399;display:flex;align-items:center;gap:0.35rem">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                Password updated.
            </span>
        @endif
    </div>
</form>
