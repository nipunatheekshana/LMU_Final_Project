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
        Schema::create('buying_fish_grn_dtl_pay_rate', function (Blueprint $table) {
            $table->id();
            $table->string('rm_cost_id')->nullable();
            // $table->foreignId('lot_grnno')->nullable();
            $table->integer('lot_grnno');
            $table->foreignId('fish_type_id')->nullable();
            $table->foreign('fish_type_id')->references('id')->on('sf_fish_species')->onDelete('restrict');
            $table->string('pay_grade')->nullable();
            $table->foreignId('item_size')->nullable();
            $table->foreign('item_size')->references('id')->on('buying_grn_fish_size_matrix')->onDelete('restrict');
            $table->string('rm_presentation')->nullable();
            $table->decimal('rm_qty')->nullable();
            $table->decimal('rm_tot_weight')->nullable();
            $table->foreignId('rm_uom')->nullable();
            $table->foreign('rm_uom')->references('id')->on('inventory_uom')->onDelete('restrict');
            $table->foreignId('rm_pay_currency')->nullable();
            $table->foreign('rm_pay_currency')->references('id')->on('settings_currencies')->onDelete('restrict');
            $table->decimal('rm_pay_rate')->nullable();
            $table->decimal('rm_pay_value')->nullable();
            $table->decimal('pay_currency_exch_rate')->nullable();
            $table->decimal('base_currency_exch_rate')->nullable();
            $table->decimal('unit_rate_local_cur')->nullable();
            $table->decimal('unit_rate_base_cur')->nullable();
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
        Schema::dropIfExists('buying_fish_grn_dtl_pay_rate');
    }
};
