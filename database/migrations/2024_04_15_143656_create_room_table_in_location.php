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
        Schema::create('loc_room', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('loc_floor_id');
            $table->string('room_nme');
            $table->enum('status', ['active', 'inactive']);
            $table->enum('audio_status', ['synced', 'pending', 'processing'])->default('pending');
            $table->string('audio_url');
            $table->timestamps();
        });
        Schema::table('loc_room', function (Blueprint $table) {
            $table->foreign('building_id')->references('id')->on('locations');
            $table->foreign('loc_floor_id')->references('id')->on('loc_floor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_table_in_location');
    }
};
