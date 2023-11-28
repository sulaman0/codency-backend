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
        Schema::create('ecg_alerts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ecg_code_id');
            $table->string('ecg_code_nme');
            $table->unsignedInteger('location_id');
            $table->string('location_nme');
            $table->unsignedInteger('alarm_triggered_by_id');
            $table->dateTime('alarm_triggered_at')->default(now());
            $table->unsignedInteger('respond_by_id')->nullable();
            $table->dateTime('respond_at')->nullable();
            $table->enum('respond_action', ['accept', 'reject'])->nullable();
            $table->dateTime('played_at_amplifier')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecg_alerts');
    }
};
