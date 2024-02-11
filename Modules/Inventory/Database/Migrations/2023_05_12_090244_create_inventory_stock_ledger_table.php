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
        Schema::create('inventory_stock_ledger', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->foreignId('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->foreignId('warehouse')->nullable();
            $table->foreign('warehouse')->references('id')->on('inventory_warehouse')->onDelete('cascade');
            $table->string('serial_no', 140)->nullable();
            $table->string('batch_no', 140)->nullable();
            $table->string('voucher_type', 140)->nullable();
            $table->string('voucher_id', 140)->nullable();
            $table->string('voucher_detail_id', 140)->nullable();
            $table->float('actual_qty')->nullable();
            $table->float('qty_after_transaction')->nullable();
            $table->float('actual_weight')->nullable();
            $table->float('weight_after_transaction')->nullable();
            $table->float('valuation_rate')->nullable();
            $table->integer('valuation_based_on')->nullable();
            $table->float('stock_value')->nullable();
            $table->float('stock_value_difference')->nullable();
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
        Schema::dropIfExists('inventory_stock_ledger');
    }
};
