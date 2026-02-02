<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'super-admin']);
        Role::firstOrCreate(['name' => 'admin']);

        // Set user id=1 jadi super-admin (atau ganti sesuai email kamu)
        $user = User::find(1);
        if ($user) {
            $user->syncRoles(['super-admin']);
        }
    }
}
