<?php

namespace App\Filament\Resources\FundTransactions\Pages;

use App\Filament\Resources\FundTransactions\FundTransactionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFundTransaction extends EditRecord
{
    protected static string $resource = FundTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
