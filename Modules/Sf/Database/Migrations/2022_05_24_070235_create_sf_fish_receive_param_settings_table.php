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
        Schema::create('sf_fish_receive_param_settings', function (Blueprint $table) {
            $table->id();
            $table->string('CompanyID')->nullable();
            $table->foreignId('FishSpeciesID')->nullable();
            $table->foreign('FishSpeciesID')->references('id')->on('sf_fish_species')->onDelete('cascade');
            $table->foreignId('FishPrasentationID')->nullable();
            $table->foreign('FishPrasentationID')->references('id')->on('sf_presentation_type')->onDelete('cascade');
            $table->string('paramName')->nullable();
            $table->integer('QParamID')->nullable();
            $table->integer('MinValue')->nullable();
            $table->integer('MaxVal')->nullable();
            $table->integer('DefaultVal')->nullable();
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
        Schema::dropIfExists('sf_fish_receive_param_settings');
    }
};
