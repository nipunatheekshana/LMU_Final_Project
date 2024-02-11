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
        Schema::create('settings_printers', function (Blueprint $table) {
            $table->id();
            $table->string('printer_name')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('printer_port')->nullable();
            $table->string('model')->nullable();
            $table->foreignId('WorkstationID')->nullable();
            $table->foreign('WorkstationID')->references('id')->on('settings_workstations')->onDelete('cascade');
            $table->string('printer_id')->nullable();
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
        Schema::dropIfExists('settings_printers');
    }
};
