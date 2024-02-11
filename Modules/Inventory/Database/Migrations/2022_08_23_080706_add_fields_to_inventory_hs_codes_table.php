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
        Schema::table('inventory_hs_codes', function (Blueprint $table) {
            $table->foreignId('country')->nullable();
            $table->foreign('country')->references('id')->on('settings_countries')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_hs_codes', function (Blueprint $table) {
            $table->foreignId('country')->nullable();

        });
    }
};
