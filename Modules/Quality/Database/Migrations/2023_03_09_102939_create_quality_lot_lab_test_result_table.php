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
        Schema::create('quality_lot_lab_test_result', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grnDtlId');
            $table->foreign('grnDtlId')->references('id')->on('buying_fish_grn_dtl')->restrictOnDelete();
            $table->foreignId('labTestId');
            $table->foreign('labTestId')->references('id')->on('quality_lab_test_hd')->restrictOnDelete();
            $table->string('labTestNo', 25);
            $table->foreignId('labTestDtlCompId');
            $table->foreign('labTestDtlCompId')->references('id')->on('quality_lab_test_dtl_compositions')->restrictOnDelete();
            $table->dateTime('labTestDateTime');
            $table->foreignId('testTypeId');
            $table->foreign('testTypeId')->references('id')->on('quality_lab_test_types')->restrictOnDelete();
            $table->string('testTypeName', 25);
            $table->float('resultValue', 9, 3);
            $table->float('alertThreshold', 9, 3);
            $table->float('lockThreshold', 9, 3);
            $table->boolean('isAutoLock')->default(TRUE);
            $table->dateTime('resultUpdatedAt');
            $table->foreignId('resultUpdatedBy');
            $table->foreign('resultUpdatedBy')->references('id')->on('users')->restrictOnDelete();
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
        Schema::dropIfExists('quality_lot_lab_test_result');
    }
};
