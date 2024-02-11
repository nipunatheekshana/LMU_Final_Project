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
            $table->foreignId('ProductPresentation')->nullable();
            $table->foreign('ProductPresentation')->references('id')->on('sf_presentation_type')->onDelete('restrict');
            $table->foreignId('ProductCutType')->nullable();
            $table->foreign('ProductCutType')->references('id')->on('sf_cutting_type')->onDelete('restrict');
            $table->string('ProductQuality')->nullable();
            $table->string('ProductSpec')->nullable();


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
            $table->foreignId('ProductPresentation')->nullable();
            $table->foreignId('ProductCutType')->nullable();
            $table->string('ProductQuality')->nullable();
            $table->string('ProductSpec')->nullable();


        });
    }
};
