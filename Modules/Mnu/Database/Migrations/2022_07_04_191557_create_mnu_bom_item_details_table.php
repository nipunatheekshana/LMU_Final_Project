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
        Schema::create('mnu_bom_item_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->foreignId('bom_item_id');
            $table->foreign('bom_item_id')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->foreignId('item_id');
            $table->foreign('item_id')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->integer('qty')->nullable();
            $table->foreignId('uom')->nullable();
            $table->foreign('uom')->references('id')->on('inventory_uom')->onDelete('restrict');
            $table->string('unit_net_weight')->nullable();
            $table->string('unit_gross_weight')->nullable();
            $table->string('total_net_weight')->nullable();
            $table->string('total_gross_weight')->nullable();
            $table->foreignId('weight_uom')->nullable();
            $table->foreign('weight_uom')->references('id')->on('inventory_uom')->onDelete('restrict');
            $table->boolean('is_main_item')->default(false);
            $table->boolean('is_container_item')->default(false);
            $table->boolean('is_label_item')->default(false);
            $table->boolean('is_other_pm_item')->default(false);
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
        Schema::dropIfExists('mnu_bom_item_details');
    }
};
