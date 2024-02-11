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
        Schema::create('quality_lab_test_dtl_compositions', function (Blueprint $table) {
            $table->id();
            $table->string('sam_no');
            $table->foreignId('testHdId');
            $table->foreign('testHdId')->references('id')->on('quality_lab_test_hd')->restrictOnDelete();
            $table->string('samType', 15);
            $table->foreignId('fish_type_id');
            $table->foreign('fish_type_id')->references('id')->on('sf_fish_species')->restrictOnDelete();
            $table->string('remarks');


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
        Schema::dropIfExists('quality_lab_test_dtl_compositions');
    }
};
