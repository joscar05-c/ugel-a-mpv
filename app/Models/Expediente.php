<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expediente extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'numero_registro',
        'asunto',
        'tipo_documento_id',
        'usuario_origen_id',
        'email_remitente_temporal',
        'prioridad',
        'folios',
        'estado_actual_id',
        'area_actual_id',
        'usuario_actual_id'
    ];

    //relaciones simples
    public function tipoDocumento() {
        return $this->belongsTo(TipoDocumento::class);
    }

    public function estadoActual(){
        return $this->belongsTo(Estado::class, 'estado_actual_id');
    }

    public function areaActual(){
        return $this->belongsTo(Area::class, 'area_actual_id');
    }

    //remitente (ciudadano o trabajador)
    public function remitente(){
        return $this->belongsTo(User::class, 'usuario_origen_id');
    }

    //quien lo tiene en bandeja actualmente
    public function usuarioActual(){
        return $this->belongsTo(User::class, 'usuario_actual_id');
    }

    //historal completo
    public function movimiento(){
        return $this->hasMany(Movimiento::class)->orderBy('created_at', 'desc');
    }

    //todos los archivos adjuntos (lo que se sube + las respuestas)
    public function archivos(){
        return $this->hasMany(ArchivoAdjunto::class);
    }

}
