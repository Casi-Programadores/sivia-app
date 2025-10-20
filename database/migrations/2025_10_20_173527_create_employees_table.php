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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            
            // Clave foránea a la tabla 'people' (relación 1:1)
            $table->foreignId('person_id')->unique()->constrained('people')->onDelete('cascade');
            
            // Número de legajo
            $table->string('employee_file_number', 50)->unique(); 
            
            // Datos de Rango/Clasificación del Empleado
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('district_id')->constrained('districts'); // Incluimos 'district_id' aquí, ya que es parte del puesto del empleado.
            $table->foreignId('class_id')->constrained('employeeclasses');

            $table->timestamps();
            $table->softDeletes(); // For soft deletion (deleted_at column)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
