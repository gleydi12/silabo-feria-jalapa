<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleSilabo extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'silabo_id',
        'encuentro',
        'fecha',
        'unidades_id',
        'objetivos',
        'contenidos_id',
        'forma_organizativa_id',
        'formas_organizativa_detalle',
        'metodologia',
        'horas_precenciales',
        'horas_trabajo_independiente',
        'evaluacion_id',
        'evaluacion_detalle',
        'observaciones',
    ];
    public $table = 'detalle_silabos';
}
