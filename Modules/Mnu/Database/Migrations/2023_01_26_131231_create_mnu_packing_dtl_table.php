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
        Schema::create('mnu_packing_dtl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pcs_id')->nullable();
            $table->foreign('pcs_id')->references('id')->on('mnu_production_dtl')->onDelete('restrict');
            $table->foreignId('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('selling_customer_order')->onDelete('restrict');
            $table->foreignId('ws_id')->nullable();
            $table->foreign('ws_id')->references('id')->on('mnu_ws_plan_dtl')->onDelete('restrict');
            $table->integer('pln_id')->nullable();
            $table->dateTime('packed_datetime')->nullable();
            $table->integer('packed_mob_used_id')->nullable();
            $table->foreignId('packer_id')->nullable();
            $table->foreign('packer_id')->references('id')->on('mnu_ws_plan_dtl')->onDelete('restrict');
            $table->foreignId('lifter_id')->nullable();
            $table->foreign('lifter_id')->references('id')->on('mnu_ws_plan_dtl')->onDelete('restrict');
            $table->foreignId('qc_id')->nullable();
            $table->foreign('qc_id')->references('id')->on('hrm_employees')->onDelete('restrict');
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
        Schema::dropIfExists('mnu_packing_dtl');
    }
};
