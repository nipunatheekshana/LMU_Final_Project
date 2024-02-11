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
        Schema::create('quality_lab_test_dtl_compositions_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compHdId');
            $table->foreign('compHdId')->references('id')->on('quality_lab_test_dtl_compositions')->restrictOnDelete();
            $table->foreignId('testTypeId');
            $table->foreign('testTypeId')->references('id')->on('quality_lab_test_types')->restrictOnDelete();
            $table->foreignId('testDtlTypeId');
            $table->foreign('testDtlTypeId')->references('id')->on('quality_lab_test_dtl_types')->restrictOnDelete();
            $table->float('testResultValue', 9, 3);
            $table->boolean('isResultsSet')->default(FALSE);
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
        Schema::dropIfExists('quality_lab_test_dtl_compositions_results');
    }
};
