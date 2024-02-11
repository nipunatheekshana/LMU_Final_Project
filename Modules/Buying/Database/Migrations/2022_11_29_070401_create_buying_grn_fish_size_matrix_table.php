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

        Schema::create('buying_grn_fish_size_matrix', function (Blueprint $table) {

            $table->id();
            $table->string('grnNo')->nullable();
            // $table->foreign('grnNo')->references('id')->on('buying_fish_grn_hd')->onDelete('cascade');
            $table->foreignId('CompanyId')->nullable();
            $table->foreign('CompanyId')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->foreignId('FishSpeciesId')->nullable();
            $table->foreign('FishSpeciesId')->references('id')->on('sf_fish_species')->onDelete('cascade');
            $table->float('minValue')->nullable();
            $table->float('maxValue')->nullable();
            $table->string('SizeCode')->nullable();
            $table->string('SizeDescription')->nullable();
            $table->integer('list_index')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            // index
            $table->index('id', 'id');
            $table->index('SizeDescription', 'SizeDescription');
            $table->index('grnNo', 'grnNo');
            $table->index('enabled', 'enabled');
            $table->index(['grnNo','FishSpeciesId'],'grnNo_FishSpeciesId');
            $table->index(['enabled', 'FishSpeciesId'], 'enabled_FishSpeciesId');
            $table->index(['grnNo', 'FishSpeciesId','enabled'], 'grnNo_FishSpeciesId_enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buying_grn_fish_size_matrix');
    }
};
