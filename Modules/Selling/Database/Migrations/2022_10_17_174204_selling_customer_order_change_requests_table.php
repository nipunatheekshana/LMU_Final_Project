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
        Schema::create('selling_customer_order_change_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('selling_customers')->onDelete('cascade');
            $table->foreignId('notify_party')->nullable();
            $table->foreign('notify_party')->references('id')->on('crm_addresses')->onDelete('cascade');
            $table->foreignId('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->decimal('old_qty')->nullable();
            $table->decimal('new_qty')->nullable();
            $table->decimal('old_price')->nullable();
            $table->decimal('new_price')->nullable();
            $table->integer('status')->nullable();
            $table->integer('change_request_type')->nullable();
            $table->boolean('price_changed')->default(false);
            $table->string('customer_comment')->nullable();
            $table->string('approver_comment')->nullable();
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
        Schema::dropIfExists('selling_customer_order_change_requests');

    }
};
