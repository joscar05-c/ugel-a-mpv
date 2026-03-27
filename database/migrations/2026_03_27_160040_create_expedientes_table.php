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
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_registro')->unique();
            $table->text('asunto');
            $table->foreignId('tipo_documento_id')->nullable()->constrained('tipos_documento')->nullOnDelete();
            $table->foreignId('usuario_origen_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('email_remitente_temporal')->nullable();
            $table->enum('prioridad', [
                'Baja',
                'Normal',
                'Alta',
                'Urgente'
            ])->default('Normal');
            $table->integer('folios')->default(1);

            //ubicacion y estados
            $table->foreignId('estado_actual_id')->constrained('estados');
            $table->foreignId('area_actual_id')->constrained('areas');
            $table->foreignId('usuario_actual_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};
