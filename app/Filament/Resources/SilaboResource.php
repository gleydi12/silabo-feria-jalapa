<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SilaboResource\Pages;
use App\Filament\Resources\SilaboResource\RelationManagers;
use App\Models\Asignatura;
use App\Models\Sede;
use App\Models\Silabo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;

class SilaboResource extends Resource
{
    protected static ?string $model = Silabo::class;

    protected static ?string $navigationGroup = 'Planificación';

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('asignatura_id')
                ->label('asignatura')
                ->options(Asignatura::all()->pluck('nombre', 'id'))
                ->searchable(),

                Forms\Components\Select::make('user_id')
                ->label('User')
                ->options(User::all()->pluck('name', 'id')) // nombre e id son los campos de la tabla user
                ->searchable(),

                Forms\Components\Select::make('sede_id')
                ->label('Sede')
                ->options(Sede::all()->pluck('nombre', 'id')) // nombre e id son los campos de la tabla carrera
                ->searchable(),

                Forms\Components\TextInput::make('anio_lectivo_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('tipo_evaluacion_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('trimestre_id')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asignatura_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sede_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('anio_lectivo_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo_evaluacion_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('trimestre_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSilabos::route('/'),
            'create' => Pages\CreateSilabo::route('/create'),
            'edit' => Pages\EditSilabo::route('/{record}/edit'),
        ];
    }
}
