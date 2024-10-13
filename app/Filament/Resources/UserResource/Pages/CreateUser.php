<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

use function App\Utils\verify_if_emails_is_taken;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Crear usuario';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Agregar una contraseña por defecto para todos los usuarios
        $data['password'] = bcrypt(12345678);
        // Crear un token de recordar por defecto para todos los usuarios
        $data['remember_token'] = Str::random(10);

        // Verificar el correo por defecto para todos los usuarios
        $data['email_verified_at'] = now();

        //Definir la sede por defecto cuado se crea un usuario y no es un administrador
        if (! isset($data['sede_id'])) {
            $data['sede_id'] = auth()->user()->sede_id;
        }

        return parent::mutateFormDataBeforeCreate($data);
    }

    protected function beforeCreate(): void
    {
        if (verify_if_emails_is_taken($this)) {
            $this->halt();
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
