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
        Schema::create('buying_fish_qgrn_hd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->integer('qgrn_no')->nullable();
            $table->date('qgrn_date')->nullable();
            $table->integer('qgrn_type')->nullable();
            $table->integer('batch_no')->nullable();
            $table->foreignId('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('buying_suppliers')->onDelete('cascade');
            $table->foreignId('supplier_ticket_id')->nullable();
            $table->foreign('supplier_ticket_id')->references('id')->on('buying_grn_ticket_hd')->onDelete('cascade');
            $table->string('supplier_vehicle_no')->nullable();
            $table->foreignId('boat_id')->nullable();
            $table->foreign('boat_id')->references('id')->on('buying_grn_ticket_hd')->onDelete('cascade');
            $table->string('boat_registration_number')->nullable();
            $table->string('boat_licence_no')->nullable();
            $table->date('boat_licence_exp_date')->nullable();
            $table->string('boat_skipper_name')->nullable();
            $table->integer('boat_number_of_crew')->nullable();
            $table->string('boat_number_of_tanks')->nullable();
            $table->date('boat_trip_start_date')->nullable();
            $table->date('boat_trip_end_date')->nullable();
            $table->foreignId('boat_cooling_method')->nullable();
            $table->foreign('boat_cooling_method')->references('id')->on('sf_fish_cooling_methods')->onDelete('cascade');
            $table->foreignId('boat_fishing_method_id')->nullable();
            $table->foreign('boat_fishing_method_id')->references('id')->on('sf_catch_method')->onDelete('cascade');
            $table->foreignId('boat_landing_site_id')->nullable();
            $table->foreign('boat_landing_site_id')->references('id')->on('sf_landingsite')->onDelete('cascade');
            $table->integer('unload_status')->nullable();
            $table->datetime('unload_start_time')->nullable();
            $table->datetime('unload_end_time')->nullable();
            $table->foreignId('unload_end_user_id')->nullable();
            $table->foreign('unload_end_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('finance_status')->nullable();
            $table->integer('voucher_status')->nullable();
            $table->datetime('finance_close_time')->nullable();
            $table->foreignId('finance_close_user_id')->nullable();
            $table->foreign('finance_close_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('finance_currency_id_pay')->nullable();
            $table->foreign('finance_currency_id_pay')->references('id')->on('settings_currencies')->onDelete('cascade');
            $table->integer('finance_gross_value_pay')->nullable();
            $table->foreignId('finance_currency_id_base')->nullable();
            $table->foreign('finance_currency_id_base')->references('id')->on('settings_currencies')->onDelete('cascade');
            $table->integer('finance_gross_value_base')->nullable();
            $table->double('costing_export_income')->nullable();
            $table->double('costing_localsale_income')->nullable();
            $table->decimal('total_qty')->nullable();
            $table->decimal('total_fish_weight')->nullable();
            $table->decimal('unprocessed_pcs')->nullable();
            $table->decimal('processed_pcs')->nullable();
            $table->decimal('transfer_pcs')->nullable();
            $table->decimal('reject_pcs')->nullable();
            $table->string('receive_hold_reason')->nullable();
            $table->string('finance_close_reason')->nullable();
            $table->string('voucher_close_reason')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('buying_fish_qgrn_hd');

    }
};
