<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatriculaIE extends Model
{
    protected $table = 'matriculas_ie';
    protected $fillable = ['ie_id', 'grado_id', 'anio_academico', 'cant_hombres', 'cant_mujeres'];

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'ie_id');
    }
}
