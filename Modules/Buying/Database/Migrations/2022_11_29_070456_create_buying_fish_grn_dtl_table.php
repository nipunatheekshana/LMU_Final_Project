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
        Schema::create('buying_fish_grn_dtl', function (Blueprint $table) {
            $table->id();
            $table->integer('lot_id')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('restrict');
            $table->foreignId('grn_id')->nullable();
            $table->foreign('grn_id')->references('id')->on('buying_fish_grn_hd')->onDelete('restrict');
            $table->foreignId('boat_id')->nullable();
            $table->foreign('boat_id')->references('id')->on('sf_boats')->onDelete('restrict');
            $table->string('lot_barcode')->nullable();
            $table->string('lot_grnno', 40)->nullable();
            $table->integer('lot_item_mode')->nullable();
            $table->integer('lot_serial_no')->nullable();
            $table->foreignId('fish_type_id')->nullable();
            $table->foreign('fish_type_id')->references('id')->on('sf_fish_species')->onDelete('restrict');
            $table->string('supplier_grade', 50)->nullable();
            $table->string('quality_grade', 50)->nullable();
            $table->foreignId('item_size_id')->nullable();
            $table->foreign('item_size_id')->references('id')->on('buying_grn_fish_size_matrix')->onDelete('cascade');
            $table->string('presentation', 50)->nullable();
            $table->integer('receive_workstation')->nullable();
            $table->foreignId('fish_selector_id')->nullable();
            $table->foreign('fish_selector_id')->references('id')->on('hrm_employees')->onDelete('restrict');
            $table->integer('receive_Pcs')->nullable();
            $table->double('scale_weight')->nullable();
            $table->double('receive_weight')->nullable();
            $table->double('dmg_weight')->nullable();
            $table->double('net_weight')->nullable();
            $table->integer('issued_pcs')->nullable();
            $table->double('issued_weight')->nullable();
            $table->integer('stock_pcs')->nullable();
            $table->double('stock_weight')->nullable();
            $table->decimal('fish_temperature')->nullable();
            $table->string('fish_comment', 50)->nullable();
            $table->integer('item_Status')->nullable();
            $table->foreignId('process_workstation')->nullable();
            $table->foreign('process_workstation')->references('id')->on('settings_workstations')->onDelete('restrict');
            $table->integer('item_process_mode')->nullable();
            $table->dateTime('process_datetime')->nullable();
            $table->foreignId('trimmer_id')->nullable();
            $table->foreign('trimmer_id')->references('id')->on('hrm_employees')->onDelete('restrict');
            $table->foreignId('trim_supervisor_id')->nullable();
            $table->foreign('trim_supervisor_id')->references('id')->on('hrm_employees')->onDelete('restrict');
            $table->foreignId('cutter_id')->nullable();
            $table->foreign('cutter_id')->references('id')->on('hrm_employees')->onDelete('restrict');
            $table->foreignId('cutting_supervisor_id')->nullable();
            $table->foreign('cutting_supervisor_id')->references('id')->on('hrm_employees')->onDelete('restrict');
            $table->integer('hold_Status')->nullable();
            $table->string('hold_Message', 100)->nullable();
            $table->dateTime('hold_datetime')->nullable();
            $table->integer('finance_status')->nullable();
            $table->integer('finance_buying_currency')->nullable();
            $table->decimal('finance_buying_currency_exch_rate')->nullable();
            $table->decimal('finance_buying_currency_unit_cost')->nullable();
            $table->decimal('finance_buying_currency_item_cost')->nullable();
            $table->integer('finance_base_currency')->nullable();
            $table->decimal('finance_base_currency_exch_rate')->nullable();
            $table->decimal('finance_base_currency_unit_cost')->nullable();
            $table->decimal('finance_base_currency_item_cost')->nullable();
            $table->decimal('finance_local_currency_unit_cost')->nullable();
            $table->decimal('finance_local_currency_item_cost')->nullable();
            $table->decimal('finance_base_currency_export_income')->nullable();
            $table->decimal('finance_local_currency_export_income')->nullable();
            $table->integer('reject_status')->nullable();
            $table->integer('reject_reason_code')->nullable();
            $table->foreignId('reject_user_id')->nullable();
            $table->foreign('reject_user_id')->references('id')->on('users')->onDelete('restrict');
            $table->dateTime('reject_datetime')->nullable();
            $table->integer('boat_tank_no')->nullable();
            $table->string('boat_tank_layer', 1)->nullable();
            $table->decimal('boat_tank_temp')->nullable();
            $table->date('catch_date')->nullable();
            $table->integer('ground_tank_id')->nullable();
            $table->string('ground_tank_layer', 4)->nullable();
            $table->foreignId('tank_in_user_id')->nullable();
            $table->foreign('tank_in_user_id')->references('id')->on('users')->onDelete('restrict');
            $table->dateTime('tank_in_datetime')->nullable();
            $table->integer('transfer_status')->nullable();
            $table->dateTime('transfer_datetime')->nullable();
            $table->integer('transfer_mode')->nullable();
            $table->foreignId('transfer_user_id')->nullable();
            $table->foreign('transfer_user_id')->references('id')->on('users')->onDelete('restrict');
            $table->integer('transfer_location_id')->nullable();
            $table->integer('ppm_set_status')->nullable();
            $table->dateTime('ppm_set_datetime')->nullable();
            $table->double('ppm_level')->nullable();
            $table->integer('quality_verify_status')->nullable();
            $table->dateTime('quality_verify_date')->nullable();
            $table->foreignId('quality_verify_userid')->nullable();
            $table->foreign('quality_verify_userid')->references('id')->on('users')->onDelete('restrict');
            $table->string('item_sample_no', 50)->nullable();
            $table->date('cut_date')->nullable();
            $table->integer('q_grn_status')->nullable();
            $table->string('q_grnno', 20)->nullable();
            $table->integer('q_fish_no')->nullable();
            $table->string('q_fish_grade', 20)->nullable();
            $table->double('q_fish_weight')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->timestamps();
            $table->foreignId('mobile_user_id')->nullable();
            $table->foreign('mobile_user_id')->references('id')->on('users')->onDelete('restrict');
            $table->json('activityLog')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buying_fish_grn_dtl');
    }
};
