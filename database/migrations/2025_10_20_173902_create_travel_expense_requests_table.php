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
        Schema::create('travel_expense_requests', function (Blueprint $table) {
            $table->id();
            $table->string('internal_note_number', 50)->unique();
            $table->unsignedSmallInteger('number_of_days');
            
            // Foreign Keys
            $table->foreignId('percentage_id')->constrained('percentages');
            $table->foreignId('district_id')->constrained('districts');

            $table->decimal('amount', 10, 2); // Amount per day or base amount
            $table->decimal('total_amount', 10, 2);
            
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('commission_object', 255); 
            $table->text('observation')->nullable();

            $table->timestamps();
            $table->softDeletes(); // For soft deletion (deleted_at column)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_expense_requests');
    }
};
