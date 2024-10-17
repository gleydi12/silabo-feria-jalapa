<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Sede;
use App\Models\User;
use App\Traits\HasBadgeCount;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function App\Utils\isAdmin;
use function App\Utils\select_sedes;
use function App\Utils\tipos_usuarios;

class UserResource extends Resource
{
    use HasBadgeCount;

    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Personal';
    protected static ?string $pluralLabel = 'Usuarios';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('name')
                        ->label('Nombre')
                        ->required(),

                    TextInput::make('email')
                        ->label('Correo')
                        ->required(),

                    Select::make('tipo')
                        ->label('Tipo')
                        ->options(tipos_usuarios())
                        ->required(),
                    // Lista de sedes
                    select_sedes(),
                ])
                    ->columns()
                    ->description('Información del usuario')
                    ->icon('heroicon-o-user')
                    ->iconColor('secondary'),
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
                Tables\Columns\TextColumn::make('sede.nombre')
                    ->hidden(! isAdmin())
                    ->label('Sede'),
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
                SelectFilter::make('sede_id')
                    ->label('Sede')
                    ->hidden(!isAdmin())
                    ->options(fn () => Sede::pluck('nombre', 'id')),
                SelectFilter::make('tipo')
                    ->label('Tipo de usuario')
                    ->options(tipos_usuarios()),
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
            // Esto carga unicamente los usuarios de la sede del usuario autenticado cuando no es administrador
            ->when(! isAdmin(), function ($query) {
                return $query->where('sede_id', auth()->user()->sede_id);
            })
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
