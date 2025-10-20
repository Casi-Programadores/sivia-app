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
        //Mesa de entrada
        Schema::create('entry_desks', function (Blueprint $table) {
            $table->id();

            $table->string('letter', 50);
            $table->string('file_number', 50)->unique(); // Número de Expediente
            $table->date('entry_date'); // Fecha de la Mesa de Entradas

            $table->timestamps();
            $table->softDeletes(); // Borrado Lógico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entry_desks');
    }
};
