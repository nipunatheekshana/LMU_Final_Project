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
        Schema::create('mnu_master_labels_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('label_format_id')->nullable();
            $table->foreign('label_format_id')->references('id')->on('mnu_master_labels')->onDelete('cascade');
            $table->string('parameter', 150)->nullable();
            $table->string('parameter_description')->nullable();
            $table->foreignId('data_type')->nullable();
            $table->foreign('data_type')->references('id')->on('settings_data_types')->onDelete('cascade');
            $table->string('format')->nullable();
            $table->string('sample_data')->nullable();
            $table->string('script_field')->nullable();
            $table->string('script_tabel')->nullable();
            $table->string('script_conditions')->nullable();
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
        Schema::dropIfExists('mnu_master_labels_parameters');
    }
};
