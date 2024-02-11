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
        Schema::create('accounting_invoice_header', function (Blueprint $table) {
            $table->id();
            $table->string('inv_no',50)->nullable();
            $table->date('inv_date')->nullable();
            $table->integer('order_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('cus_po_number',100)->nullable();
            $table->string('awb_no',50)->nullable();
            $table->string('inv_comment')->nullable();
            $table->integer('pl_id')->nullable();
            $table->integer('inv_status')->nullable();
            $table->integer('currency_id')->nullable();
            $table->float('exchange_rate')->nullable();
            $table->date('flight_date')->nullable();
            $table->string('flight_numbers',150)->nullable();
            $table->string('consignee_name')->nullable();
            $table->string('consignee_add_line1')->nullable();
            $table->string('consignee_add_line2')->nullable();
            $table->string('consignee_add_line3')->nullable();
            $table->string('consignee_add_line4')->nullable();
            $table->string('consignee_add_line5')->nullable();
            $table->string('notify_name')->nullable();
            $table->string('notify_address_line1')->nullable();
            $table->string('notify_address_line2')->nullable();
            $table->string('notify_address_line3')->nullable();
            $table->string('notify_address_line4')->nullable();
            $table->string('notify_address_line5')->nullable();
            $table->string('sales_contact_person')->nullable();
            $table->string('sales_contact_number')->nullable();
            $table->string('shipment_number',100)->nullable();
            $table->string('destination',150)->nullable();
            $table->string('destination_port',100)->nullable();
            $table->string('inv_term',5)->nullable();
            $table->float('inv_gross_value')->nullable();
            $table->double('net_weight_kg')->nullable();
            $table->integer('freight_rate')->nullable();
            $table->string('freight_rate_type')->nullable();
            $table->float('freight_rate_kg')->nullable();
            $table->float('freight_rate_lbs')->nullable();
            $table->float('freight_value')->nullable();
            $table->double('net_weight_lbs')->nullable();
            $table->string('discount_type')->nullable();
            $table->float('discount_rate')->nullable();
            $table->float('discount_amount')->nullable();
            $table->float('net_value')->nullable();
            $table->string('payment_term')->nullable();
            $table->boolean('is_no_bank_details')->default(false);
            // $table->integer('bank_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->integer('bank_account_id')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number',100)->nullable();
            $table->string('swift_code')->nullable();
            $table->string('corresponding_bank')->nullable();
            $table->string('nature_of_product')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->string('list_of_batch_nos')->nullable();
            $table->string('list_of_gen_nos')->nullable();
            $table->string('fao_zone',50)->nullable();
            $table->string('fda_number',50)->nullable();
            $table->string('eu_text')->nullable();
            $table->float('tot_freight_value')->nullable();
            $table->float('tot_handling_charges')->nullable();
            $table->decimal('tot_other_cost')->nullable();
            $table->decimal('tot_rm_cost')->nullable();
            $table->decimal('tot_pm_cost')->nullable();
            $table->boolean('is_processed')->default(false);
            $table->dateTime('processed_date_time')->nullable();
            $table->integer('processed_user_id')->nullable();
            $table->boolean('is_posted')->default(false);
            $table->dateTime('posted_date_time')->nullable();
            $table->integer('poster_user_id')->nullable();
            $table->boolean('is_printed')->default(false);
            $table->boolean('is_disburment_processed')->default(false);
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
        Schema::dropIfExists('accounting_invoice_header');
    }
};
