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
        Schema::create('buying_grn_ticket_fish_dtl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grn_ticket_id')->nullable();
            $table->foreign('grn_ticket_id')->references('id')->on('buying_grn_ticket_hd')->onDelete('cascade');
            $table->foreignId('fish_species_id')->nullable();
            $table->foreign('fish_species_id')->references('id')->on('sf_fish_species')->onDelete('cascade');
            $table->integer('fish_qty')->nullable();
            $table->decimal('fish_weight', 5, 3)->nullable();
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
        Schema::dropIfExists('buying_grn_ticket_fish_dtl');
    }
};
