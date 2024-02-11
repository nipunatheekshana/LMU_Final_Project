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
        Schema::create('quality_lab_test_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companyId');
            $table->foreign('companyId')->references('id')->on('settings_companies')->restrictOnDelete();
            $table->string('testTypeCode', 25)->nullable();
            $table->string('testTypeName', 25);
            $table->string('testTypeDescription', 25)->nullable();
            $table->float('commonRangeLow', 8, 3);
            $table->float('commonRangeHigh', 8, 3);
            $table->float('testCost', 9, 2);
            $table->foreignId('testCostCurrency');
            $table->foreign('testCostCurrency')->references('id')->on('settings_currencies')->restrictOnDelete();
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
        Schema::dropIfExists('quality_lab_test_types');
    }
};
