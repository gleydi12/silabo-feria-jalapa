<?php

namespace App\Filament\Resources\SilaboResource\Pages;

use App\Filament\Resources\SilaboResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSilabos extends ListRecords
{
    protected static string $resource = SilaboResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
