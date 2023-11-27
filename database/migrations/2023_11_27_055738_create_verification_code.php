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
        Schema::create('verification_codes', function (Blueprint $blueprint) {
            $blueprint->increments('id');
            $blueprint->string('code', 6);
            $blueprint->unsignedBigInteger('user_id');
            $blueprint->boolean('is_used')->default(false);
            $blueprint->dateTime('expire_at');
            $blueprint->dateTime('verified_at')->nullable();
            $blueprint->enum('type', [
                'reset_password',
                'verify_phone'
            ])->default('reset_password');
            $blueprint->timestamps();
        });

        Schema::table('verification_codes', function (Blueprint $blueprint) {
            $blueprint->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_codes');
    }
};
