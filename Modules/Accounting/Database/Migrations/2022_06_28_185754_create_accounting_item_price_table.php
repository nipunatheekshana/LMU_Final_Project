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
        Schema::create('accounting_item_price', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item')->nullable();
            $table->foreign('item')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->foreignId('price_list')->nullable();
            $table->foreign('price_list')->references('id')->on('accounting_price_list')->onDelete('cascade');
            $table->foreignId('uom')->nullable();
            $table->foreign('uom')->references('id')->on('inventory_uom')->onDelete('cascade');
            $table->decimal('price')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->integer('list_index')->nullable();
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
        Schema::dropIfExists('accounting_item_price');
    }
};
