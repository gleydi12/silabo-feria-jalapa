<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HorarioResource\Pages;
use App\Models\Aula;
use App\Models\Carrera;
use App\Models\Catalogo;
use App\Models\Horario;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use function App\Utils\select_sedes;
use function App\Utils\isAdmin;

class HorarioResource extends Resource
{
    protected static ?string $model = Horario::class;
    protected static ?string $navigationGroup = 'Planificación';
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('carrera_id')
                    ->label('Carrera')
                    ->options(Carrera::all()->pluck('nombre', 'id')) // nombre e id son los campos de la tabla carrera
                    ->searchable(),

                Forms\Components\Select::make('user_id')
                    ->label('Profesor')
                    ->options(
                        User::where('sede_id', auth()->user()->sede_id)
                            ->where('tipo', User::DOCENTES)
                            ->pluck('name', 'id')
                    )
                    ->searchable(),

                Forms\Components\Select::make('aula_id')
                    ->label('Aula')
                    ->options(
                        Aula::where('sede_id', auth()->user()->sede_id)
                            ->pluck('nombre', 'id')
                    )
                    ->searchable(),

                // Lista de sedes
                select_sedes(),

                Forms\Components\Select::make('anio_lectivo_id')
                    ->options(Catalogo::where('depende_de',1)->pluck('nombre', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('carrera.nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('profesor.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aula.nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sede.nombre')
                ->hidden(! isAdmin(

                ))
                    ->searchable(),

                Tables\Columns\TextColumn::make('anio_lectivo.nombre')
                    ->searchable(),
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
            'index' => Pages\ListHorarios::route('/'),
            // 'create' => Pages\CreateHorario::route('/create'),
            'edit' => Pages\EditHorario::route('/{record}/edit'),
        ];
    }
}



