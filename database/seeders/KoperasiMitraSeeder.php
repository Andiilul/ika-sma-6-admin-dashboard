<?php

namespace Database\Seeders;

use App\Models\KoperasiMitra;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KoperasiMitraSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::query()->value('id'); // ambil 1 user pertama kalau ada

        $items = [
            [
                'name' => 'Mitra Koperasi Sejahtera',
                'description' => 'Mitra yang bergerak di bidang penguatan usaha mikro dan pengembangan komunitas koperasi.',
                'website_url' => 'https://sejahtera.example.com',
            ],
            [
                'name' => 'Nusantara Finance Support',
                'description' => 'Mitra pendukung layanan pembiayaan dan konsultasi keuangan bagi anggota koperasi.',
                'website_url' => 'https://nusantarafinance.example.com',
            ],
            [
                'name' => 'Makassar Digital Solution',
                'description' => 'Mitra teknologi yang membantu transformasi digital dan pengelolaan sistem informasi koperasi.',
                'website_url' => 'https://makassardigital.example.com',
            ],
            [
                'name' => 'Berkah Usaha Mandiri',
                'description' => 'Mitra usaha yang berfokus pada distribusi kebutuhan pokok dan kerja sama dagang lokal.',
                'website_url' => 'https://berkahusaha.example.com',
            ],
            [
                'name' => 'Sulawesi Logistic Partner',
                'description' => 'Mitra logistik untuk mendukung distribusi produk koperasi ke berbagai wilayah.',
                'website_url' => 'https://sulawesilogistic.example.com',
            ],
            [
                'name' => 'Inspirasi Retail Network',
                'description' => 'Mitra jaringan retail yang mendukung pemasaran produk anggota koperasi.',
                'website_url' => 'https://inspirasiretail.example.com',
            ],
            [
                'name' => 'Sentra Pangan Bersama',
                'description' => 'Mitra di bidang pangan yang memperkuat rantai pasok dan distribusi hasil usaha anggota.',
                'website_url' => 'https://sentrapangan.example.com',
            ],
            [
                'name' => 'Karya Inovasi Indonesia',
                'description' => 'Mitra pengembangan inovasi produk, branding, dan strategi pemasaran koperasi.',
                'website_url' => 'https://karyainovasi.example.com',
            ],
            [
                'name' => 'Mandiri Niaga Konsultan',
                'description' => 'Mitra konsultasi bisnis dan legalitas usaha untuk penguatan kelembagaan koperasi.',
                'website_url' => 'https://mandiriniaga.example.com',
            ],
            [
                'name' => 'Global Mitra Distribusi',
                'description' => 'Mitra distribusi dan kemitraan dagang untuk memperluas jangkauan pasar koperasi.',
                'website_url' => 'https://globalmitra.example.com',
            ],
        ];

        foreach ($items as $item) {
            $slug = Str::slug($item['name']);

            KoperasiMitra::updateOrCreate(
                [
                    'slug' => $slug,
                ],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'logo_path' => null,
                    'website_url' => $item['website_url'],
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]
            );
        }
    }
}