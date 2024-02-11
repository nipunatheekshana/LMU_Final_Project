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
        Schema::create('mnu_production_dtl', function (Blueprint $table) {
            $table->id();
            $table->string('PcsID', 27)->nullable();
            $table->string('pcs_barcode', 27)->nullable();
            // $table->integer('grn_dtl_lot_id')->nullable(); //grn header
            $table->foreignId('grn_dtl_lot_id')->nullable();
            $table->foreign('grn_dtl_lot_id')->references('id')->on('buying_fish_grn_dtl')->onDelete('restrict');
            $table->string('lot_grn_no',20)->nullable();//grn no
            $table->string('grn_lot_barcode',20)->nullable();
            $table->string('fish_type_id',20)->nullable();
            $table->integer('lot_serial_no')->nullable();//grn detail serial no
            $table->integer('pcs_no')->nullable();
            $table->double('pcs_weight')->nullable();
            $table->double('scaler_weight')->nullable();
            $table->boolean('is_master_loin')->default(false);
            $table->string('pcs_status', 2)->nullable();
            $table->string('pcs_yield_status', 2)->nullable();
            $table->integer('previous_pcs_status')->nullable();
            $table->dateTime('status_datetime')->nullable();
            $table->boolean('is_add_to_yield')->default(false);
            $table->dateTime('production_datetime')->nullable();
            $table->integer('production_mob_id')->nullable();
            // $table->integer('production_mob_user')->nullable(); //user
            $table->foreignId('production_mob_user')->nullable();
            $table->foreign('production_mob_user')->references('id')->on('users')->onDelete('restrict');
            // $table->integer('trim_supervisor')->nullable(); //employee
            $table->foreignId('trim_supervisor')->nullable();
            $table->foreign('trim_supervisor')->references('id')->on('hrm_employees')->onDelete('restrict');
            // $table->integer('trimmer')->nullable(); //employee
            $table->foreignId('trimmer')->nullable();
            $table->foreign('trimmer')->references('id')->on('hrm_employees')->onDelete('restrict');
            $table->integer('ws_id')->nullable();
            $table->string('prb_no', 20)->nullable();
            // $table->integer('master_product_id')->nullable();//manufacturing item
            $table->foreignId('master_product_id')->nullable();
            $table->foreign('master_product_id')->references('id')->on('inventory_items')->onDelete('restrict');
            // $table->integer('cust_id')->nullable(); //customer
            $table->foreignId('cust_id')->nullable();
            $table->foreign('cust_id')->references('id')->on('selling_customers')->onDelete('restrict');
            // $table->integer('cust_product_id')->nullable(); //customer item
            $table->foreignId('cust_product_id')->nullable();
            $table->foreign('cust_product_id')->references('id')->on('mnu_customer_items')->onDelete('restrict');
            $table->dateTime('packed_datetime')->nullable();
            // $table->integer('packing_supervisor')->nullable();//employee
            $table->foreignId('packing_supervisor')->nullable();
            $table->foreign('packing_supervisor')->references('id')->on('hrm_employees')->onDelete('restrict');
            // $table->integer('packing_mob_user')->nullable(); //user
            $table->foreignId('packing_mob_user')->nullable();
            $table->foreign('packing_mob_user')->references('id')->on('users')->onDelete('restrict');
            // $table->integer('packer')->nullable();//employee
            $table->foreignId('packer')->nullable();
            $table->foreign('packer')->references('id')->on('hrm_employees')->onDelete('restrict');
            $table->integer('box_id')->nullable();
            $table->boolean('is_add_to_pl')->default(false);
            $table->string('pl_no', 20)->nullable();
            $table->integer('is_invoiced')->nullable();
            $table->integer('inv_no')->nullable();
            $table->float('unit_rate_inv')->nullable();
            $table->float('unit_rate_Inv_base_currency')->nullable();
            $table->float('unit_value_inv')->nullable();
            $table->float('unit_value_Inv_base_currency')->nullable();
            $table->boolean('reject_mode')->default(false);
            $table->integer('reject_reason_code')->nullable();
            $table->string('reject_reason_desc', 255)->nullable();
            $table->dateTime('reject_datetime')->nullable();
            // $table->integer('reject_user')->nullable(); //user
            $table->foreignId('reject_user')->nullable();
            $table->foreign('reject_user')->references('id')->on('users')->onDelete('restrict');
            // $table->integer('transfer_user')->nullable();//user
            $table->foreignId('transfer_user')->nullable();
            $table->foreign('transfer_user')->references('id')->on('users')->onDelete('restrict');
            $table->dateTime('transfer_datetime')->nullable();
            $table->integer('tranfer_to_loc')->nullable();
            $table->boolean('is_process_hold')->default(false);
            $table->integer('process_hold_reason_code')->nullable();
            $table->string('process_hold_desc')->nullable();
            $table->boolean('parent_type')->default(false);
            // $table->string('parent_pcs_id',27)->nullable();//this table
            $table->foreignId('parent_pcs_id')->nullable();
            $table->foreign('parent_pcs_id')->references('id')->on('mnu_production_dtl')->onDelete('restrict');
            $table->string('production_batch_no',20)->nullable();
            $table->integer('stock_out_st')->nullable();
            $table->dateTime('stock_out_date')->nullable();
            $table->boolean('print_status')->default(false);
            $table->float('rm_unit_cost_local')->nullable();
            $table->float('rm_unit_cost_base_currency')->nullable();
            $table->string('master_loin_id', 20)->nullable();
            $table->string('product_grade', 20)->nullable();
            $table->integer('is_frozen_product')->nullable();
            $table->string('frozen_pcs_status',2)->nullable();
            $table->dateTime('frozen_pack_datetime')->nullable();
            $table->string('frozen_box_tag',2)->nullable();
            $table->double('ppm_level')->nullable();
            $table->boolean('lock_status')->default(false);
            $table->string('qr_id',2)->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->timestamps();
            $table->json('activityLog')->nullable();


            $table->index(['grn_dtl_lot_id', 'lot_serial_no'], 'grn_dtl_lot_id_lot_serial_no');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mnu_production_dtl');
    }
};
