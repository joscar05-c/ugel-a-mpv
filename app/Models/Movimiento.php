<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = [
        'expediente_id',
        'area_origen_id',
        'usuario_origen_id',
        'area_destino_id',
        'usuario_destino_id',
        'estado_id',
        'proveido',
        'leido_at'
    ];

    protected $casts = [
        'leido_at' => 'datetime',
    ];

    public function expediente() {
        return $this->belongsTo(Expediente::class);
    }

    public function areaOrigen() {
        return $this->belongsTo(Area::class, 'area_origen_id');
    }

    public function usuarioOrigen() {
        return $this->belongsTo(User::class, 'usuario_origen_id');
    }

    public function areaDestino() {
        return $this->belongsTo(Area::class, 'area_destino_id');
    }

    public function usuarioDestino() {
        return $this->belongsTo(User::class, 'usuario_destino_id');
    }

    public function estado() {
        return $this->belongsTo(Estado::class);
    }

    // Si en este paso se subió un documento (ej. un informe técnico)
    public function archivoAdjunto()
    {
        return $this->hasMany(ArchivoAdjunto::class);
    }
}
