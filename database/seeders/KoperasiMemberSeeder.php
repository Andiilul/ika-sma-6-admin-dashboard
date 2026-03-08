<?php

namespace Database\Seeders;

use App\Models\KoperasiMember;
use App\Models\User;
use Illuminate\Database\Seeder;

class KoperasiMemberSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::query()->value('id'); // ambil 1 user pertama kalau ada

        $items = [
            [
                'name' => 'Ahmad Ramadhan',
                'email' => 'ahmad.ramadhan@example.com',
                'phone' => '081234560001',
            ],
            [
                'name' => 'Nurul Hidayah',
                'email' => 'nurul.hidayah@example.com',
                'phone' => '081234560002',
            ],
            [
                'name' => 'Muhammad Ilham',
                'email' => 'muhammad.ilham@example.com',
                'phone' => '081234560003',
            ],
            [
                'name' => 'Siti Aulia',
                'email' => 'siti.aulia@example.com',
                'phone' => '081234560004',
            ],
            [
                'name' => 'Fajar Pratama',
                'email' => 'fajar.pratama@example.com',
                'phone' => '081234560005',
            ],
            [
                'name' => 'Dewi Sartika',
                'email' => 'dewi.sartika@example.com',
                'phone' => '081234560006',
            ],
            [
                'name' => 'Andi Saputra',
                'email' => 'andi.saputra@example.com',
                'phone' => '081234560007',
            ],
            [
                'name' => 'Nabila Syafitri',
                'email' => 'nabila.syafitri@example.com',
                'phone' => '081234560008',
            ],
            [
                'name' => 'Rizky Maulana',
                'email' => 'rizky.maulana@example.com',
                'phone' => '081234560009',
            ],
            [
                'name' => 'Aisyah Putri',
                'email' => 'aisyah.putri@example.com',
                'phone' => '081234560010',
            ],
        ];

        foreach ($items as $item) {
            KoperasiMember::updateOrCreate(
                [
                    'email' => $item['email'],
                ],
                [
                    'name' => $item['name'],
                    'phone' => $item['phone'],
                    'image_path' => null,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]
            );
        }
    }
}