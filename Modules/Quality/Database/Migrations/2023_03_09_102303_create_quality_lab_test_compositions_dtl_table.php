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
        Schema::create('quality_lab_test_compositions_dtl', function (Blueprint $table) {
            $table->id();
            $table->integer('compHdId')->nullable();
            $table->foreignId('grnDtlId')->nullable();
            $table->foreign('grnDtlId')->references('id')->on('buying_fish_grn_dtl')->nullOnDelete();
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
        Schema::dropIfExists('quality_lab_test_compositions_dtl');
    }
};
