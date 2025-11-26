<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up(): void
    {
        // Tabla de porcentajes de viáticos
        Schema::create('porcentajes', function (Blueprint $table) {
            $table->id();
            $table->decimal('porcentaje', 5, 2)->unsigned()->unique();
            $table->timestamps();
            $table->softDeletes(); // Borrado lógico
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('porcentajes');
    }
};
