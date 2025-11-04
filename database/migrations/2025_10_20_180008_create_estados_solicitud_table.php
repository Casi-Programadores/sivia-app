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
        Schema::create('estados_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_estado', 50)->unique(); // Ejemplo: "Pendiente", "Aprobado", "Rechazado"
            
            $table->timestamps();
            $table->softDeletes(); // Borrado Lógico
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_solicitudes');
    }
};
