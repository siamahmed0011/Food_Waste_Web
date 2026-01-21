<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pickups', function (Blueprint $table) {
            $table->id();

            // Which donor created this pickup request
            $table->foreignId('donor_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Food details (direct form theke)
            $table->string('food_type');
            $table->integer('quantity')->unsigned();
            $table->string('unit', 50);

            $table->dateTime('prepared_at')->nullable();
            $table->dateTime('best_before')->nullable();

            // Pickup details
            $table->dateTime('pickup_time');
            $table->text('pickup_address');
            $table->string('contact_phone', 30);
            $table->text('notes')->nullable();

            // Status (donor-side)
            $table->enum('status', ['pending', 'accepted', 'completed', 'cancelled'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickups');
    }
};
