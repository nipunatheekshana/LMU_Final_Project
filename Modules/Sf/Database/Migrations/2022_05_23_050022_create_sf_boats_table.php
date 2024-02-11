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
        Schema::create('sf_boats', function (Blueprint $table) {
            $table->id();
            $table->integer('BoatID')->nullable();
            $table->string('BoatRegNo', 150)->nullable();
            $table->string('BoatCode', 150)->nullable();
            $table->string('RegCountry', 20)->nullable();
            $table->string('BoatName', 255)->nullable();
            $table->string('BoatShortName', 150)->nullable();
            $table->string('Call_Sign', 255)->nullable();
            $table->foreignId('BoatCategory')->nullable();
            $table->foreign('BoatCategory')->references('id')->on('sf_boat_categories')->onDelete('cascade');
            $table->double('BoatLength')->nullable();
            $table->string('EngineCapacity')->nullable();
            $table->double('BoatWeight')->nullable();
            $table->boolean('LicenseRequired')->nullable();
            $table->string('LicenseNo', 150)->nullable();
            $table->date('LicenseExpDate')->nullable();
            $table->boolean('LogSheetRequired')->nullable();
            $table->string('OwnerName')->nullable();
            $table->string('SkipperName')->nullable();
            $table->integer('NoofTanks')->nullable();
            $table->integer('NoofCrew')->nullable();
            $table->boolean('BoatHold')->nullable();
            $table->string('HoldReason')->nullable();
            $table->integer('list_index')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->boolean('enabled')->default(true);
            $table->string('boatImg')->nullable();
            $table->string('skipperSign')->nullable();
            $table->string('licenceImage')->nullable();



            $table->timestamps();

            // index
            $table->index('id', 'id');
            $table->index('enabled', 'enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sf_boats');
    }
};
