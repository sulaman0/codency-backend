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
        Schema::create('loc_room_ecg_alerts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('ecg_codes_id');
            $table->string("audio_url");
            $table->string("audio_text");
            $table->string('api_response');
            $table->unique(['room_id', 'ecg_alerts_id']);
            $table->timestamps();
        });

        Schema::table('loc_room_ecg_alerts', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('loc_room');
            $table->foreign('ecg_codes_id')->references('id')->on('ecg_codes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loc_room_ecg_alerts');
    }
};
