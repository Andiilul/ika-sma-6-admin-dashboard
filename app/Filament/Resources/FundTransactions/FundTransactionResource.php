<?php

namespace App\Filament\Resources\FundTransactions;

use App\Filament\Resources\FundTransactions\Pages\CreateFundTransaction;
use App\Filament\Resources\FundTransactions\Pages\EditFundTransaction;
use App\Filament\Resources\FundTransactions\Pages\ListFundTransactions;
use App\Filament\Resources\FundTransactions\Schemas\FundTransactionForm;
use App\Filament\Resources\FundTransactions\Tables\FundTransactionsTable;
use App\Models\FundTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FundTransactionResource extends Resource
{
    protected static ?string $model = FundTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    // Must match parent type: UnitEnum|string|null
    protected static string|UnitEnum|null $navigationGroup = 'Koperasi';

    protected static ?string $navigationLabel = 'Dana / Laporan Keuangan';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return FundTransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FundTransactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListFundTransactions::route('/'),
            'create' => CreateFundTransaction::route('/create'),
            'edit'   => EditFundTransaction::route('/{record}/edit'),
        ];
    }
}