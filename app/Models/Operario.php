<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operario extends Model
{
    use HasFactory;

    protected $fillable = [
        'legajo',
        'nombre_completo',
        'tipo_liquidacion',
        'fecha_ingreso',
        'direccion',
        'dni',
        'fecha_nacimiento',
        'cuil',
        'categoria',
        'sector',
        'tarea',
        'gerencia',
    ];
}
