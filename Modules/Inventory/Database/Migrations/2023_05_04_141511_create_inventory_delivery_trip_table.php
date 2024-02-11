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
        Schema::create('inventory_delivery_trip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->foreignId('driver')->nullable();
            $table->foreign('driver')->references('id')->on('hrm_employees')->onDelete('cascade');
            $table->foreignId('vehicle')->nullable();
            $table->foreign('vehicle')->references('id')->on('settings_vehicles')->onDelete('cascade');
            $table->date('estimated_depature_date_time')->nullable();
            $table->date('estimated_arrival_date_time')->nullable();
            $table->foreignId('delivery_location_address')->nullable();
            $table->foreign('delivery_location_address')->references('id')->on('crm_addresses')->onDelete('cascade');
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('inventory_delivery_trip');
    }
};
