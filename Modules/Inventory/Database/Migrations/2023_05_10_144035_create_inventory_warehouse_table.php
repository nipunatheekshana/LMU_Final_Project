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
        Schema::create('inventory_warehouse', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('warehouse_name')->nullable();
            $table->string('warehouse_type')->nullable();
            $table->boolean('is_group')->nullable();
            $table->integer('parent_warehouse')->nullable();
            $table->string('warehouse_address_1')->nullable();
            $table->string('warehouse_address_2')->nullable();
            $table->string('warehouse_city')->nullable();
            $table->string('warehouse_state')->nullable();
            $table->foreignId('warehouse_country')->nullable();
            $table->foreign('warehouse_country')->references('id')->on('settings_countries')->onDelete('cascade');
            $table->string('warehouse_email')->nullable();
            $table->string('warehouse_phone')->nullable();
            $table->integer('default_intransit_warehouse')->nullable();
            $table->string('default_account')->nullable();
            $table->boolean('enabled')->nullable();
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
        Schema::dropIfExists('inventory_warehouse');
    }
};
