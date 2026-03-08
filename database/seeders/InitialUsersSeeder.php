<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => env('INITIAL_SUPERADMIN_EMAIL', 'ika-superadmin@production.dev')],
            [
                'name' => env('INITIAL_SUPERADMIN_NAME', 'Super Admin'),
                'password' => Hash::make(env('INITIAL_SUPERADMIN_PASSWORD', 'ikasma6-superadminpw')),
                'role' => UserRole::SuperAdmin,
                'is_active' => true,
            ]
        );

        // Admin
        User::updateOrCreate(
            ['email' => env('INITIAL_ADMIN_EMAIL', 'hamzah.ancha@gmail.com')],
            [
                'name' => env('INITIAL_ADMIN_NAME', 'Admin Hamzah IKA SMA 6'),
                'password' => Hash::make(env('INITIAL_ADMIN_PASSWORD', 'admin1-password')),
                'role' => UserRole::Admin,
                'is_active' => true,
            ]
        );
    }
}