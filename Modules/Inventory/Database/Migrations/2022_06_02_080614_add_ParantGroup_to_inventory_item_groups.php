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
        Schema::table('inventory_item_groups', function (Blueprint $table) {
            $table->foreignId('ParantGroup')->nullable();
            $table->foreign('ParantGroup')->references('id')->on('inventory_item_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_item_groups', function (Blueprint $table) {
            $table->foreignId('ParantGroup')->nullable();

        });
    }
};
