<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitResource\Pages;
use App\Filament\Resources\VisitResource\RelationManagers;
use App\Models\Visit;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitResource extends Resource
{
    protected static ?string $model = Visit::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label="Visitas";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('visitor_id')
                    ->relationship('visitor',"name")
                    ->label("Visitante")
                    ->required(),
                Forms\Components\Select::make('laboratory_id')
                    ->relationship('laboratory',"name")
                    ->label("Laboratório")
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('visitor.name')
                    ->label("Visitante"),
                Tables\Columns\TextColumn::make('laboratory.name')
                    ->label("Laboratório"),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Visita")
                    ->dateTime()
                    ->timezone("America/Santarem")
                    ->date("d/m/Y H:i")

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisits::route('/'),
            'create' => Pages\CreateVisit::route('/create'),
            'edit' => Pages\EditVisit::route('/{record}/edit'),
        ];
    }
}
