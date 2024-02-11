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
        Schema::table('quality_lab_test_dtl_compositions', function (Blueprint $table) {
            $table->dropForeign('quality_lab_test_dtl_compositions_testhdid_foreign');
            $table->dropColumn('testHdId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quality_lab_test_dtl_compositions', function (Blueprint $table) {
            $table->foreignId('testHdId');
            $table->foreign('testHdId')->references('id')->on('quality_lab_test_hd')->restrictOnDelete();
        });

    }
};
