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
        Schema::table('quality_lab_test_types', function (Blueprint $table) {
            $table->float('commonRangeLow', 8, 3)->nullable()->change();
            $table->float('commonRangeHigh', 8, 3)->nullable()->change();
            $table->float('testCost', 9, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quality_lab_test_types', function (Blueprint $table) {
            $table->float('commonRangeLow', 8, 3)->change();
            $table->float('commonRangeHigh', 8, 3)->change();
            $table->float('testCost', 9, 2)->change();
        });
    }
};
