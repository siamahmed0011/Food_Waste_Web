<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {

        if (!Schema::hasColumn('users', 'donor_type')) {
            $table->string('donor_type')->nullable()->after('phone');
        }

        if (!Schema::hasColumn('users', 'organization_name')) {
            $table->string('organization_name')->nullable()->after('donor_type');
        }

        if (!Schema::hasColumn('users', 'pickup_address')) {
            $table->text('pickup_address')->nullable()->after('organization_name');
        }

        if (!Schema::hasColumn('users', 'pickup_time')) {
            $table->string('pickup_time')->nullable()->after('pickup_address');
        }

        if (!Schema::hasColumn('users', 'alt_phone')) {
            $table->string('alt_phone')->nullable()->after('pickup_time');
        }

        if (!Schema::hasColumn('users', 'pickup_notes')) {
            $table->text('pickup_notes')->nullable()->after('alt_phone');
        }
    });
}


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'donor_type',
                'organization_name',
                'pickup_address',
                'pickup_time',
                'alt_phone',
                'pickup_notes',
            ]);
        });
    }
};
