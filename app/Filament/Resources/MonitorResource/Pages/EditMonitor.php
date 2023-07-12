<?php

namespace App\Filament\Resources\MonitorResource\Pages;

use App\Filament\Resources\MonitorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMonitor extends EditRecord
{
    protected static string $resource = MonitorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
