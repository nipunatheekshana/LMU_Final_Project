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
        Schema::create('crm_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('AddressTitle')->nullable();
            $table->string('emailAddress')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Fax')->nullable();
            $table->string('Longitude')->nullable();
            $table->string('LongLat')->nullable();
            $table->string('Latitude')->nullable();
            $table->foreignId('AddressType')->nullable();
            $table->foreign('AddressType')->references('id')->on('crm_address_types')->onDelete('cascade');
            $table->string('Addressline1')->nullable();
            $table->string('Addressline2')->nullable();
            $table->string('CityTown')->nullable();
            $table->string('Country')->nullable();
            // $table->foreign('Country')->references('id')->on('countries')->onDelete('cascade');
            $table->string('PostalCode')->nullable();
            $table->boolean('PreferedBillingAddress')->nullable();
            $table->boolean('PreferedShippingAddress')->nullable();
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
        Schema::dropIfExists('crm_addresses');
    }
};
