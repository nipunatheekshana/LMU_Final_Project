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
        Schema::create('inventory_item_barcodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item')->nullable();
            $table->foreign('item')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->string('barcode')->unique();
            $table->foreignId('barcode_type')->nullable();
            $table->foreign('barcode_type')->references('id')->on('settings_barcode_types')->onDelete('cascade');
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
        Schema::dropIfExists('inventory_item_barcodes');
    }
};
