<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@redissolution.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin@123'),
                'email_verified_at' => now(),
            ]
        );

        $role = Role::where('name', 'super-admin')->first();
        if ($role) {
            $user->assignRole($role);
        }
    }
}
