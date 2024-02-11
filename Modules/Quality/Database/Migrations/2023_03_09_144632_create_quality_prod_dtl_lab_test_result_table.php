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
        Schema::create('quality_prod_dtl_lab_test_result', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodDtlId');
            $table->foreign('prodDtlId')->references('id')->on('mnu_production_dtl')->restrictOnDelete();
            $table->integer('labTestId')->nullable();
            $table->string('labTestNo', 25);
            $table->integer('labTestDtlCompId')->nullable();
            $table->dateTime('labTestDateTime');
            $table->foreignId('testTypeId');
            $table->foreign('testTypeId')->references('id')->on('quality_lab_test_types')->restrictOnDelete();
            $table->string('testTypeName', 25);
            $table->float('resultValue', 9, 3);
            $table->float('alertThreshold', 9, 3);
            $table->float('lockThreshold', 9, 3);
            $table->boolean('isAutoLock')->default(TRUE);
            $table->dateTime('resultUpdatedAt');
            $table->foreignId('resultUpdatedBy')->nullable();
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
        Schema::dropIfExists('quality_prod_dtl_lab_test_result');
    }
};
