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
        Schema::create('solicitudes_viaticos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('numero_nota_interna_id')->constrained('numero_nota_interna')->onDelete('cascade');
            $table->unsignedSmallInteger('cantidad_dias');

            // Claves foráneas
            $table->foreignId('porcentaje_id')->constrained('porcentajes');
            $table->foreignId('distrito_id')->constrained('distritos');

            $table->foreignId('localidad_id')
                ->constrained('localidades')
                ->onDelete('cascade');

            $table->decimal('monto', 10, 2); // Monto diario o monto base
            $table->decimal('monto_total', 10, 2);

            $table->dateTime('fecha_fin');
            $table->string('objeto_comision', 255);
            $table->text('observacion')->nullable();

            $table->timestamps();
            $table->softDeletes(); // Borrado lógico
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_viaticos');
    }
};
