<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    protected $table = 'grados';

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
