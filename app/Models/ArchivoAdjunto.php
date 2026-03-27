<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoAdjunto extends Model
{
    protected $fillable = [
        'expediente_id',
        'movimiento_id',
        'nombre_archivo',
        'ruta_archivo',
        'es_respuesta_final'
    ];

    public function expediente() {
        return $this->belongsTo(Expediente::class);
    }

    public function movimiento() {
        return $this->belongsTo(Movimiento::class);
    }
}
