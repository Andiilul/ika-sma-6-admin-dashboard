<?php

namespace App\Filament\Resources\KoperasiMembers;

use App\Filament\Resources\KoperasiMembers\Pages\CreateKoperasiMember;
use App\Filament\Resources\KoperasiMembers\Pages\EditKoperasiMember;
use App\Filament\Resources\KoperasiMembers\Pages\ListKoperasiMembers;
use App\Filament\Resources\KoperasiMembers\Schemas\KoperasiMemberForm;
use App\Filament\Resources\KoperasiMembers\Tables\KoperasiMembersTable;
use App\Models\KoperasiMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KoperasiMemberResource extends Resource
{
    protected static ?string $model = KoperasiMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    // Must match parent type: UnitEnum|string|null
    protected static string|UnitEnum|null $navigationGroup = 'Koperasi';

    // Sidebar label
    protected static ?string $navigationLabel = 'Member Koperasi';

    // Title for record (uses column name, not a literal label)
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return KoperasiMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KoperasiMembersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListKoperasiMembers::route('/'),
            'create' => CreateKoperasiMember::route('/create'),
            'edit'   => EditKoperasiMember::route('/{record}/edit'),
        ];
    }
}