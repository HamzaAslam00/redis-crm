<x-layouts.backend title="Create Role">

    <div style="max-width:900px;width:100%">

        {{-- Page header --}}
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary btn-sm">
                <i class="ri-arrow-left-line"></i>
            </a>
            <div>
                <h1 class="page-title">Create Role</h1>
                <p class="page-subtitle">Define a role slug and select the permissions it grants.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf

            {{-- Role name --}}
            <div class="crm-card" style="margin-bottom:1.25rem">
                <h2 style="font-size:0.95rem;font-weight:700;color:var(--crm-text);margin-bottom:1rem">Role Name</h2>
                <div class="form-group" style="margin-bottom:0;max-width:360px">
                    <label class="form-label" for="name">Slug <span style="color:var(--crm-text-muted);font-weight:400;font-size:0.78rem">(lowercase letters, numbers, hyphens only)</span></label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="e.g. content-manager"
                        autofocus
                    >
                    @error('name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Permission matrix --}}
            @foreach($groups as $groupName => $subGroups)
                <div class="crm-card" style="margin-bottom:1.25rem">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
                        <h2 style="font-size:0.95rem;font-weight:700;color:var(--crm-text)">{{ $groupName }}</h2>
                        <button type="button"
                            onclick="toggleGroup(this, '{{ Str::slug($groupName) }}')"
                            style="font-size:0.75rem;color:#FF6400;background:none;border:none;cursor:pointer;font-weight:600">
                            Select All
                        </button>
                    </div>

                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:0.75rem">
                        @foreach($subGroups as $subName => $perms)
                            <div style="background:var(--crm-input);border:1px solid var(--crm-border);border-radius:10px;padding:0.875rem">
                                <div style="font-size:0.78rem;font-weight:700;color:var(--crm-text);text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.625rem">
                                    {{ $subName }}
                                </div>
                                @foreach($perms as $perm)
                                    @php
                                        $label = ucfirst(explode('.', $perm)[1] ?? $perm);
                                        $icon = match($label) {
                                            'View'   => 'ri-eye-line',
                                            'Create' => 'ri-add-circle-line',
                                            'Edit'   => 'ri-pencil-line',
                                            'Delete' => 'ri-delete-bin-line',
                                            'Reveal' => 'ri-lock-unlock-line',
                                            'Reply'  => 'ri-reply-line',
                                            'Send'   => 'ri-send-plane-line',
                                            default  => 'ri-checkbox-circle-line',
                                        };
                                    @endphp
                                    <label style="display:flex;align-items:center;gap:0.5rem;padding:0.3rem 0;cursor:pointer;font-size:0.825rem;color:var(--crm-text-muted)">
                                        <input
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $perm }}"
                                            data-group="{{ Str::slug($groupName) }}"
                                            {{ in_array($perm, old('permissions', $rolePermissions)) ? 'checked' : '' }}
                                            class="perm-checkbox"
                                            style="width:15px;height:15px;accent-color:#FF6400;flex-shrink:0"
                                        >
                                        <i class="{{ $icon }}" style="font-size:0.9rem;width:16px;text-align:center"></i>
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Actions --}}
            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;margin-top:0.5rem">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-shield-check-line"></i> Create Role
                </button>
            </div>

        </form>

    </div>

    @push('scripts')
    <script>
        function toggleGroup(btn, group) {
            const boxes = document.querySelectorAll(`[data-group="${group}"]`);
            const allChecked = [...boxes].every(b => b.checked);
            boxes.forEach(b => b.checked = !allChecked);
            btn.textContent = allChecked ? 'Select All' : 'Deselect All';
        }
    </script>
    @endpush

</x-layouts.backend>
