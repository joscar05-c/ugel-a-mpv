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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ie_id')->constrained('instituciones'); // Asumiendo que tu tabla es 'instituciones'
            $table->foreignId('grado_id')->constrained('grados');
            $table->foreignId('periodo_id')->constrained('periodos');
            $table->timestamp('fecha_envio')->useCurrent();
            $table->string('ip_origen')->nullable();
            $table->string('nombre_docente')->nullable(); // Opcional, para saber quién llenó
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
