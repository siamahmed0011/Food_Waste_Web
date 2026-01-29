<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('food_posts', function (Blueprint $table) {
        $table->string('status', 20)->default('available')->change();
    });
}

public function down()
{
    // optional (previous type restore)
}

};
