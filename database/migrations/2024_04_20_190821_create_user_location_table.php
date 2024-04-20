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
        Schema::create('user_location', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('loc_floor_id');
            $table->unsignedBigInteger('loc_room_id');
            $table->timestamps();
        });
        Schema::table('user_location', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('building_id')->references('id')->on('locations');
            $table->foreign('loc_floor_id')->references('id')->on('loc_floor');
            $table->foreign('loc_room_id')->references('id')->on('loc_room');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_location');
    }
};
