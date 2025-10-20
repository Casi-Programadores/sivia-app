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
        //Tabla distrito (Ubicacion)
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('district', 100);
            $table->timestamps();
            $table->softDeletes(); // For soft deletion (deleted_at column)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
