<?php

namespace App\Filament\Resources\SilaboResource\Pages;

use App\Filament\Resources\SilaboResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSilabo extends EditRecord
{
    protected static string $resource = SilaboResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
