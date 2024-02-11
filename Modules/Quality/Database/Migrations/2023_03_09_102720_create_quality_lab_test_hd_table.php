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
        Schema::create('quality_lab_test_hd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companyId');
            $table->foreign('companyId')->references('id')->on('settings_companies')->restrictOnDelete();
            $table->string('labTestNo', 15);
            $table->date('testDate');
            $table->longText('testDescription');
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
        Schema::dropIfExists('quality_lab_test_hd');
    }
};
