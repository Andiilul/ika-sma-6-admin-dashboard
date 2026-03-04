<?php

namespace App\Filament\Resources\KoperasiMitras\Pages;

use App\Filament\Resources\KoperasiMitras\KoperasiMitraResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKoperasiMitra extends EditRecord
{
    protected static string $resource = KoperasiMitraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
