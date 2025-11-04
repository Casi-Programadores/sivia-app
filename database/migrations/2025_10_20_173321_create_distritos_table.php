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
        // Tabla de distritos (ubicación)
        Schema::create('distritos', function (Blueprint $table) {
            $table->id();
            $table->string('distrito', 100);
            $table->timestamps();
            $table->softDeletes(); // Borrado lógico
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('distritos');
    }
};
