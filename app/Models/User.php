<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    // Tipos de usuarios de la app.
    // Se definen como constantes para evitar errores de escritura.
    const ADMIN = 1;
    const OFICINAS = 25;
    const DOCENTES = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'sede_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //Relacion con sede
    public function sede()
    {
        //belongsto: reacion de uno a uno
        return $this->belongsTo(Sede::class);
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->tipo === self::ADMIN;
    }

    public function getIsOficinaAttribute(): bool
    {
        return $this->tipo === self::OFICINAS;
    }

    public function getIsDocenteAttribute(): bool
    {
        return $this->tipo === self::DOCENTES;
    }
}
