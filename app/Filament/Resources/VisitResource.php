<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitChartResource\Widgets\VisitWeekChart;
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
                    ->placeholder("Busque pela matrícula/siape")
                    ->required(),

            ]);
    }
    public static function table(Table $table): Table

    {
        if(Filament::auth()->user()->hasRole(["professor","admin"])){
            $table = $table->filters([
                Tables\Filters\TrashedFilter::make(),
            ]);
        }else{
            $table = $table->filters([]);;
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
                    ->label("Hora de entrada")
                    ->dateTime("d/m/Y H:i","America/Santarem")
                ,
                Tables\Columns\TextColumn::make('departure_time')
                    ->label("Hora de saída")
                    ->dateTime("d/m/Y H:i","America/Santarem")
                ,
            ])
            ->actions([
                Tables\Actions\Action::make('Sair')
                    ->url(fn (Visit $record): string => route('visit.departure', $record))
                    ->hidden(fn (Visit $record) => $record->departure_time != null),
                Tables\Actions\DeleteAction::make()
                    ->label("Deletar"),
                Tables\Actions\RestoreAction::make()
                    ->label("Restaurar"),
                Tables\Actions\ForceDeleteAction::make()
                    ->label("Purgar"),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
                ->withoutGlobalScopes(
                    Filament::auth()->user()->hasRole(["professor","admin"])?
                    [
                        SoftDeletingScope::class,
                    ]:[]
                )
                ->withGlobalScope("visit_scope",new VisitScope);

    }





}
