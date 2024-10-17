<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuiaResource\Pages;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Guia;
use App\Models\Sede;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use function App\Utils\select_sedes;

class GuiaResource extends Resource
{
    protected static ?string $model = Guia::class;
    protected static ?string $navigationGroup = 'Planificación';
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('silabo_id')
                    ->numeric()
                    ->default(null),

                Forms\Components\TextInput::make('detalle_silabo_id')
                    ->numeric()
                    ->default(null),

                // Añadir una lista desplegable para seleccionar la carrera
                // Cargar las carreras desde la base de datos
                Forms\Components\Select::make('carrera_id')
                    ->label('Carrera')
                    ->options(Carrera::all()->pluck('nombre', 'id')) // nombre e id son los campos de la tabla carrera
                    ->searchable(),

                // Lista de sedes
                select_sedes(),

                Forms\Components\Select::make('asignatura_id')
                    ->label('asignatura')
                    ->options(Asignatura::all()->pluck('nombre', 'id'))
                    ->searchable(),

                Forms\Components\RichEditor::make('objetivo_conceptual')
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('objetivo_procedimental')
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('objetivo_actitudinal')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('silabo_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('detalle_silabo_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('carrera_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sede_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('asignatura_id')
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
            'index' => Pages\ListGuias::route('/'),
            'create' => Pages\CreateGuia::route('/create'),
            'edit' => Pages\EditGuia::route('/{record}/edit'),
        ];
    }
}
