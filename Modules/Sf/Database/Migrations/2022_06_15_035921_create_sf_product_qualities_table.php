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
        Schema::create('sf_product_qualities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('CompanyID')->nullable();
            $table->foreign('CompanyID')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->foreignId('FishSpecies')->nullable();
            $table->foreign('FishSpecies')->references('id')->on('sf_fish_species')->onDelete('cascade');
            $table->string('QualityID')->nullable();
            $table->string('QualityName')->nullable();
            $table->string('QualityDescription')->nullable();
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
        Schema::dropIfExists('sf_product_qualities');
    }
};
