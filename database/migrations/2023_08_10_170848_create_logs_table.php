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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code');
            $table->integer('tourist_id');
            $table->foreign('tourist_id')->references('id')->on('tourists');
            $table->integer('establishment_id');
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->dateTimeTz('date_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};