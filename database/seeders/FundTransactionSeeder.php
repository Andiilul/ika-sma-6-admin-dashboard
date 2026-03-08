<?php

namespace Database\Seeders;

use App\Models\FundTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class FundTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::query()->value('id'); // ambil 1 user pertama kalau ada

        $items = [
            [
                'name' => 'Iuran Anggota Januari',
                'description' => 'Penerimaan iuran anggota koperasi untuk periode Januari 2026.',
                'amount' => 2500000.00,
                'type' => 'income',
                'transaction_date' => '2026-01-05',
                'category' => 'Iuran Anggota',
                'source' => 'member_dues',
                'payment_method' => 'transfer',
            ],
            [
                'name' => 'Penjualan Produk Koperasi',
                'description' => 'Pendapatan dari hasil penjualan produk koperasi minggu pertama Januari.',
                'amount' => 1750000.00,
                'type' => 'income',
                'transaction_date' => '2026-01-08',
                'category' => 'Penjualan',
                'source' => 'koperasi_business',
                'payment_method' => 'cash',
            ],
            [
                'name' => 'Pembelian ATK',
                'description' => 'Pengeluaran untuk pembelian alat tulis kantor dan kebutuhan administrasi.',
                'amount' => 350000.00,
                'type' => 'expense',
                'transaction_date' => '2026-01-10',
                'category' => 'Operasional',
                'source' => 'other',
                'payment_method' => 'cash',
            ],
            [
                'name' => 'Donasi Alumni untuk Koperasi',
                'description' => 'Penerimaan donasi dari alumni untuk mendukung pengembangan koperasi.',
                'amount' => 5000000.00,
                'type' => 'income',
                'transaction_date' => '2026-01-14',
                'category' => 'Donasi',
                'source' => 'donation',
                'payment_method' => 'transfer',
            ],
            [
                'name' => 'Pembayaran Listrik Kantor',
                'description' => 'Pembayaran tagihan listrik kantor koperasi.',
                'amount' => 420000.00,
                'type' => 'expense',
                'transaction_date' => '2026-01-16',
                'category' => 'Utilitas',
                'source' => 'other',
                'payment_method' => 'transfer',
            ],
            [
                'name' => 'Bantuan Eksternal Program Usaha',
                'description' => 'Bantuan dana dari pihak eksternal untuk penguatan program usaha koperasi.',
                'amount' => 3000000.00,
                'type' => 'income',
                'transaction_date' => '2026-01-20',
                'category' => 'Bantuan',
                'source' => 'external_support',
                'payment_method' => 'transfer',
            ],
            [
                'name' => 'Perawatan Peralatan',
                'description' => 'Biaya perawatan peralatan penunjang operasional koperasi.',
                'amount' => 650000.00,
                'type' => 'expense',
                'transaction_date' => '2026-01-22',
                'category' => 'Perawatan',
                'source' => 'other',
                'payment_method' => 'cash',
            ],
            [
                'name' => 'Pendapatan QRIS Koperasi',
                'description' => 'Pendapatan hasil transaksi penjualan yang dibayar menggunakan QRIS.',
                'amount' => 980000.00,
                'type' => 'income',
                'transaction_date' => '2026-01-25',
                'category' => 'Penjualan Digital',
                'source' => 'koperasi_business',
                'payment_method' => 'qris',
            ],
            [
                'name' => 'Honor Narasumber Pelatihan',
                'description' => 'Pembayaran honor untuk narasumber kegiatan pelatihan koperasi.',
                'amount' => 750000.00,
                'type' => 'expense',
                'transaction_date' => '2026-01-27',
                'category' => 'Kegiatan',
                'source' => 'other',
                'payment_method' => 'transfer',
            ],
            [
                'name' => 'Iuran Anggota Februari Awal',
                'description' => 'Penerimaan iuran anggota koperasi pada awal Februari 2026.',
                'amount' => 2600000.00,
                'type' => 'income',
                'transaction_date' => '2026-02-02',
                'category' => 'Iuran Anggota',
                'source' => 'member_dues',
                'payment_method' => 'ewallet',
            ],
        ];

        foreach ($items as $item) {
            FundTransaction::updateOrCreate(
                [
                    'name' => $item['name'],
                    'type' => $item['type'],
                    'transaction_date' => $item['transaction_date'],
                ],
                [
                    'description' => $item['description'],
                    'amount' => $item['amount'],
                    'category' => $item['category'],
                    'source' => $item['source'],
                    'payment_method' => $item['payment_method'],
                    'proof_image_path' => null,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]
            );
        }
    }
}