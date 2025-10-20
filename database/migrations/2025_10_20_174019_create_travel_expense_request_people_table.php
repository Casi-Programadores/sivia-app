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
        Schema::create('travel_expense_request_people', function (Blueprint $table) {
            $table->id(); 

            // Foreign Keys
            $table->foreignId('travel_expense_request_id')->unique()->constrained('travel_expense_requests')->onDelete('cascade');
            $table->foreignId('person_id')->unique()->constrained('people')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes(); // For soft deletion (deleted_at column)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_expense_request_people');
    }
};
