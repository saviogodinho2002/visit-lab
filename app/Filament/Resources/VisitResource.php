<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitCharResource\Widgets\VisitWeekChart;
use App\Filament\Resources\VisitResource\Pages;
use App\Filament\Resources\VisitResource\RelationManagers;
use App\Models\Scopes\VisitScope;
use App\Models\Visit;
use App\Models\Visitor;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class VisitResource extends Resource
{
    protected static ?string $model = Visit::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected static ?string $label = "Visita";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('visitor_id')
                    ->relationship("visitor","register")
                    ->searchable()
                    ->label("Visitante")
                    ->required(),
                /*Forms\Components\TextInput::make('laboratory_id')
                    ->required(),
                Forms\Components\TextInput::make('user_id')
                    ->required(),*/
            ]);
    }
    public static function table(Table $table): Table

    {
        if(Filament::auth()->user()->hasRole(["professor","admin"])){
            $table = $table->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]) ->filters([
                Tables\Filters\TrashedFilter::make(),
            ]);
        }else{
            $table = $table->bulkActions([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
                ;;
        }
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('visitor.name')
                    ->label("Nome"),
                Tables\Columns\TextColumn::make('laboratory.name')
                    ->label("Laboratório"),
                Tables\Columns\TextColumn::make('user.name')
                    ->label("Monitor presente"),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Data - hora")
                    ->dateTime("d/m/Y H:i","America/Santarem")
                ,
            ])
            ->actions([

                Tables\Actions\DeleteAction::make(),
            ])


            ;
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

    public static function getEloquentQuery(): Builder
    {

            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ])
                ->withGlobalScope("visit_scope",new VisitScope);

    }
    public static function getWidgets(): array
    {
        return [
           VisitWeekChart::class,
        ];
    }



}
