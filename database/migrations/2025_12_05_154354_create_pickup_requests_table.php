<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pickup_requests', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->unsignedBigInteger('ngo_id');
            $table->unsignedBigInteger('donor_id');
            $table->unsignedBigInteger('food_post_id')->nullable();

            // Pickup details
            $table->string('food_title')->nullable();
            $table->dateTime('pickup_time')->nullable();

            // Status: pending / accepted / completed / cancelled
            $table->enum('status', ['pending', 'accepted', 'completed', 'cancelled'])
                  ->default('pending');

            $table->text('note')->nullable();

            $table->timestamps();

            // Relations
            $table->foreign('ngo_id')->references('id')->on('ngos')->onDelete('cascade');
            $table->foreign('donor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('food_post_id')->references('id')->on('food_posts')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_requests');
    }
};
