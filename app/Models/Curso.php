<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = [
        'nivel_id',
        'nombre'
    ];

    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    public function competencias()
    {
        return $this->hasMany(Competencia::class);
    }
}
