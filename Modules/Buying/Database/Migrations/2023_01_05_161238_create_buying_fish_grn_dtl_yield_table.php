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
        Schema::create('buying_fish_grn_dtl_yield', function (Blueprint $table) {
            $table->id();
            $table->string('production_batch_id',20)->nullable();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('restrict');
            $table->dateTime('production_batch_date')->nullable();
            $table->foreignId('grn_dtl_lot_id')->nullable();
            $table->foreign('grn_dtl_lot_id')->references('id')->on('buying_fish_grn_dtl')->onDelete('restrict');
            $table->string('lot_grn_no',20)->nullable();
            $table->double('batch_weight')->nullable();
            $table->double('std_wg')->nullable();
            $table->double('prod_wg')->nullable();
            $table->double('pack_wg')->nullable();
            $table->double('tfr_typ_0_wg')->nullable();
            $table->double('tfr_typ_1_wg')->nullable();
            $table->double('rej_typ_0_wg')->nullable();
            $table->double('rej_typ_1_wg')->nullable();
            $table->double('exp_wg')->nullable();
            $table->double('rp_wg')->nullable();
            $table->double('gross_prod_wg')->nullable();
            $table->double('net_prod_wg')->nullable();
            $table->double('gross_prod_yield')->nullable();
            $table->double('net_prod_yield')->nullable();
            $table->double('exp_prod_yield')->nullable();
            $table->double('static_prod_yield')->nullable();
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
        Schema::dropIfExists('buying_fish_grn_dtl_yield');
    }
};
