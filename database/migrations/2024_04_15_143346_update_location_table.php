<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $blueprint) {
            $blueprint->dropColumn([
                'floor',
                'room',
                'loc_nme'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $blueprint) {
            $blueprint->string('floor')->after('loc_nme')->nullable();
            $blueprint->string('room')->after('loc_nme')->nullable();
            $blueprint->string('loc_nme')->nullable()->change();
        });
    }
};
