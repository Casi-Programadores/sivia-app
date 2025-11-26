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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            
            // Clave foránea a la tabla 'personas' (relación 1:1)
            $table->foreignId('persona_id')->unique()->constrained('personas')->onDelete('cascade');
            
            // Número de legajo
            $table->string('numero_legajo', 50)->unique(); 
            
            // Datos de rango / clasificación del empleado
            $table->foreignId('departamento_id')->constrained('departamentos');
            $table->foreignId('distrito_id')->constrained('distritos'); // Parte del puesto del empleado
            $table->foreignId('rol_id')->constrained('roles');
            $table->foreignId('clase_id')->constrained('clases');

            $table->timestamps();
            $table->softDeletes(); // Borrado lógico
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
