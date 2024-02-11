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
        Schema::create('settings_barcode_types', function (Blueprint $table) {
            $table->id();
            $table->string('barcodeType')->nullable();
            $table->string('sampleImage')->nullable();
            $table->string('category',150)->nullable();
            $table->string('characterSet',150)->nullable();
            $table->string('length',150)->nullable();
            $table->string('checksum',150)->nullable();
            $table->string('notes',150)->nullable();
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
        Schema::dropIfExists('settings_barcode_types');
    }
};
