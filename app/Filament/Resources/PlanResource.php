<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use function App\Utils\select_sedes;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;
    protected static ?string $navigationGroup = 'Planificación';
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Planes';
    protected static ?string $pluralModelLabel = 'Planes';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([

                    Forms\Components\TextInput::make('silabo_id')
                        ->numeric()
                        ->default(null),

                    // Lista de sedes
                    select_sedes(),

                    Forms\Components\TextInput::make('detalle_silabo_id')
                        ->numeric()
                        ->default(null),
                    Forms\Components\RichEditor::make('objetivo_conceptual')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('objetivo_procedimental')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('objetivo_actitudinal')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('primer_momento')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('segundo_momento')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('tercer_momento')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('aplicacion_eje')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('observaciones')
                        ->columnSpanFull(),
                ]

                )
                    ->columns()
                    ->description('Registro de Planes')
                    ->icon('heroicon-o-sparkles')
                    ->iconColor('success')
                    ->iconSize('lg'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('silabo_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sede_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('detalle_silabo_id')
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
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
