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
        Schema::create('establishments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name');
            $table->string('city_municipality');
            $table->string('barangay');
            $table->string('address_1');
            $table->string('contact_number');
            $table->string('owner_name');
            $table->string('owner_email');
            $table->string('owner_phone');
            $table->string('photo_url');
            $table->integer('type_id');
            $table->foreign('type_id')->references('id')->on('establishment_types');
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
        Schema::dropIfExists('establishments');
    }


};