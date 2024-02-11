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
        Schema::create('selling_customer_order_dtl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_number')->nullable();
            $table->foreign('order_number')->references('id')->on('selling_customer_order')->onDelete('cascade');
            $table->foreignId('notify_party')->nullable();
            $table->foreign('notify_party')->references('id')->on('crm_addresses')->onDelete('cascade');
            $table->integer('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->decimal('avg_net_weight')->nullable();
            $table->decimal('avg_gross_weight')->nullable();
            $table->decimal('unit_price')->nullable();
            $table->decimal('qty')->nullable();
            $table->decimal('total_avg_net_weight')->nullable();
            $table->decimal('total_avg_gross_weight')->nullable();
            $table->decimal('total_price')->nullable();
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
        Schema::dropIfExists('selling_customer_order_dtl');
    }
};
