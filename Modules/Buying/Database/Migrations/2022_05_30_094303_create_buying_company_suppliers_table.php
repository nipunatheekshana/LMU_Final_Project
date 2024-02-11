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
        Schema::create('buying_company_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('CompanyID')->nullable();
            $table->foreign('CompanyID')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->foreignId('SupplierID')->nullable();
            $table->foreign('SupplierID')->references('id')->on('buying_suppliers')->onDelete('cascade');
            $table->boolean('is_sf_supplier')->default(false);
            $table->boolean('on_hold')->default(false);
            $table->foreignId('hold_type')->nullable();
            $table->foreign('hold_type')->references('id')->on('buying_supplier_hold_types')->onDelete('cascade');
            $table->string('hold_Comment')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->integer('list_index')->nullable();
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
        Schema::dropIfExists('buying_company_suppliers');
    }
};
