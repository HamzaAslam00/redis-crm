<x-layouts.backend title="Roles & Permissions">

    {{-- Page header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:2rem;flex-wrap:wrap">
        <div>
            <h1 class="page-title">Roles & Permissions</h1>
            <p class="page-subtitle">Define what each role can access within the CRM.</p>
        </div>
        @can('role.create')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                <i class="ri-shield-user-line"></i> Create Role
            </a>
        @endcan
    </div>

    <div>

        @if(session('success'))
            <div style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.3);border-radius:10px;padding:0.875rem 1.25rem;margin-bottom:1.5rem;color:#34D399;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem">
                <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:10px;padding:0.875rem 1.25rem;margin-bottom:1.5rem;color:#EF4444;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem">
                <i class="ri-error-warning-line"></i> {{ session('error') }}
            </div>
        @endif

        <div class="crm-card" style="padding:0;overflow:hidden">
            <div style="overflow-x:auto;-webkit-overflow-scrolling:touch">
            <table class="crm-table" style="min-width:520px">
                <thead>
                    <tr>
                        <th>Role Name</th>
                        <th>Users</th>
                        <th>Permission Count</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        @php
                            $badge = match($role->name) {
                                'super-admin' => ['bg' => 'rgba(255,100,0,0.15)', 'color' => '#FF6400'],
                                'admin'       => ['bg' => 'rgba(139,92,246,0.15)', 'color' => '#8B5CF6'],
                                'manager'     => ['bg' => 'rgba(16,185,129,0.15)', 'color' => '#10B981'],
                                default       => ['bg' => 'rgba(148,163,184,0.15)', 'color' => '#94A3B8'],
                            };
                        @endphp
                        <tr>
                            <td>
                                <span style="display:inline-flex;align-items:center;padding:0.25rem 0.75rem;border-radius:50px;font-size:0.8rem;font-weight:600;background:{{ $badge['bg'] }};color:{{ $badge['color'] }}">
                                    {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                </span>
                            </td>
                            <td style="font-size:0.875rem;color:var(--crm-text)">
                                {{ $role->users_count }}
                                <span style="color:var(--crm-text-muted);font-size:0.8rem">{{ Str::plural('user', $role->users_count) }}</span>
                            </td>
                            <td style="font-size:0.875rem;color:var(--crm-text-muted)">
                                @if($role->name === 'super-admin')
                                    <span style="color:#FF6400;font-weight:600">All permissions</span>
                                @else
                                    {{ $role->permissions->count() }} permissions
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5rem">
                                    @can('role.edit')
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-secondary btn-sm">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                    @endcan
                                    @can('role.delete')
                                        @if(!in_array($role->name, ['super-admin', 'admin']))
                                            @php $roleLabel = ucwords(str_replace('-', ' ', $role->name)); @endphp
                                            <form id="delete-role-{{ $role->id }}" method="POST" action="{{ route('admin.roles.destroy', $role) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="deleteForm(this)"
                                                    data-form="delete-role-{{ $role->id }}"
                                                    data-label="{{ $roleLabel }}">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:3rem 1rem;color:var(--crm-text-muted)">
                                No roles found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>{{-- /overflow-x:auto --}}
        </div>

    </div>

</x-layouts.backend>
