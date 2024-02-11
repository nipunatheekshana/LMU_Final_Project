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
        Schema::create('mnu_ext_packing_list_hd', function (Blueprint $table) {
            $table->id();
            $table->string('ws_id')->nullable();
            $table->string('gpl_no')->nullable();
            $table->integer('box_from')->nullable();
            $table->integer('box_to')->nullable();
            $table->integer('no_of_boxes')->nullable();
            $table->double('net_weight_tot')->nullable();
            $table->double('gross_weight_tot')->nullable();
            $table->boolean('is_add_to_pl')->default(false);
            $table->integer('pl_id')->nullable();
            // $table->foreignId('pl_id')->nullable();
            // $table->foreign('pl_id')->references('id')->on('mnu_packing_list_hd')->onDelete('restrict');
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
        Schema::dropIfExists('mnu_ext_packing_list_hd');
    }
};
