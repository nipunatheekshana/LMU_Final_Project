<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_airlines', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('iata_code', 10)->nullable();
            $table->string('icao_code', 10)->nullable();
            $table->string('callsign', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('type', 50)->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('enabled')->nullable()->default(true);
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_airlines');
    }
};
