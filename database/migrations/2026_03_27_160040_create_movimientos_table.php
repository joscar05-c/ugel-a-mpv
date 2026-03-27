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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expediente_id')->constrained('expedientes')->cascadeOnDelete();
            $table->foreignId('area_origen_id')->constrained('areas');
            $table->foreignId('usuario_origen_id')->constrained('users');
            $table->foreignId('area_destino_id')->constrained('areas');
            $table->foreignId('usuario_destino_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('estado_id')->constrained('estados');

            $table->text('proveido')->nullable();
            $table->timestamp('leido_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
