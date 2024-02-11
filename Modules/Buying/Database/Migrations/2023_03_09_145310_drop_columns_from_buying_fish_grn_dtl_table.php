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
        Schema::table('buying_fish_grn_dtl', function (Blueprint $table) {
            $table->dropColumn('ppm_set_status');
            $table->dropColumn('ppm_set_datetime');
            $table->dropColumn('ppm_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buying_fish_grn_dtl', function (Blueprint $table) {
            $table->integer('ppm_set_status')->nullable();
            $table->dateTime('ppm_set_datetime')->nullable();
            $table->double('ppm_level')->nullable();
        });
    }
};
