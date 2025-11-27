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
        Schema::create('empleado_solicitud_viatico', function (Blueprint $table) {
            $table->id(); 

            // Foreign Keys
            $table->foreignId('solicitud_viatico_id')->constrained('solicitudes_viaticos')->onDelete('cascade');
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes(); // Borrado lógico

            // Evita duplicados: el mismo empleado repetido en la misma solicitud
            $table->unique(['solicitud_viatico_id', 'empleado_id'], 'solicitud_empleado_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado_solicitud_viatico');
    }
};
