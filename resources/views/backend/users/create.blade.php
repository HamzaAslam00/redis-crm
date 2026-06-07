<x-layouts.backend title="Add User">

    {{-- Page header --}}
    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm" title="Back">
            <i class="ri-arrow-left-line"></i>
        </a>
        <div>
            <h1 class="page-title">Add User</h1>
            <p class="page-subtitle">Create a new team member account.</p>
        </div>
    </div>

    <div class="crm-card">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="form-grid-2">

                {{-- Name --}}
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="John Doe" autofocus>
                    @error('name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="john@example.com">
                    @error('email')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Min 8 chars, mixed case + number"
                        autocomplete="new-password">
                    @error('password')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control" placeholder="Repeat password"
                        autocomplete="new-password">
                </div>

                {{-- Role --}}
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label" for="role">Role</label>
                    <select id="role" name="role"
                        class="form-control @error('role') is-invalid @enderror">
                        <option value="">— Select Role —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                {{ ucwords(str_replace('-', ' ', $role->name)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')<p class="form-error">{{ $message }}</p>@enderror
                </div>

            </div>

            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;padding-top:0.5rem;border-top:1px solid var(--crm-border);margin-top:0.5rem">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-user-add-line"></i> Create User
                </button>
            </div>

        </form>
    </div>

</x-layouts.backend>
