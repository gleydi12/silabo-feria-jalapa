<?php


namespace App\Filament\Resources;


use App\Filament\Resources\CatalogoResource\Pages;
use App\Models\Catalogo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class CatalogoResource extends Resource
{
   protected static ?string $model = Catalogo::class;
   protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


   protected static ?int $navigationSort = 3;
   protected static ?string $navigationGroup = 'Currículo';
   protected static ?string $pluralModelLabel = 'Catálogo';


   public static function form(Form $form): Form
   {
       return $form
           ->schema([
               Forms\Components\Section::make('Datos del catálogo')
                   ->schema([
                       Forms\Components\TextInput::make('nombre')
                           ->required(),
                       Forms\Components\Select::make('depende_de')
                           ->options(fn () => Catalogo::whereNull('depende_de')->pluck('nombre', 'id')),
                   ])
                   ->icon('heroicon-o-information-circle')
                   ->iconColor('success')
                   ->columns(),
           ]);
   }


   public static function table(Table $table): Table
   {
       return $table
           ->columns([
               Tables\Columns\TextColumn::make('nombre'),
               Tables\Columns\TextColumn::make('depende.nombre'),
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
           'index' => Pages\ListCatalogos::route('/'),
           'create' => Pages\CreateCatalogo::route('/create'),
           'edit' => Pages\EditCatalogo::route('/{record}/edit'),
       ];
   }
}
