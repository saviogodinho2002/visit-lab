<?php

namespace App\Filament\Resources\AuditResource\Pages;

use App\Filament\Resources\AuditResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAudits extends ManageRecords
{
    protected static string $resource = AuditResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
