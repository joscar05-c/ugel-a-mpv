<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteDetalle extends Model
{
    protected $table = 'reporte_detalles';
    protected $fillable = [
        'reporte_id',
        'competencia_id',
        'cant_ad',
        'cant_a',
        'cant_b',
        'cant_c',
        'promedio_num'
    ];

    public function reporte()
    {
        return $this->belongsTo(Reporte::class);
    }

    public function competencia()
    {
        return $this->belongsTo(Competencia::class);
    }
}
