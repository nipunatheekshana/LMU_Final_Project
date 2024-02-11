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
        Schema::create('mnu_pick_list_hd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('picklist_no')->nullable();
            $table->foreignId('customer')->nullable();
            $table->foreign('customer')->references('id')->on('selling_customers')->onDelete('cascade');
            $table->string('purpose')->nullable();
            $table->string('remarks')->nullable();
            $table->string('warehouse')->nullable();
            $table->foreignId('workstation')->nullable();
            $table->foreign('workstation')->references('id')->on('settings_workstations')->onDelete('restrict');
            $table->integer('worksheet_id')->nullable();
            $table->string('worksheet_no')->nullable();
            $table->integer('material_request')->nullable();
            $table->json('activityLog')->nullable();
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
        Schema::dropIfExists('mnu_pick_list_hd');
    }
};
