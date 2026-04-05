<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matriculas_ie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ie_id')->constrained('instituciones');
            $table->foreignId('grado_id')->constrained('grados');
            $table->integer('anio_academico'); // Ej: 2026
            $table->integer('cant_hombres')->default(0);
            $table->integer('cant_mujeres')->default(0);
            $table->timestamps();

            // Unicidad para evitar duplicar matrícula de una IE en el mismo año y grado
            $table->unique(['ie_id', 'grado_id', 'anio_academico'], 'ie_grado_anio_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matricula_i_e_s');
    }
};
