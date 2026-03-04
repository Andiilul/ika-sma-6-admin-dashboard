<?php

namespace App\Filament\Resources\KoperasiMembers\Pages;

use App\Filament\Resources\KoperasiMembers\KoperasiMemberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKoperasiMember extends CreateRecord
{
    protected static string $resource = KoperasiMemberResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
