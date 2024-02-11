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
        Schema::create('mnu_requirements_dtl_plan', function (Blueprint $table) {
            $table->id();
            $table->string('rqID')->nullable();
            $table->string('plID')->nullable();
            $table->date('rqDate')->nullable();
            $table->integer('planStatus')->nullable();
            $table->integer('prodStatus')->nullable();
            $table->foreignId('item')->nullable();
            $table->foreign('item')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->string('itemCode')->nullable();
            $table->string('itemName')->nullable();
            $table->string('refType')->nullable();
            $table->string('refNo')->nullable();
            $table->foreignId('customer')->nullable();
            $table->foreign('customer')->references('id')->on('selling_customers')->onDelete('cascade');
            $table->foreignId('notify')->nullable();
            $table->foreign('notify')->references('id')->on('crm_addresses')->onDelete('cascade');
            $table->double('rqQty');
            $table->double('rqWeight');
           
            $table->date('mnfDate')->nullable();
            $table->date('expDate')->nullable();
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
        Schema::dropIfExists('mnu_requirements_dtl_plan');
    }
};
