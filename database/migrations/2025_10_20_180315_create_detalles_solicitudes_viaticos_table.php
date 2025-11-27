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
        Schema::create('detalles_solicitudes_viaticos', function (Blueprint $table) {
            $table->id();
            
            // Claves Foráneas
            $table->foreignId('estado_solicitud_id')->constrained('estados_solicitudes');
            $table->foreignId('solicitud_viatico_id')->unique()->constrained('solicitudes_viaticos')->onDelete('cascade');
            $table->foreignId('mesa_entrada_id')->nullable()->constrained('mesas_entradas');
            $table->foreignId('resolucion_id')->nullable()->constrained('resoluciones_secretaria_general');
            
            // Un detalle de viático DEBE ser único por solicitud
            $table->timestamps();
            $table->softDeletes(); // Borrado Lógico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_solicitudes_viaticos');
    }
};
