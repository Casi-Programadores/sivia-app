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
        Schema::create('personas_solicitudes_viaticos', function (Blueprint $table) {
            $table->id(); 

            // Foreign Keys
            $table->foreignId('solicitud_viatico_id')->unique()->constrained('solicitudes_viaticos')->onDelete('cascade');
            $table->foreignId('persona_id')->unique()->constrained('personas')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes(); // Borrado lógico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas_solicitudes_viaticos');
    }
};
