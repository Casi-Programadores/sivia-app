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
        Schema::create('resoluciones_secretaria_general', function (Blueprint $table) {
            $table->id();
            
            $table->integer('numero_resolucion')->unique(); // Número de Resolución
            $table->date('fecha_resolucion'); // Fecha de la Resolución

            $table->timestamps();
            $table->softDeletes(); // Borrado Lógico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resoluciones_secretaria_general');
    }
};
