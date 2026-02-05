<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class InitialUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@local.test'],
            [
                'name' => 'Super Admin',
                'password' => 'password123', // auto-hash kalau model User cast password => 'hashed'
                'role' => UserRole::SuperAdmin,
                'is_active' => true,
            ]
        );

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@local.test'],
            [
                'name' => 'Admin',
                'password' => 'password123',
                'role' => UserRole::Admin,
                'is_active' => true,
            ]
        );
    }
}
