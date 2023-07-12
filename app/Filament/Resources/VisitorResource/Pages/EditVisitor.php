<?php

namespace App\Filament\Resources\VisitorResource\Pages;

use App\Filament\Resources\VisitorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVisitor extends EditRecord
{
    protected static string $resource = VisitorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
