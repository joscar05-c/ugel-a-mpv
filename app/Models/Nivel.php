<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveles';

    protected $fillable = [
        'nombre'
    ];

    public function grados()
    {
        return $this->hasMany(Grado::class);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
