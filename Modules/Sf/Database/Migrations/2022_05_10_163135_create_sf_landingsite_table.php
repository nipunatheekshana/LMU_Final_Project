<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sf_landingsite', function (Blueprint $table) {
            $table->id();
            $table->string('LandingSiteID', 20)->nullable();
            $table->string('LandingSiteName', 150)->nullable();
            $table->string('Longitude', 150)->nullable();
            $table->string('Latitude', 150)->nullable();
            $table->string('LongLat', 150)->nullable();
            $table->string('countryCode', 20)->nullable();

            $table->string('LandingSiteImage', 150)->nullable();
            $table->integer('list_index')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->boolean('enabled')->default(true);
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
        Schema::dropIfExists('sf_landingsite');
    }
};
