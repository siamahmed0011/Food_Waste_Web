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

            // ✅ Use users table for both donor + NGO accounts (clean & consistent)
            $table->foreignId('food_post_id')->constrained('food_posts')->cascadeOnDelete();
            $table->foreignId('donor_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('ngo_user_id')->constrained('users')->cascadeOnDelete();

            // ✅ Professional status flow
            // pending / approved / rejected / cancelled / picked_up / completed
            $table->string('status')->default('pending');

            // ✅ Time windows (realistic pickup scheduling)
            $table->dateTime('pickup_time_from')->nullable();
            $table->dateTime('pickup_time_to')->nullable();
            $table->dateTime('final_pickup_at')->nullable();

            $table->string('contact_phone')->nullable();
            $table->text('note')->nullable();

            // ✅ Timeline timestamps (super professional)
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->string('rejected_reason')->nullable();

            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('picked_up_at')->nullable();
            $table->dateTime('completed_at')->nullable();

            $table->timestamps();

            // ✅ same NGO cannot request same post twice
            $table->unique(['food_post_id', 'ngo_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_requests');
    }
};
