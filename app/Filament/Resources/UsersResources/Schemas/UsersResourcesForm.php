<?php

namespace App\Filament\Resources\UsersResources\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UsersResourcesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // CREATE ONLY
            TextInput::make('name')
                ->required()
                ->visible(fn (string $operation) => $operation === 'create'),

            TextInput::make('email')
                ->email()
                ->required()
                ->visible(fn (string $operation) => $operation === 'create'),

            // CREATE & EDIT (tapi saat edit opsional, hanya update kalau diisi)
            TextInput::make('password')
                ->label('Password')
                ->password()
                ->revealable()
                ->autocomplete('new-password')
                ->required(fn (string $operation) => $operation === 'create')
                // penting: kalau kosong saat edit, jangan overwrite password lama
                ->dehydrated(fn ($state) => filled($state))
                ->confirmed(),

            TextInput::make('password_confirmation')
                ->label('Konfirmasi Password')
                ->password()
                ->revealable()
                ->autocomplete('new-password')
                ->dehydrated(false)
                // create wajib, edit wajib hanya kalau password diisi
                ->required(fn (string $operation, $get) =>
                    $operation === 'create' || filled($get('password'))
                ),
        ]);
    }
}
