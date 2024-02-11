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
        Schema::create('mnu_ws_plan_dtl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('plID')->nullable();
            $table->string('mainPlID')->nullable();
            $table->foreignId('rqDtlID')->nullable();
            $table->foreign('rqDtlID')->references('id')->on('mnu_requirements_dtl')->onDelete('cascade');
            $table->date('plDate')->nullable();
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
            $table->double('plannedQty');
            $table->double('plannedWeight');
            $table->double('completedQty')->default(0);
            $table->double('completedWeight')->default(0);
            $table->double('suspendedQty')->default(0);
            $table->double('suspendedWeight')->default(0);
            $table->double('effectiveQty')->default(0);
            $table->double('effectiveWeight')->default(0);
            $table->double('remainingQty')->default(0);
            $table->double('remainingWeight')->default(0);
            $table->date('mnfDate')->nullable();
            $table->date('expDate')->nullable();
            $table->foreignId('process')->nullable();
            $table->foreign('process')->references('id')->on('settings_processes')->onDelete('restrict');
            $table->foreignId('work_station')->nullable();
            $table->foreign('work_station')->references('id')->on('settings_workstations')->onDelete('restrict');
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->boolean('is_mob_active_list')->default(false);

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
        Schema::dropIfExists('mnu_ws_plan_dtl');
    }
};
