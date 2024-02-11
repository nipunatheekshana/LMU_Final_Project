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
        Schema::create('selling_customer_order', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 20)->nullable();
            $table->foreignId('companyID')->nullable();
            $table->foreign('companyID')->references('id')->on('settings_companies')->onDelete('restrict');
            $table->string('order_status', 20)->nullable();
            $table->string('prod_status', 20)->nullable();
            $table->date('order_date')->nullable();
            $table->foreignId('customer')->nullable();
            $table->foreign('customer')->references('id')->on('selling_customers')->onDelete('restrict');
            $table->foreignId('customer_billing_address')->nullable();
            $table->foreign('customer_billing_address')->references('id')->on('crm_addresses')->onDelete('restrict');
            $table->foreignId('customer_shipping_address')->nullable();
            $table->foreign('customer_shipping_address')->references('id')->on('crm_addresses')->onDelete('restrict');
            $table->date('target_date')->nullable();
            $table->string('customer_po_no')->nullable();
            $table->string('customer_ref_no')->nullable();
            $table->decimal('total_avg_net_weight')->nullable();
            $table->decimal('total_avg_gross_weight')->nullable();
            $table->decimal('total_price')->nullable();
            $table->string('order_comments')->nullable();
            $table->boolean('is_internal_order')->default(false);
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
        Schema::dropIfExists('selling_customer_order');
    }
};
