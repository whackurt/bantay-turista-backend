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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->integer('involved_establishment_id');
            $table->foreign('involved_establishment_id')->references('id')->on('establishments');
            $table->dateTimeTz('date_of_incident');
            $table->text('description');
            $table->text('response')->nullable();            
            $table->integer('tourist_id');
            $table->foreign('tourist_id')->references('id')->on('tourists');
            $table->boolean('resolved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};