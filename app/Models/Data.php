<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Data extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'value',
        'categoria_id',
        'tipo_dato_id',
        'asignable',
        'depende_de_id',

    ];
    public $table = 'datas';
}
