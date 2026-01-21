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
        Schema::create('food_posts', function (Blueprint $table) {
            $table->id();

          
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('title');                  
            $table->string('category')->nullable();   
            $table->integer('quantity')->nullable();  
            $table->string('unit')->nullable();       

            // Time
            $table->timestamp('cooked_at')->nullable();      
            $table->timestamp('expiry_time')->nullable();    
            $table->timestamp('pickup_time_from')->nullable();
            $table->timestamp('pickup_time_to')->nullable();

            
            $table->string('pickup_address')->nullable();

            
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();        // storage er path

        
            $table->text('ai_summary')->nullable();

            
            $table->enum('status', ['available', 'reserved', 'completed', 'cancelled'])
                  ->default('available');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_posts');
    }
};
