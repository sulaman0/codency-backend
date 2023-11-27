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
        Schema::create('ecg_codes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('code', 30);
            $table->string('color_code', 10);
            $table->enum('action', ['sent_to_amplifier_directly', 'sent_to_manager'])->default('sent_to_manager');
            $table->enum('preferred_lang', ['en', 'ar'])->default('en');
            $table->enum('sent_email', ['yes', 'no'])->default('no');
            $table->enum('status', ['active', 'blocked'])->default('active');
            $table->string('tune_en');
            $table->string('tune_ar')->nullable();
            $table->string('details');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecg_codes');
    }
};
