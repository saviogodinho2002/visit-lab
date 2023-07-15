<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Scopes\UserScope;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $label = "Usuários";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('laboratory_id')
                    ->relationship("laboratory","name")
                    ->required()
                    ->hidden(Filament::auth()->user()->hasRole("professor")),

                Forms\Components\TextInput::make('register')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->password()
                    ->maxLength(255),
                Forms\Components\Radio::make('type')
                    ->options([
                        'A' => 'Professor',
                        'M' => 'Monitor',
                    ])->default('A'),
            ]);
    }

    public static function table(Table $table): Table
    {
        if(Filament::auth()->user()->hasRole(["professor","admin"])){
            $table = $table->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
             //   Tables\Actions\ForceDeleteBulkAction::make(),
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
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('laboratory.name'),
                Tables\Columns\TextColumn::make('email'),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {

            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,

                ])
                ->withGlobalScope("userscope",
                    new UserScope
                )
                //->where("laboratory_id","=",1)
                ;

    }

}
