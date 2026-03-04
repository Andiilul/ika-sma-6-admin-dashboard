<?php

namespace App\Filament\Resources\KoperasiMitras\Pages;

use App\Filament\Resources\KoperasiMitras\KoperasiMitraResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKoperasiMitra extends CreateRecord
{
    protected static string $resource = KoperasiMitraResource::class;
        protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
