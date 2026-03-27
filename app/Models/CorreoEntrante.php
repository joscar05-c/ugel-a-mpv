<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorreoEntrante extends Model
{
    protected $fillable = [
        'message_id',
        'remitente_email',
        'remitente_nombre',
        'asunto',
        'cuerpo_texto',
        'tiene_adjuntos',
        'procesado',
        'expediente_id',
        'fecha_recepcion_correo'
    ];

    protected $casts = [
        'procesado' => 'boolean',
        'tiene_adjuntos' => 'boolean',
        'fecha_recepcion_correo' => 'datetime',
    ];

    // si el correo ya fue convertido en un trámite se enlaza aquí
    public function expediente()
    {
        return $this->belongsTo(Expediente::class);
    }
}
