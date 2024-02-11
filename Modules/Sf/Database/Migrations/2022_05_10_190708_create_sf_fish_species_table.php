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
        Schema::create('sf_fish_species', function (Blueprint $table) {
            $table->id();
            $table->integer('companyId')->nullable();
            $table->string('FishCode')->nullable();
            $table->string('FishName')->nullable();
            $table->string('ScName')->nullable();
            $table->string('ShortName')->nullable();
            $table->boolean('BulkMode')->nullable();
            $table->double('QRiskLevel')->nullable();
            $table->string('default_weight_unit')->nullable();
            $table->string('average_weight')->nullable();
            $table->integer('list_index')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->string('img')->nullable();
            // $table->integer('minFishSerialNo')->nullable();
            $table->boolean('is_reef_fish')->default(false);
            $table->boolean('enabled')->default(true);
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
        Schema::dropIfExists('sf_fish_species');
    }
};
