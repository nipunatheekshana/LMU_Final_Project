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
        Schema::create('quality_fish_species_lab_test_thresholds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companyId');
            $table->foreign('companyId')->references('id')->on('settings_companies')->restrictOnDelete();
            $table->foreignId('fishSpeciesId');
            $table->foreign('fishSpeciesId')->references('id')->on('sf_fish_species')->restrictOnDelete();
            $table->foreignId('labTestTypeId');
            $table->foreign('labTestTypeId')->references('id')->on('quality_lab_test_types')->restrictOnDelete();
            $table->float('alertThreshold', 8, 3);
            $table->float('lockThreshold', 8, 3);
            $table->unsignedSmallInteger('created_by')->nullable();
            $table->unsignedSmallInteger('modified_by')->nullable();
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
        Schema::dropIfExists('quality_fish_species_lab_test_thresholds');
    }
};
