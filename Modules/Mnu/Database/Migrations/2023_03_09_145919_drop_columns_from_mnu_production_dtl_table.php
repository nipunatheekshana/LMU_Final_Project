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
        Schema::table('mnu_production_dtl', function (Blueprint $table) {
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
        Schema::table('mnu_production_dtl', function (Blueprint $table) {
            $table->double('ppm_level')->nullable();
        });
    }
};
