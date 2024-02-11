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
        Schema::table('sf_fish_grades', function (Blueprint $table) {
            $table->foreignId('fish_species')->nullable();
            $table->foreign('fish_species')->references('id')->on('sf_fish_species')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sf_fish_grades', function (Blueprint $table) {
            $table->foreignId('fish_species')->nullable();
        });
    }
};
