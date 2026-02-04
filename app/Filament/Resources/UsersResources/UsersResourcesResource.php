<?php

namespace App\Filament\Resources\UsersResources;

use App\Filament\Resources\UsersResources\Pages\CreateUsersResources;
use App\Filament\Resources\UsersResources\Pages\EditUsersResources;
use App\Filament\Resources\UsersResources\Pages\ListUsersResources;
use App\Filament\Resources\UsersResources\Schemas\UsersResourcesForm;
use App\Filament\Resources\UsersResources\Tables\UsersResourcesTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UsersResourcesResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    // harus nama kolom di tabel users
    protected static ?string $recordTitleAttribute = 'name';

    /**
     * (Recommended) Biar akses $user->role tidak N+1.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('roles');
    }

    /**
     * AuthZ: hanya super-admin boleh lihat resource ini.
     */


    /**
     * Form & table config
     */
    public static function form(Schema $schema): Schema
    {
        return UsersResourcesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersResourcesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsersResources::route('/'),
            'create' => CreateUsersResources::route('/create'),
            'edit' => EditUsersResources::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->hasRole('super-admin') ?? false;
    }


    /**
     * Hide navigation untuk yang tidak berhak.
     */
    public static function shouldRegisterNavigation(): bool
    {
        return static::canViewAny();
    }


    public static function canCreate(): bool
    {
        return static::canViewAny();
    }

    public static function canEdit(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function canDelete(Model $record): bool
    {
        return static::canViewAny() && !$record->hasRole('super-admin');
    }

    public static function canDeleteAny(): bool
    {
        return static::canViewAny();
    }

}
