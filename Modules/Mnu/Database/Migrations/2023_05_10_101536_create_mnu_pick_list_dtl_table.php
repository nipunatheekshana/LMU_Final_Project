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
        Schema::create('mnu_pick_list_dtl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pick_list_hd_id')->nullable();
            $table->foreign('pick_list_hd_id')->references('id')->on('mnu_pick_list_hd')->onDelete('cascade');
            $table->string('barcode_serial_no')->nullable();
            $table->foreignId('box_id')->nullable();
            $table->foreign('box_id')->references('id')->on('mnu_packing_box_hd')->onDelete('cascade');
            $table->string('batch_no')->nullable();
            $table->string('warehouse')->nullable();
            $table->foreignId('workstation')->nullable();
            $table->foreign('workstation')->references('id')->on('settings_workstations')->onDelete('restrict');
            $table->foreignId('item')->nullable();
            $table->foreign('item')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->foreignId('customer_item')->nullable();
            $table->foreign('customer_item')->references('id')->on('mnu_customer_items')->onDelete('cascade');
            $table->float('picked_qty')->nullable();
            $table->integer('uom')->nullable();
            $table->float('stock_qty')->nullable();
            $table->integer('stock_uom')->nullable();
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
        Schema::dropIfExists('mnu_pick_list_dtl');
    }
};
