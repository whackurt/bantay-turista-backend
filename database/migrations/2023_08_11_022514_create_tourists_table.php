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
        Schema::create('tourists', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('qr_code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('country');
            $table->string('state_province');
            $table->string('city_municipality');
            $table->string('address_1');
            $table->string('address_2')->nullable(true);
            $table->string('gender');
            $table->string('nationality');
            $table->string('photo_url');
            $table->string('contact_number');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourists');
    }
};