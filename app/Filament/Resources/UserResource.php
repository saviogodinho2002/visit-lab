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
use Illuminate\Support\Facades\Hash;

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
                    ->label("Laboratório")
                    ->required()
                    ->hidden(Filament::auth()->user()->hasRole("professor")),

                Forms\Components\TextInput::make('register')
                    ->label("Matricula/Siape")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->label("Nome")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label("Email")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->label("Senha")
                    ->required(fn(string $context):bool => $context =="create")
                    ->password()
                    ->maxLength(255)
                    ->autocomplete("off")
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                   ->dehydrated(fn ($state) => filled($state))
                ,
                Forms\Components\Radio::make('type')
                    ->label("Tipo de usuário")
                    ->options([
                        'P' => 'Professor',
                        'M' => 'Monitor',
                    ]) ->descriptions([
                        'P' => 'Ver audições, relatórios, gerenciar visitas e visitantes',
                        'M' => 'gerenciar visitas e visitantes'
                    ])
                    ->default("P")
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Nome"),
                Tables\Columns\TextColumn::make('laboratory.name')
                    ->default("Sem laboratório")
                    ->label("Laboratório"),
                Tables\Columns\TextColumn::make('email')
                    ->label("Email"),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label("Função"),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label("Deletar"),
                Tables\Actions\RestoreAction::make()
                    ->label("Restaurar"),
                Tables\Actions\ForceDeleteAction::make()
                    ->label("Purgar"),

            ])
            ->bulkActions([
                Tables\Actions\RestoreBulkAction::make(),
            ])->filters(

                    Tables\Filters\TrashedFilter::make(),

            );



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
