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
        Schema::create('settings_data_types_formats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_type_id');
            $table->foreign('data_type_id')->references('id')->on('settings_data_types')->onDelete('cascade');
            $table->string('format')->nullable();
            $table->string('sample_data')->nullable();
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
        Schema::dropIfExists('settings_data_types_formats');
    }
};
