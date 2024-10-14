<?php

namespace App\Utils;

use App\Models\Sede;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

function tipos_usuarios(): array
{

    //validar si el usuario ess administrador
    if(!isAdmin()){
        return [
        25 => 'OFICINAS',
        50 => 'DOCENTES',
        ];
    }
    return [
        1 => 'ADMIN',
        25 => 'OFICINAS',
        50 => 'DOCENTES',
    ];
}

function select_sedes(): Select
{
    return Select::make('sede_id')
        ->hidden(!isAdmin())
        ->label('Sede')
        ->searchable()
        ->options(fn () => Sede::pluck('nombre', 'id'));
}

function verify_if_emails_is_taken($object): bool
{
    // Verificar si el correo del usuario ya existe
    if (User::where('email', $object->data['email'])->exists()) {
        Notification::make()
            ->warning()
            ->title('El correo ya existe!')
            ->body('El correo ya existe en la base de datos.')
            ->persistent()
            ->send();
        return true;
    }
    return false;
}

function isAdmin(): bool
{
    return auth()->user()->tipo === User::ADMIN;
}
