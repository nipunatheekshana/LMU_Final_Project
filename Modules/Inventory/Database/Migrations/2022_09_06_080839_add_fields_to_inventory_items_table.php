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
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->foreignId('process')->nullable();
            $table->foreign('process')->references('id')->on('settings_processes')->onDelete('restrict');
            $table->foreignId('work_station')->nullable();
            $table->foreign('work_station')->references('id')->on('settings_workstations')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
   $table->foreignId('process')->nullable();
            $table->foreign('process')->references('id')->on('settings_processes')->onDelete('restrict');
            $table->foreignId('work_station')->nullable();
            $table->foreign('work_station')->references('id')->on('settings_workstations')->onDelete('restrict');
        });
    }
};
