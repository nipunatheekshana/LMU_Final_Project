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
        Schema::create('mnu_customer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer')->nullable();
            $table->foreign('customer')->references('id')->on('selling_customers')->onDelete('cascade');
            $table->foreignId('item')->nullable();
            $table->foreign('item')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->string('lbl_prodname1')->nullable();
            $table->string('lbl_prodname2')->nullable();
            $table->string('lbl_prodname3')->nullable();
            $table->string('pl_prodname1')->nullable();
            $table->string('pl_prodname2')->nullable();
            $table->string('pl_summary_name')->nullable();
            $table->string('pl_short_name')->nullable();
            $table->string('in_prodname1')->nullable();
            $table->string('in_prodname2')->nullable();
            $table->string('in_short_name')->nullable();
            $table->string('ot_prodname1')->nullable();
            $table->string('ot_prodname2')->nullable();
            $table->string('ot_short_name')->nullable();
            $table->string('gtin_no')->nullable();
            $table->string('ean13_no')->nullable();
            $table->string('cus_prod_code_1')->nullable();
            $table->string('cus_prod_code_2')->nullable();
            $table->string('prn_file')->nullable();
            $table->boolean('is_sale_item')->default(false);
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->foreignId('default_printer')->nullable();
            $table->foreign('default_printer')->references('id')->on('settings_printers')->onDelete('cascade');
            $table->integer('numOfLables')->nullable();

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
        Schema::dropIfExists('mnu_customer_items');
    }
};
