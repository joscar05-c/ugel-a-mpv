<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    /** @use HasFactory<\Database\Factories\HorarioFactory> */
    use HasFactory;
    protected $table = 'horarios';
    protected $fillable = [
        'ie_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'curso',
        'docente',
    ];
}
