<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Data, Catalogo, Asignatura, Detalle Guia, Detalle Silabo

class Plan extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'silabo_id',
        'sede_id',
        'detalle_solabo_id',
        'objetivo_conceptual',
        'objetivo_procedimental',
        'objetivo_actitudinal',
        'primer_momento',
        'segundo_momento',
        'tercer_momento',
        'aplicacion_eje',
        'observaciones',
    ];
    public $table = 'planes';
}
