<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {

        if(!Filament::auth()->user()->hasRole(["admin"])){
            $data["laboratory_id"] = Filament::auth()->user()->laboratory_id;
        }

        return $data;
    }
    protected function afterSave(): void
    {

        if($this->data["type"] == "M"){
            $this->record->syncRoles(["monitor"]);
        }
        elseif($this->data["type"] == "P"){
            $this->record->syncRoles(["professor"]);
        }
    }
}
