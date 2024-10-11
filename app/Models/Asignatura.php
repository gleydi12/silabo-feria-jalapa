<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asignatura extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'carrera-id',
        'nombre',
        'codigo',
        'area_formacion_id',
        'area_disiplinaria_id',
        'modalidad_id',
        'regimen_id',
        'anio_academico_id',
        'plan_estudio_id',
        'prerrequisitos',
        'creditos',
        'horas_precenciales',
        'horas_trabajo_independiente',
        'frecuencias',
        'autor',
        'fecha_aprobacion',
        'autorizado_por',

    ];

    public $table = 'asignaturas';

}
