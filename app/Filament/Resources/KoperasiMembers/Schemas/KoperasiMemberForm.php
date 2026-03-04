<?php

namespace App\Filament\Resources\KoperasiMembers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KoperasiMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->nullable(),

            TextInput::make('phone')
                ->label('Nomor Telepon')
                ->tel()
                ->maxLength(32)
                ->nullable(),

            FileUpload::make('image_path')
                ->label('Foto')
                ->disk('public')
                ->directory('koperasi/members/photos')
                ->image()
                ->imagePreviewHeight('160')
                ->openable()
                ->downloadable()
                ->nullable(),
        ]);
    }
}