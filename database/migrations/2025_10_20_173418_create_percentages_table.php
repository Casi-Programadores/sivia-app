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
        //Tabla de porcentajes de liquides
        Schema::create('percentages', function (Blueprint $table) {
            $table->id();
            $table->decimal('percentage', 5, 2)->unsigned()->unique();
            $table->timestamps();
            $table->softDeletes(); // For soft deletion (deleted_at column)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('percentages');
    }
};
