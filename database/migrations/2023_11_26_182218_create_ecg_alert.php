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
        Schema::create('ecg_alert', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ecg_alert_id');
            $table->timestamps();
        });

        Schema::table('ecg_alert', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ecg_alert_id')->references('id')->on('ecg_alerts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecg_alert');
    }
};
