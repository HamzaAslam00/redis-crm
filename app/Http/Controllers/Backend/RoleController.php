<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    /** @var array<string, array<string, string[]>> */
    public static array $permissionGroups = [
        'CRM' => [
            'Projects' => ['project.view', 'project.create', 'project.edit', 'project.delete'],
            'Budget' => ['budget.view', 'budget.create', 'budget.edit', 'budget.delete'],
            'Investments' => ['investment.view', 'investment.create', 'investment.edit', 'investment.delete'],
            'Hosting' => ['hosting.view', 'hosting.create', 'hosting.edit', 'hosting.delete'],
        ],
        'Vault' => [
            'API Keys' => ['apikey.view', 'apikey.create', 'apikey.edit', 'apikey.delete', 'apikey.reveal'],
            'Credentials' => ['credential.view', 'credential.create', 'credential.edit', 'credential.delete', 'credential.reveal'],
            'Demo Projects' => ['demo.view', 'demo.create', 'demo.edit', 'demo.delete'],
            'Crypto' => ['crypto.view', 'crypto.create', 'crypto.edit', 'crypto.delete'],
            'Notes' => ['note.view', 'note.create', 'note.edit', 'note.delete'],
        ],
        'Comms' => [
            'Contacts' => ['contact.view', 'contact.reply', 'contact.delete'],
            'Proposals' => ['proposal.view', 'proposal.create', 'proposal.edit', 'proposal.delete', 'proposal.send'],
        ],
        'Website' => [
            'Portfolio' => ['portfolio.view', 'portfolio.create', 'portfolio.edit', 'portfolio.delete'],
            'Testimonials' => ['testimonial.view', 'testimonial.create', 'testimonial.edit', 'testimonial.delete'],
            'FAQs' => ['faq.view', 'faq.create', 'faq.edit', 'faq.delete'],
            'Blog' => ['blog.view', 'blog.create', 'blog.edit', 'blog.delete'],
            'Case Studies' => ['case_study.view', 'case_study.create', 'case_study.edit', 'case_study.delete'],
        ],
        'Admin' => [
            'Users' => ['user.view', 'user.create', 'user.edit', 'user.delete'],
            'Roles' => ['role.view', 'role.create', 'role.edit', 'role.delete'],
            'Settings' => ['setting.view', 'setting.edit'],
            'Logs' => ['log.view'],
        ],
    ];

    public function index(): View
    {
        $roles = Role::withCount('users')->where('name', '!=', 'super-admin')->orderBy('id')->get();

        return view('backend.roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('backend.roles.create', [
            'groups' => self::$permissionGroups,
            'rolePermissions' => [],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name', 'regex:/^[a-z0-9\-]+$/', 'not_in:super-admin,admin'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', "Role \"{$role->name}\" created successfully.");
    }

    public function edit(Role $role): View
    {
        return view('backend.roles.edit', [
            'role' => $role,
            'groups' => self::$permissionGroups,
            'rolePermissions' => $role->permissions->pluck('name')->toArray(),
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        if ($role->name === 'super-admin') {
            return back()->with('error', 'The super-admin role cannot be modified.');
        }

        $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role->syncPermissions($request->permissions ?? []);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('admin.roles.index')
            ->with('success', "Role \"{$role->name}\" permissions updated.");
    }

    public function destroy(Role $role): RedirectResponse
    {
        if (in_array($role->name, ['super-admin', 'admin'])) {
            return back()->with('error', "The \"{$role->name}\" role cannot be deleted.");
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', "Cannot delete role \"{$role->name}\" — it has assigned users.");
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', "Role \"{$role->name}\" deleted.");
    }
}
