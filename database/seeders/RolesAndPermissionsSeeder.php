<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Projects
            'project.view', 'project.create', 'project.edit', 'project.delete',
            // Budget
            'budget.view', 'budget.create', 'budget.edit', 'budget.delete',
            // Investments
            'investment.view', 'investment.create', 'investment.edit', 'investment.delete',
            // Hosting
            'hosting.view', 'hosting.create', 'hosting.edit', 'hosting.delete',
            // Vault
            'apikey.view', 'apikey.create', 'apikey.edit', 'apikey.delete', 'apikey.reveal',
            'credential.view', 'credential.create', 'credential.edit', 'credential.delete', 'credential.reveal',
            // Notes
            'note.view', 'note.create', 'note.edit', 'note.delete',
            // Vault extras
            'demo.view', 'demo.create', 'demo.edit', 'demo.delete',
            'crypto.view', 'crypto.create', 'crypto.edit', 'crypto.delete',
            // Contact / Proposals
            'contact.view', 'contact.reply', 'contact.delete',
            'proposal.view', 'proposal.create', 'proposal.edit', 'proposal.delete', 'proposal.send',
            // Website content
            'portfolio.view', 'portfolio.create', 'portfolio.edit', 'portfolio.delete',
            'testimonial.view', 'testimonial.create', 'testimonial.edit', 'testimonial.delete',
            'faq.view', 'faq.create', 'faq.edit', 'faq.delete',
            'blog.view', 'blog.create', 'blog.edit', 'blog.delete',
            'case_study.view', 'case_study.create', 'case_study.edit', 'case_study.delete',
            // Admin
            'user.view', 'user.create', 'user.edit', 'user.delete',
            'role.view', 'role.create', 'role.edit', 'role.delete',
            'setting.view', 'setting.edit',
            'log.view',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $contentManager = Role::firstOrCreate(['name' => 'content-manager', 'guard_name' => 'web']);

        // Admin gets all except vault reveal and user/role management
        $adminPermissions = Permission::whereNotIn('name', [
            'apikey.reveal', 'credential.reveal', 'user.create', 'user.delete', 'role.create', 'role.edit', 'role.delete',
        ])->pluck('name');
        $admin->syncPermissions($adminPermissions);

        // Manager gets CRM only (no admin, no settings)
        $managerPermissions = Permission::where('name', 'LIKE', 'project.%')
            ->orWhere('name', 'LIKE', 'budget.%')
            ->orWhere('name', 'LIKE', 'investment.%')
            ->orWhere('name', 'LIKE', 'hosting.%')
            ->orWhere('name', 'LIKE', 'contact.%')
            ->orWhere('name', 'LIKE', 'proposal.%')
            ->pluck('name');
        $manager->syncPermissions($managerPermissions);

        // Content manager gets website content only
        $contentPermissions = Permission::where('name', 'LIKE', 'blog.%')
            ->orWhere('name', 'LIKE', 'portfolio.%')
            ->orWhere('name', 'LIKE', 'testimonial.%')
            ->orWhere('name', 'LIKE', 'faq.%')
            ->orWhere('name', 'LIKE', 'case_study.%')
            ->pluck('name');
        $contentManager->syncPermissions($contentPermissions);
    }
}
