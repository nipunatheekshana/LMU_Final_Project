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
        Schema::create('mnu_ws_plan_change_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->foreignId('order_change_rq_id')->nullable();
            $table->foreign('order_change_rq_id')->references('id')->on('selling_customer_order_change_requests')->onDelete('cascade');
            $table->foreignId('ws_plan_id')->nullable();
            $table->foreign('ws_plan_id')->references('id')->on('mnu_ws_plan_dtl')->onDelete('cascade');
            $table->foreignId('rq_id')->nullable();
            $table->foreign('rq_id')->references('id')->on('mnu_requirements_dtl')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('selling_customers')->onDelete('cascade');
            $table->foreignId('notify_party')->nullable();
            $table->foreign('notify_party')->references('id')->on('crm_addresses')->onDelete('cascade');
            $table->foreignId('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->decimal('old_qty')->nullable();
            $table->decimal('new_qty')->nullable();
            $table->integer('status')->nullable();
            $table->string('order_change_approver_comment',150)->nullable();
            $table->string('ws_change_approver_comment',150)->nullable();
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
        Schema::dropIfExists('mnu_ws_plan_change_requests');
    }
};
