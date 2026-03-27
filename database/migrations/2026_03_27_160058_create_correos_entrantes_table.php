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
        Schema::create('correos_entrantes', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->unique();
            $table->string('remitente_email');
            $table->string('remitente_nombre')->nullable();
            $table->string('asunto');
            $table->longText('cuerpo_texto')->nullable();
            $table->boolean('tiene_adjuntos')->default(false);

            //control de prueba piloto
            $table->boolean('procesado')->default(false);
            $table->foreignId('expediente_id')->nullable()->constrained('expedientes')->nullOnDelete();

            $table->timestamp('fecha_recepcion_correo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correos_entrantes');
    }
};
