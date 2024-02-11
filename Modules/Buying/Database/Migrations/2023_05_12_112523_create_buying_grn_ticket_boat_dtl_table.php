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
        Schema::create('buying_grn_ticket_boat_dtl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grn_ticket_id')->nullable();
            $table->foreign('grn_ticket_id')->references('id')->on('buying_grn_ticket_hd')->onDelete('cascade');
            $table->foreignId('boat_id')->nullable();
            $table->foreign('boat_id')->references('id')->on('sf_boats')->onDelete('cascade');
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
        Schema::dropIfExists('buying_grn_ticket_boat_dtl');
    }
};
