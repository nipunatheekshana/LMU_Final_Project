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
        Schema::create('buying_grn_ticket_hd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('ticket_no', 25)->nullable();
            $table->dateTime('ticket_date_time')->nullable();
            $table->foreignId('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('buying_suppliers')->onDelete('cascade');
            $table->tinyInteger('grn_mode')->nullable();
            $table->string('vehicle_no', 15)->nullable();
            $table->tinyInteger('ticket_status')->nullable();
            $table->tinyInteger('grn_status')->nullable();
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
        Schema::dropIfExists('buying_grn_ticket_hd');
    }
};
