<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            InitialUsersSeeder::class,
            ActivitySeeder::class,
            NewsSeeder::class,
            AlumniSeeder::class,
            KoperasiMemberSeeder::class,
            KoperasiMitraSeeder::class,
            FundTransactionSeeder::class,
        ]);
    }
}
