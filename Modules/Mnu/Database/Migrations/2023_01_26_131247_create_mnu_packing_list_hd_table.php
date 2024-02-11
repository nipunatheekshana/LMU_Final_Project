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
        Schema::create('mnu_packing_list_hd', function (Blueprint $table) {
            $table->id();
            $table->string('pl_number')->nullable();
            $table->date('pl_date')->nullable();
            $table->string('order_id',30)->nullable();
            // $table->foreign('order_id')->references('id')->on('selling_customer_order')->onDelete('restrict');
            $table->string('ws_id')->nullable();
            // $table->foreignId('ws_id')->nullable();
            // $table->foreign('ws_id')->references('id')->on('mnu_ws_plan_dtl')->onDelete('restrict');
            $table->foreignId('cus_id')->nullable();
            $table->foreign('cus_id')->references('id')->on('selling_customers')->onDelete('restrict');
            $table->foreignId('consignee_id')->nullable();
            $table->foreign('consignee_id')->references('id')->on('crm_addresses')->onDelete('restrict');
            $table->string('consignee_name')->nullable();
            $table->string('consignee_add1')->nullable();
            $table->string('consignee_add2')->nullable();
            $table->string('consignee_city_towm')->nullable();
            $table->string('consignee_postal_code')->nullable();
            $table->string('consignee_country')->nullable();
            $table->string('consignee_contact_person')->nullable();
            $table->string('consignee_contact_nos')->nullable();
            $table->string('consignee_email')->nullable();
            $table->foreignId('notify_id')->nullable();
            $table->foreign('notify_id')->references('id')->on('crm_addresses')->onDelete('restrict');
            $table->string('notify_name')->nullable();
            $table->string('notify_add1')->nullable();
            $table->string('notify_add2')->nullable();
            $table->string('notify_city_towm')->nullable();
            $table->string('notify_country')->nullable();
            $table->string('notify_postal_code')->nullable();
            $table->string('notify_contact_person')->nullable();
            $table->string('notify_contact_nos')->nullable();
            $table->string('notify_email')->nullable();
            $table->date('packing_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('shipment_no')->nullable();
            $table->integer('destination_id')->nullable();
            $table->string('destination_code')->nullable();
            $table->integer('pl_status')->nullable();
            $table->boolean('is_split_pl')->nullable()->default(false);
            $table->boolean('is_invoiced')->nullable()->default(false);
            $table->integer('invoice_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->text('batch_nos_list')->nullable();
            $table->text('grn_nos_list')->nullable();
            $table->foreignId('exporter_id')->nullable();
            $table->foreign('exporter_id')->references('id')->on('crm_addresses')->onDelete('restrict');
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('crm_addresses')->onDelete('restrict');
            $table->boolean('is_locked')->nullable()->default(false);
            $table->integer('locked_by')->nullable();
            $table->integer('locked_reason_code')->nullable();
            $table->double('total_weight')->nullable();
            $table->string('total_weight_string')->nullable();
            $table->string('awb_no')->nullable();
            $table->string('flight_no')->nullable();
            $table->date('flight_date')->nullable();
            $table->integer('air_line')->nullable();
            // $table->foreign('air_line')->references('id')->on('inventory_airlines')->onDelete('restrict');
            $table->text('Remarks')->nullable();
            $table->date('export_date')->nullable();
            $table->string('eu_approval_no')->nullable();
            $table->string('production_manager')->nullable();
            $table->string('packing_qc')->nullable();
            $table->string('createdby_name')->nullable();
            $table->string('checkedby_name')->nullable();
            $table->string('authorisedby_name')->nullable();
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
        Schema::dropIfExists('mnu_packing_list_hd');
    }
};
