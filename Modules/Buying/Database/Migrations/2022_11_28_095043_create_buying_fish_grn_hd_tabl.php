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

        Schema::create('buying_fish_grn_hd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('restrict');
            $table->string('grnno', 40)->nullable()->unique();
            $table->date('grndate')->nullable();
            $table->integer('grn_type')->nullable();
            $table->foreignId('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('buying_suppliers')->onDelete('cascade');
            $table->integer('supplier_ticket_id')->nullable();
            $table->string('supplier_vehicle_no', 45)->nullable();
            $table->foreignId('boat_id')->nullable();
            $table->foreign('boat_id')->references('id')->on('sf_boats')->onDelete('cascade');
            $table->string('boat_registration_number', 45)->nullable();
            $table->string('boat_licence_no', 45)->nullable();
            $table->date('boat_licence_exp_date')->nullable();
            $table->string('boat_skipper_name', 300)->nullable();
            $table->integer('boat_number_of_crew')->nullable();
            $table->string('boat_number_of_tanks', 45)->nullable();
            $table->date('boat_trip_start_date')->nullable();
            $table->date('boat_trip_end_date')->nullable();
            $table->foreignId('boat_cooling_method')->nullable();
            $table->foreign('boat_cooling_method')->references('id')->on('sf_fish_cooling_methods')->onDelete('cascade');
            $table->foreignId('boat_fishing_method_id')->nullable();
            $table->foreign('boat_fishing_method_id')->references('id')->on('sf_catch_method')->onDelete('cascade');
            $table->foreignId('boat_landing_site_id')->nullable();
            $table->foreign('boat_landing_site_id')->references('id')->on('sf_landingsite')->onDelete('cascade');
            $table->integer('unload_status')->nullable();
            $table->dateTime('unload_start_time')->nullable();
            $table->dateTime('unload_end_time')->nullable();
            $table->foreignId('unload_end_user_id')->nullable();
            $table->foreign('unload_end_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('finance_status')->nullable();
            $table->integer('voucher_status')->nullable();
            $table->dateTime('finance_close_time')->nullable();
            $table->foreignId('finance_close_user_id')->nullable();
            $table->foreign('finance_close_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('finance_currency_id_pay')->nullable();
            $table->foreign('finance_currency_id_pay')->references('id')->on('settings_currencies')->onDelete('cascade');
            $table->integer('finance_gross_value_pay')->nullable();
            $table->foreignId('finance_currency_id_base')->nullable();
            $table->foreign('finance_currency_id_base')->references('id')->on('settings_currencies')->onDelete('cascade');
            $table->integer('finance_gross_value_base')->nullable();
            $table->float('costing_export_income')->nullable();
            $table->float('costing_localsale_income')->nullable();
            $table->dateTime('create_date_time')->nullable();
            $table->foreignId('create_user_id')->nullable();
            $table->foreign('create_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('totalQty')->nullable();
            $table->decimal('unprocessedPCs')->nullable();
            $table->decimal('processedPcs')->nullable();
            $table->decimal('transferPcs')->nullable();
            $table->decimal('rejectPcs')->nullable();
            $table->string('resive_hold_reason')->nullable();
            $table->string('finance_close_reason')->nullable();
            $table->string('voucher_close_reason')->nullable();
            $table->decimal('totFishWeight')->nullable();
            $table->integer('batch_no')->nullable();
            $table->timestamps();

            //    index
            $table->index('grnno', 'grnno');
            $table->index('boat_id', 'boat_id');
            $table->index('supplier_id', 'supplier_id');
            $table->index('boat_registration_number', 'boat_registration_number');
            $table->index('grn_type', 'grn_type');
            $table->index('grndate', 'grndate');
            $table->index(['grndate', 'grn_type'], 'grndate_grn_type');
            $table->index(['grndate', 'boat_registration_number'], 'grndate_boat_registration_number');
            $table->index(['grndate', 'supplier_id'], 'grndate_supplier_id');
            $table->index(['grn_type', 'boat_registration_number'], 'grn_type_boat_registration_number');
            $table->index(['grn_type', 'supplier_id'], 'grn_type_supplier_id');
            $table->index(['boat_registration_number', 'supplier_id'], 'boat_registration_number_supplier_id');
            $table->index(['grndate', 'grn_type', 'boat_registration_number'], 'grndate_grn_type_boat_registration_number');
            $table->index(['grndate', 'grn_type', 'supplier_id'], 'grndate_grn_type_supplier_id');
            $table->index(['grn_type', 'boat_registration_number', 'supplier_id'], 'grn_type_boat_registration_number_supplier_id');
            $table->index(['boat_registration_number', 'grndate', 'supplier_id'], 'boat_registration_number_grndate_supplier_id');
            $table->index(['boat_registration_number', 'grndate', 'supplier_id', 'grn_type'], 'boat_registration_number_grndate_supplier_id_grn_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buying_fish_grn_hd');
    }
};
