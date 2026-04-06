<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $fillable = ['nombre', 'fecha_inicio', 'fecha_fin', 'is_active'];

    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }
}
