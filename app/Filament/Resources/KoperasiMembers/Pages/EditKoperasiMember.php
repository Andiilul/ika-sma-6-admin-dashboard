<?php

namespace App\Filament\Resources\KoperasiMembers\Pages;

use App\Filament\Resources\KoperasiMembers\KoperasiMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKoperasiMember extends EditRecord
{
    protected static string $resource = KoperasiMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
