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
        Schema::create('general_secretariat_resolutions', function (Blueprint $table) {
            $table->id();
            
            $table->string('resolution_number', 50)->unique(); // Número de Resolución
            $table->date('resolution_date'); // Fecha de la Resolución

            $table->timestamps();
            $table->softDeletes(); // Borrado Lógico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_secretariat_resolutions');
    }
};
