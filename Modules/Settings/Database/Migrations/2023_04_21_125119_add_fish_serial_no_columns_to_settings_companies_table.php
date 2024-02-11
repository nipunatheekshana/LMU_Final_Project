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
        Schema::table('settings_companies', function (Blueprint $table) {
            $table->bigInteger('currentFishSerialNo')->default(0);
            $table->bigInteger('minFishSerialNo')->default(1);
            $table->bigInteger('maxFishSerialNo')->default(1000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings_companies', function (Blueprint $table) {
            $table->dropColumn('currentFishSerialNo');
            $table->dropColumn('minFishSerialNo');
            $table->dropColumn('maxFishSerialNo');
        });
    }
};
