<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reportes';
    protected $fillable = ['ie_id', 'grado_id', 'periodo_id', 'fecha_envio', 'ip_origen', 'nombre_docente'];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'ie_id');
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function detalles()
    {
        return $this->hasMany(ReporteDetalle::class);
    }
}
