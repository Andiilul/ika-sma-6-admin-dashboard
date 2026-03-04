<?php

namespace App\Filament\Resources\FundTransactions\Pages;

use App\Filament\Resources\FundTransactions\FundTransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFundTransaction extends CreateRecord
{
    protected static string $resource = FundTransactionResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
