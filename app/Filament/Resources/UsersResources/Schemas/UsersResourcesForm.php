<?php

namespace App\Filament\Resources\UsersResources\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersResourcesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->password()
                ->revealable()
                ->required(fn (string $context) => $context === 'create')
                ->dehydrated(fn ($state) => filled($state))
                ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null),

            // Role hanya untuk state, tidak disimpan ke users.role
            Select::make('spatie_role')
                ->label('Role')
                ->options(fn () => Role::where('guard_name', 'web')->pluck('name', 'name')->toArray())
                ->required()
                ->searchable()
                ->preload()
                ->dehydrated(false)
                ->default(fn (?User $record) => $record?->getRoleNames()->first()),
        ]);
    }
}
