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
        Schema::create('amplifier_status', function (Blueprint $table) {
            $table->id();
            $table->string('device_name')->nullable();
            $table->string('device_id');
            $table->string('battery_health');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amplifier_status');
    }
};
