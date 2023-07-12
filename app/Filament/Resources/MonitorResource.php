<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\RelationManagers\LaboratoriesRelationManager;
use App\Filament\Resources\MonitorResource\Pages;
use App\Filament\Resources\MonitorResource\RelationManagers;
use App\Models\Monitor;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MonitorResource extends Resource
{
    protected static ?string $model = Monitor::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $label= 'Monitores';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('laboratory_id')
                    ->relationship('laboratory',"name")
                    ->label("Laboratório")

                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label("Nome")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('register')
                    ->name("Matricula")
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('laboratory.name')
                    ->label("Laboratório")

                ,
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('register'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [


        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMonitors::route('/'),
            'create' => Pages\CreateMonitor::route('/create'),
            'edit' => Pages\EditMonitor::route('/{record}/edit'),
        ];
    }
}
