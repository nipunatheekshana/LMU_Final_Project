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
        Schema::create('settings_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('license_plate')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('chassis_no')->nullable();
            $table->string('fuel_type')->nullable();
            $table->date('acquisition_date')->nullable();
            $table->float('acquisition_value')->nullable();
            $table->string('ownership')->nullable();
            $table->foreignId('type')->nullable();
            $table->foreign('type')->references('id')->on('settings_transport_vehicle_types')->onDelete('cascade');
            $table->float('last_odometer_value')->nullable();
            $table->dateTime('last_odometer_date_time')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('default_driver')->nullable();
            $table->foreign('default_driver')->references('id')->on('hrm_employees')->onDelete('cascade');
            $table->string('insuarance_policy_no')->nullable();
            $table->string('insuarance_company')->nullable();
            $table->date('insuarance_valid_till')->nullable();
            $table->string('revenue_licence_no')->nullable();
            $table->date('revenue_licence_valid_till')->nullable();
            $table->string('emission_test_no')->nullable();
            $table->string('emission_test_company')->nullable();
            $table->date('emission_test_valid_till')->nullable();
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
        Schema::dropIfExists('settings_vehicles');
    }
};
