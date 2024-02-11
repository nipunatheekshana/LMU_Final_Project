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
        Schema::create('inventory_bin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_code')->nullable();
            $table->foreign('item_code')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->foreignId('warehouse')->nullable();
            $table->foreign('warehouse')->references('id')->on('inventory_warehouse')->onDelete('cascade');
            $table->float('actual_qty')->nullable();
            $table->float('reserved_qty')->nullable();
            $table->float('ordered_qty')->nullable();
            $table->float('indented_qty')->nullable();
            $table->float('planned_qty')->nullable();
            $table->float('projected_qty')->nullable();
            $table->float('reserved_qty_for_production')->nullable();
            $table->float('reserved_qty_for_sub_contract')->nullable();
            $table->foreignId('stock_uom')->nullable();
            $table->foreign('stock_uom')->references('id')->on('inventory_uom')->onDelete('cascade');
            $table->float('valuation_rate')->nullable();
            $table->float('stock_value')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
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
        Schema::dropIfExists('inventory_bin');

    }
};
