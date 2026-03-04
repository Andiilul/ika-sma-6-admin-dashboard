<?php

namespace App\Filament\Resources\KoperasiMitras\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class KoperasiMitraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama Mitra')
                ->required()
                ->maxLength(255)
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    // Auto-generate slug hanya kalau slug masih kosong (atau user belum edit)
                    $currentSlug = $get('slug');
                    if (blank($currentSlug) && filled($state)) {
                        $set('slug', Str::slug($state));
                    }
                }),

            TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->helperText('Otomatis dari nama, tapi bisa kamu ubah. Harus unik.'),

            Textarea::make('description')
                ->label('Deskripsi')
                ->rows(5)
                ->nullable(),

            TextInput::make('website_url')
                ->label('Website URL')
                ->url()
                ->maxLength(2048)
                ->nullable()
                ->helperText('Contoh: https://contoh.com'),

            FileUpload::make('logo_path')
                ->label('Logo')
                ->disk('public')
                ->directory('koperasi/mitra/logos')
                ->image()
                ->imagePreviewHeight('160')
                ->openable()
                ->downloadable()
                ->nullable(),
        ]);
    }
}