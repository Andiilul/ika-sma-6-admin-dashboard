<?php

namespace App\Filament\Resources\KoperasiMitras;

use App\Filament\Resources\KoperasiMitras\Pages\CreateKoperasiMitra;
use App\Filament\Resources\KoperasiMitras\Pages\EditKoperasiMitra;
use App\Filament\Resources\KoperasiMitras\Pages\ListKoperasiMitras;
use App\Filament\Resources\KoperasiMitras\Schemas\KoperasiMitraForm;
use App\Filament\Resources\KoperasiMitras\Tables\KoperasiMitrasTable;
use App\Models\KoperasiMitra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KoperasiMitraResource extends Resource
{
    protected static ?string $model = KoperasiMitra::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLink;

    // Must match parent type: UnitEnum|string|null
    protected static string|UnitEnum|null $navigationGroup = 'Koperasi';

    // Sidebar label
    protected static ?string $navigationLabel = 'Mitra';

    // Record title attribute must be a COLUMN name
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return KoperasiMitraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KoperasiMitrasTable::configure($table);
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
            'index'  => ListKoperasiMitras::route('/'),
            'create' => CreateKoperasiMitra::route('/create'),
            'edit'   => EditKoperasiMitra::route('/{record}/edit'),
        ];
    }
}