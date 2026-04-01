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
        Schema::create('instituciones', function (Blueprint $table) {
            $table->id();
            $table->string('cod_modular')->unique()->nullable();
            $table->string('nombre');
            $table->enum('nivel', [
                'Inicial',
                'Primaria',
                'Secundaria'
            ]);
            $table->string('lugar');
            $table->string('distrito');
            $table->enum('caracteristica',[
                'Unidocente',
                'Polidocente',
                'Multigrado',
                'Privada'
            ]);
            $table->string('direccion')->nullable();
            $table->string('telefono_ie')->nullable();
            $table->text('link_drive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instituciones');
    }
};
