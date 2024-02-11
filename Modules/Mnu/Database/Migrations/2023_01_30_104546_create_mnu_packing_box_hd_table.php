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
        Schema::create('mnu_packing_box_hd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ws_id')->nullable();
            $table->foreign('ws_id')->references('id')->on('mnu_ws_plan_dtl')->onDelete('restrict');
            $table->integer('box_no')->nullable();
            $table->foreignId('prod_id')->nullable();
            $table->foreign('prod_id')->references('id')->on('inventory_items')->onDelete('restrict');
            $table->integer('container_id')->nullable();
            $table->integer('pln_id')->nullable();
            $table->integer('noofpcs')->nullable();
            $table->double('box_gross_weight')->nullable();
            $table->double('box_net_weight')->nullable();
            $table->integer('box_status')->nullable();
            $table->boolean('is_mix_box')->default(false);
            $table->boolean('is_wr_box')->default(false);
            $table->boolean('is_manual_box')->default(false);
            $table->boolean('is_add_to_gpl')->default(false);
            $table->string('gpl_no')->nullable();
            $table->foreignId('ext_pl_id')->nullable();
            $table->foreign('ext_pl_id')->references('id')->on('mnu_ext_packing_list_hd')->nullOnDelete();
            $table->boolean('is_add_to_pl')->default(false);
            $table->foreignId('pl_id')->nullable();
            $table->foreign('pl_id')->references('id')->on('mnu_packing_list_hd')->nullOnDelete();
            $table->boolean('is_invoiced')->default(false);
            $table->integer('inv_id')->nullable();
            $table->string('box_barcode')->nullable();
            $table->string('box_comment')->nullable();
            $table->boolean('is_loaded')->default(false);
            $table->dateTime('loaded_datetime')->nullable();
            $table->foreignId('loaded_user_id')->nullable();
            $table->foreign('loaded_user_id')->references('id')->on('users')->onDelete('restrict');
            $table->float('unit_rate_local')->nullable();
            $table->float('unit_rate_invoice_currency')->default(0);
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->integer('delivery_trip_id')->nullable();
            $table->integer('delivery_note_id')->nullable();
            $table->json('activityLog')->nullable();
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
        Schema::dropIfExists('mnu_packing_box_hd');
    }
};
