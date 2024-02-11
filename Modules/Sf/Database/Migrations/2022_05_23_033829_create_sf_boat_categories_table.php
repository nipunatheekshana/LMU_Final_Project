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
        Schema::create('sf_boat_categories', function (Blueprint $table) {
            $table->id();
            $table->string('BoatCategory')->nullable();
            $table->string('BoatCatName')->nullable();
            $table->string('BoatCateDescription')->nullable();
            $table->boolean('LicenseRequired')->nullable();
            $table->boolean('LogSheetRequired')->nullable();
            $table->integer('list_index')->nullable();
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
        Schema::dropIfExists('sf_boat_categories');
    }
};
