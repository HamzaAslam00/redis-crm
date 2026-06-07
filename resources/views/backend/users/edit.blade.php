<x-layouts.backend title="Edit User">

    {{-- Page header --}}
    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm" title="Back">
            <i class="ri-arrow-left-line"></i>
        </a>
        <div>
            <h1 class="page-title">Edit User</h1>
            <p class="page-subtitle">Update {{ $user->name }}'s account details.</p>
        </div>
    </div>

    <div class="crm-card">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="form-grid-2">

                {{-- Name --}}
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}" placeholder="John Doe" autofocus>
                    @error('name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" placeholder="john@example.com">
                    @error('email')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- New Password --}}
                <div class="form-group">
                    <label class="form-label" for="password">
                        New Password
                        <span style="font-weight:400;font-size:0.72rem;color:var(--crm-text-muted);text-transform:none;letter-spacing:0">(leave blank to keep current)</span>
                    </label>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Min 8 chars, mixed case + number"
                        autocomplete="new-password">
                    @error('password')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control" placeholder="Repeat new password"
                        autocomplete="new-password">
                </div>

                {{-- Role --}}
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="role">Role</label>
                    @if($user->hasRole('super-admin'))
                        <div class="form-control" style="opacity:0.55;cursor:not-allowed;pointer-events:none">
                            Super Admin <span style="font-size:0.75rem;color:var(--crm-text-muted)">(cannot be changed)</span>
                        </div>
                        <input type="hidden" name="role" value="super-admin">
                    @else
                        <select id="role" name="role"
                            class="form-control @error('role') is-invalid @enderror">
                            <option value="">— Select Role —</option>
                            @foreach($roles as $role)
                                @if($role->name !== 'super-admin')
                                    <option value="{{ $role->name }}"
                                        {{ old('role', $user->roles->first()?->name) === $role->name ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('role')<p class="form-error">{{ $message }}</p>@enderror
                    @endif
                </div>

            </div>

            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;padding-top:0.75rem;border-top:1px solid var(--crm-border);margin-top:0.25rem">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i> Save Changes
                </button>
            </div>

        </form>
    </div>

</x-layouts.backend>
