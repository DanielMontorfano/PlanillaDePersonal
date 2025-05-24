<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingreso extends Model
{
    use HasFactory;

    protected $fillable = [
        'operario_id',
        'solicitante_id',
        'sector_id',
        'planilla_ingreso_id', // 👈 este
        'fecha_ingreso',
        'fecha_baja',
        'observaciones',
    ];
    

    public function operario()
    {
        return $this->belongsTo(Operario::class);
    }

        public function sector()
    {
        return $this->belongsTo(\App\Models\Sector::class);
    }

    // En el modelo Ingreso
    public function examenMedico()
    {
        return $this->hasOne(ExamenMedico::class);
    }

        public function induccion()
    {
        return $this->hasOne(Induccion::class);
    }
        public function autorizacion()
    {
        return $this->hasOne(\App\Models\Autorizacion::class);
    }

    public function solicitante()
    {
        return $this->belongsTo(\App\Models\Solicitante::class);
    }

        public function planilla()
    {
        return $this->belongsTo(\App\Models\PlanillaIngreso::class, 'planilla_ingreso_id');
    }

    

}
