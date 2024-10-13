<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Personal';
    protected static ?string $pluralLabel = 'Usuarios';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->color(fn (int $state): string => match ($state) {
                        User::ADMIN => 'success',
                        User::OFICINAS => 'warning',
                        User::DOCENTES => 'danger',
                        default => 'neutral',
                    })
                    ->formatStateUsing(fn (int $state): string => match ($state) {
                        User::ADMIN => 'Administrador',
                        User::OFICINAS => 'Oficinas',
                        User::DOCENTES => 'Docentes',
                        default => 'Desconocido',
                    })
                    ->badge()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            // Esto carga unicamente los usuarios de la sede del usuario autenticado
            ->where('sede_id', '=', auth()->user()->sede_id)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
