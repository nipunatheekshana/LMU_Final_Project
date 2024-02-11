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
        Schema::create('inventory_warehouse_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('warehouse_type_name')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('inventory_warehouse_type');
    }
};
