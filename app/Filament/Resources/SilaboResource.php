<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SilaboResource\Pages;
use App\Models\Asignatura;
use App\Models\Sede;
use App\Models\Silabo;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use function App\Utils\select_sedes;

class SilaboResource extends Resource
{
    protected static ?string $model = Silabo::class;
    protected static ?string $navigationGroup = 'Planificación';
    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?int $navigationSort = 6;

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

                // Lista de sedes
                select_sedes(),

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
