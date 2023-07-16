<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {


        if(!Filament::auth()->user()->hasRole(["admin"])){
            $data["laboratory_id"] = Filament::auth()->user()->laboratory_id;
        }


        return $data;
    }
    protected function afterCreate(): void
    {//todo aplicar roles
        // Runs after the form fields are saved to the database.
        //$this->record

        if($this->data["type"] == "M"){
            $this->record->assignRole("monitor");
        }
        elseif($this->data["type"] == "P"){
            $this->record->assignRole("professor");
        }
    }


}
