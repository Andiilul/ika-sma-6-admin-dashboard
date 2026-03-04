<?php

namespace App\Filament\Resources\FundTransactions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FundTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),

            Textarea::make('description')
                ->label('Deskripsi')
                ->rows(4)
                ->nullable(),

            Select::make('type')
                ->label('Tipe')
                ->options([
                    'income'  => 'Income (Masuk)',
                    'expense' => 'Expense (Keluar)',
                ])
                ->default('income')
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    // Kalau expense, paksa source & payment_method jadi "other"
                    if ($state === 'expense') {
                        $set('source', 'other');
                        $set('payment_method', 'other');
                    }
                }),

            TextInput::make('amount')
                ->label('Jumlah')
                ->numeric()
                ->step('0.01')
                ->minValue(0.01) // cegah negatif
                ->required(),

            DatePicker::make('transaction_date')
                ->label('Tanggal Transaksi')
                ->required()
                ->native(false),

            TextInput::make('category')
                ->label('Kategori')
                ->maxLength(120)
                ->nullable(),

            Select::make('source')
                ->label('Sumber')
                ->options([
                    'koperasi_business' => 'Hasil Usaha Koperasi',
                    'member_dues'       => 'Iuran Anggota',
                    'donation'          => 'Donasi',
                    'external_support'  => 'Bantuan Eksternal',
                    'other'             => 'Lainnya',
                ])
                ->default('other')
                ->required()
                ->reactive()
                ->disabled(fn (callable $get) => $get('type') === 'expense')
                ->dehydrated(true),

            Select::make('payment_method')
                ->label('Metode Pembayaran')
                ->options([
                    'cash'     => 'Cash',
                    'transfer' => 'Transfer Bank',
                    'qris'     => 'QRIS',
                    'ewallet'  => 'E-Wallet',
                    'other'    => 'Lainnya',
                ])
                ->default('other')
                ->required()
                ->reactive()
                ->disabled(fn (callable $get) => $get('type') === 'expense')
                ->dehydrated(true),

            FileUpload::make('proof_image_path')
                ->label('Bukti (Gambar)')
                ->disk('public')
                ->directory('koperasi/fund-transactions/proofs')
                ->image()
                ->imagePreviewHeight('160')
                ->openable()
                ->downloadable()
                ->nullable(),
        ]);
    }
}