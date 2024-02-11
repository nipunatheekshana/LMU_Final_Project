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
        Schema::create('buying_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name', 140)->nullable();
            $table->string('country', 20)->nullable();
            $table->string('default_bank_account', 140)->nullable();
            $table->string('tax_id', 140)->nullable();
            $table->string('tax_category', 140)->nullable();
            $table->string('tax_withholding_category', 140)->nullable();
            $table->boolean('is_transporter')->nullable();
            $table->boolean('is_internal_supplier')->nullable();
            $table->string('represents_company', 140)->nullable();
            $table->text('image')->nullable();
            $table->string('supplier_group', 140)->nullable();
            $table->string('supplier_type', 140)->nullable();
            $table->string('pan', 140)->nullable();
            $table->string('language', 140)->nullable();
            $table->boolean('allow_purchase_invoice_creation_without_purchase_order', 140)->nullable();
            $table->boolean('allow_purchase_invoice_creation_without_purchase_receipt', 140)->nullable();
            $table->string('default_currency', 140)->nullable();
            $table->string('default_price_list', 140)->nullable();
            $table->string('payment_terms', 140)->nullable();
            $table->boolean('on_hold')->default(false);
            $table->string('hold_type', 140)->nullable();
            $table->date('release_date', 140)->nullable();
            $table->string('website', 140)->nullable();
            $table->text('supplier_details')->nullable();
            $table->text('_comments')->nullable();
            // $table->text('logo')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->integer('list_index')->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            // index
            $table->index('id', 'id');
            $table->index('enabled', 'enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buying_suppliers');
    }
};
