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
        Schema::create('travel_expense_request_details', function (Blueprint $table) {
            $table->id();
            
            // Claves Foráneas
            $table->foreignId('request_status_id')->constrained('request_statuses');
            $table->foreignId('travel_expense_request_id')->unique()->constrained('travel_expense_requests')->onDelete('cascade');
            $table->foreignId('entry_desk_id')->nullable()->constrained('entry_desks');
            $table->foreignId('resolution_id')->nullable()->constrained('general_secretariat_resolutions');
            
            // Un detalle de viático DEBE ser único por solicitud
            $table->timestamps();
            $table->softDeletes(); // Borrado Lógico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_expense_request_details');
    }
};
