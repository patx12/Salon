<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First create the table without foreign key constraints
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id');  // Changed from foreignId
            $table->decimal('amount', 8, 2);
            $table->enum('payment_method', ['cash', 'gcash', 'bank_transfer', 'card'])->default('cash');
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
        
        // Add foreign key after table is created (if appointments table exists)
        if (Schema::hasTable('appointments')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->foreign('appointment_id')
                      ->references('id')
                      ->on('appointments')
                      ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};