<?php

namespace App\Filament\Resources\KoperasiMitras\Pages;

use App\Filament\Resources\KoperasiMitras\KoperasiMitraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKoperasiMitras extends ListRecords
{
    protected static string $resource = KoperasiMitraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
