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
        // La tabla pivote para la relación 1:1 entre empleados y usuarios.
        // El nombre sigue la convención de Git de ordenar las tablas alfabéticamente.
        Schema::create('employee_user', function (Blueprint $table) {
            
            // 1. Clave foránea al empleado
            $table->foreignId('employee_id')
                  ->unique() // Crucial: Asegura que un empleado solo aparece una vez
                  ->constrained('employees')
                  ->onDelete('cascade');

            // 2. Clave foránea al usuario
            $table->foreignId('user_id')
                  ->unique() // Crucial: Asegura que un usuario solo aparece una vez
                  ->constrained('users')
                  ->onDelete('cascade');

            // 3. Define la clave primaria compuesta (opcional, pero buena práctica)
            // Esta línea no es estrictamente necesaria ya que las restricciones 'unique()'
            // ya fuerzan la unicidad de la relación 1:1.
            $table->primary(['employee_id', 'user_id']);
            
            $table->timestamps();
            $table->softDeletes(); // Borrado Lógico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_user');
    }
};