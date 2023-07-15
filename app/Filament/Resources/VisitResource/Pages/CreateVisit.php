<?php

namespace App\Filament\Resources\VisitResource\Pages;

use App\Filament\Resources\VisitResource;
use Filament\Facades\Filament;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;

class CreateVisit extends CreateRecord
{
    protected static string $resource = VisitResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data["laboratory_id"] = Filament::auth()->user()->laboratory_id;
        $data["user_id"] = Filament::auth()->user()->id;
        return $data;
    }


}
