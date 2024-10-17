<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'carrera_id',
        'user_id',
        'aula_id',
        'sede_id',
        'anio_lectivo_id',

    ];
    public $table = 'horarios';

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function anio_lectivo()
    {
        return $this->belongsTo(Catalogo::class, 'anio_lectivo_id');
    }
}
