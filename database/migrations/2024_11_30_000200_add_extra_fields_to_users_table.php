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
    Schema::table('users', function (Blueprint $table) {

        if (!Schema::hasColumn('users', 'phone')) {
            $table->string('phone')->nullable();
        }

        if (!Schema::hasColumn('users', 'organization_name')) {
            $table->string('organization_name')->nullable();
        }

        if (!Schema::hasColumn('users', 'organization_type')) {
            $table->string('organization_type')->nullable();
        }

        if (!Schema::hasColumn('users', 'district')) {
            $table->string('district')->nullable();
        }

        if (!Schema::hasColumn('users', 'city')) {
            $table->string('city')->nullable();
        }

        if (!Schema::hasColumn('users', 'road_no')) {
            $table->string('road_no')->nullable();
        }

        if (!Schema::hasColumn('users', 'house_no')) {
            $table->string('house_no')->nullable();
        }

        if (!Schema::hasColumn('users', 'address')) {
            $table->string('address')->nullable();
        }

        if (!Schema::hasColumn('users', 'latitude')) {
            $table->decimal('latitude', 10, 7)->nullable();
        }

        if (!Schema::hasColumn('users', 'longitude')) {
            $table->decimal('longitude', 10, 7)->nullable();
        }
    });
}


public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'phone',
            'organization_name',
            'organization_type',
            'district',
            'city',
            'road_no',
            'house_no',
            'address',
            'latitude',
            'longitude',
        ]);
    });
}

};
