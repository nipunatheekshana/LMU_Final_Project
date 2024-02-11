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
        Schema::create('selling_customers', function (Blueprint $table) {
            $table->id();
            $table->string('CusCode', 20)->nullable();
            $table->string('CusName', 150)->nullable();
            $table->string('CusRegNo', 150)->nullable();
            $table->foreignId('CusType')->nullable();
            $table->foreign('CusType')->references('id')->on('selling_customer_types')->onDelete('cascade');
            $table->foreignId('CusGroup')->nullable();
            $table->foreign('CusGroup')->references('id')->on('selling_customer_groups')->onDelete('cascade');
            $table->string('CusCountry')->nullable();
            // $table->foreign('CusCountry')->references('id')->on('countries')->onDelete('cascade');
            $table->string('BillingCurrency')->nullable();
            // $table->foreign('BillingCurrency')->references('id')->on('currencies')->onDelete('cascade');
            $table->string('DefltLanguage')->nullable();
            $table->string('PrimaryContactPerson')->nullable();
            // $table->foreign('PrimaryContactPerson')->references('id')->on('contacts')->onDelete('cascade');
            $table->string('PrimaryContactAddress', 20)->nullable();
            // $table->foreign('PrimaryContactAddress')->references('id')->on('crm_addresses')->onDelete('cascade');
            $table->string('MobileNo', 150)->nullable();
            $table->string('emailAddress', 150)->nullable();
            $table->string('LicenceNo', 150)->nullable();
            $table->string('PriceList', 20)->nullable();
            $table->string('PrimaryBankAccount', 20)->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_internal_customer')->default(false);
            $table->integer('max_fish_age')->nullable();
            $table->integer('list_index')->nullable();
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
        Schema::dropIfExists('selling_customers');
    }
};
