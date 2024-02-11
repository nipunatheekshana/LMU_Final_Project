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
        Schema::create('quality_lab_test_dtl_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testHdId')->nullable();
            $table->foreign('testHdId')->references('id')->on('quality_lab_test_hd')->restrictOnDelete();
            $table->foreignId('testTypeId')->nullable();
            $table->foreign('testTypeId')->references('id')->on('quality_lab_test_types')->restrictOnDelete();
            $table->dateTime('testDateTime')->nullable();
            $table->string('testEquipment', 25)->nullable();
            $table->foreignId('testBy')->nullable();
            $table->foreign('testBy')->references('id')->on('hrm_employees')->restrictOnDelete();
            $table->foreignId('verifiedBy')->nullable();
            $table->foreign('verifiedBy')->references('id')->on('hrm_employees')->restrictOnDelete();
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
        Schema::dropIfExists('quality_lab_test_dtl_types');
    }
};
