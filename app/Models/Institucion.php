<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table = 'instituciones';
    protected $fillable = [
        'nombre',
        'nivel',
        'lugar',
        'distrito',
        'caracteristica',
        'link_drive'
    ];

    public function director(){
        return $this->hasOne(Director::class);
    }
}
