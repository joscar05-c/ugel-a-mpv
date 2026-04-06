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
        Schema::create('reporte_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporte_id')->constrained('reportes')->onDelete('cascade');
            $table->foreignId('competencia_id')->constrained('competencias');

            // Cualitativo (Inicial / Primaria)
            $table->integer('cant_ad')->default(0);
            $table->integer('cant_a')->default(0);
            $table->integer('cant_b')->default(0);
            $table->integer('cant_c')->default(0);

            // Cuantitativo (Futuro Secundaria)
            $table->decimal('promedio_num', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_detalles');
    }
};
