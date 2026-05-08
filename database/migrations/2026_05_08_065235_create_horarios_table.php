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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ie_id')->constrained('instituciones')->onDelete('cascade');
            $table->enum('dia_semana', ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes']);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('curso'); // Ej: Educación Física
            $table->string('docente')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
