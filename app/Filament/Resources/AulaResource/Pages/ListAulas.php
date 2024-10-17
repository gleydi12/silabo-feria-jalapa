<?php

namespace App\Filament\Resources\AulaResource\Pages;

use App\Filament\Resources\AulaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAulas extends ListRecords
{
    protected static string $resource = AulaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function ($data) {
                    if (! isset($data['sede_id'])) {
                        $data['sede_id'] = auth()->user()->sede_id;
                    }

                    return $data;
                })
                ->icon('heroicon-m-plus')
                ->label('Registrar aula'),
        ];
    }
}
