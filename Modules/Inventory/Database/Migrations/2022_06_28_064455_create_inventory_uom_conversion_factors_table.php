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
        Schema::create('inventory_uom_conversion_factors', function (Blueprint $table) {
            $table->id();
            $table->string('uom_category')->nullable();
            $table->foreignId('uom_from')->nullable();
            $table->foreign('uom_from')->references('id')->on('inventory_uom')->onDelete('cascade');
            $table->foreignId('uom_to')->nullable();
            $table->foreign('uom_to')->references('id')->on('inventory_uom')->onDelete('cascade');
            $table->decimal('factor')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_uom_conversion_factors');
    }
};
