<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditResource\Pages;
use App\Filament\Resources\AuditResource\RelationManagers;
use App\Models\Audit;
use App\Models\Scopes\AuditScope;
use App\Models\Scopes\UserScope;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AuditResource extends Resource
{
    protected static ?string $model = Audit::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $label = "Auditoria";

    public static function canCreate(): bool
    {

        return false;
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label("Responsável"),
                Tables\Columns\TextColumn::make('auditable_type')
                    ->label("Entidade"),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Criado")
                    ->dateTime("d/m/Y H:i", "America/Santarem"),
                Tables\Columns\TextColumn::make('event')
                    ->label("Ação"),
            ])
            ->filters([
                //
            ])
            ->actions([

            ])
            ->bulkActions([

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAudits::route('/'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {

        return parent::getEloquentQuery()

            ->withGlobalScope("userscope",
                new AuditScope
            )
            ->orderByDesc("created_at")
            //->where("laboratory_id","=",1)
            ;

    }
}
