<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password as PasswordRule;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                // UI: disable saat edit
                ->disabled(fn(string $operation): bool => $operation === 'edit')
                // Fungsi: jangan ikut disave saat edit
                ->dehydrated(fn(string $operation): bool => $operation !== 'edit'),

            // Force semua user yang dibuat via UI = Admin (role=2)
            Hidden::make('role')
                ->default(UserRole::Admin),

            // Password: required saat create, optional saat edit
            TextInput::make('password')
                ->label('Password')
                ->password()
                ->revealable()
                ->rule(PasswordRule::default())
                ->required(fn(string $operation): bool => $operation === 'create')
                ->dehydrated(fn($state) => filled($state)),

            // Confirm password (tidak disimpan ke DB)
            TextInput::make('password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->revealable()
                ->required(fn(string $operation): bool => $operation === 'create')
                ->dehydrated(false)
                ->same('password'),
        ]);
    }
}
