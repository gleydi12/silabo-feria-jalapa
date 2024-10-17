<?php

namespace App\Filament\Resources\HorarioResource\Pages;

use App\Filament\Resources\HorarioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHorarios extends ListRecords
{
    protected static string $resource = HorarioResource::class;

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
                ->label('Registrar Horario'),
        ];
    }
}
