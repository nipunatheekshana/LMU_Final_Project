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

        Schema::create('inventory_delivery_note', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('delivery_note_no')->nullable();
            $table->foreignId('delivery_trip_id')->nullable();
            $table->foreign('delivery_trip_id')->references('id')->on('inventory_delivery_trip')->onDelete('cascade');
            $table->foreignId('customer')->nullable();
            $table->foreign('customer')->references('id')->on('selling_customers')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->integer('total_qty')->nullable();
            $table->float('total_gross_weight')->nullable();
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
        Schema::dropIfExists('inventory_delivery_note');
    }
};
