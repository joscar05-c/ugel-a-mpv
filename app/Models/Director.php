<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $table = 'directores';
    protected $fillable = [
        'institucion_id',
        'dni',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'celular'
    ];

    public function institucion(){
        return $this->belongsTo(Institucion::class);
    }
}
