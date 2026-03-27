<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'nombre',
        'siglas',
        'parent_id',
        'es_recepcion_externa'
    ];

    //padre-area padre
    public function areaPrincipal() {
        return $this->belongsTo(Area::class, 'parent_id');
    }

    //hijos-subareas
    public function subareas(){
        return $this->hasMany(Area::class, 'parent_id');
    }

    //usuarios que trabajan en el area
    public function usuarios(){
        return $this->hasMany(User::class);
    }
}
