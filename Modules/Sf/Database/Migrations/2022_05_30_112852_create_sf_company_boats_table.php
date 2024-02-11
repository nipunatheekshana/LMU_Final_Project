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
        Schema::create('sf_company_boats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('CompanyID')->nullable();
            $table->foreign('CompanyID')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->foreignId('BoatId')->nullable();
            $table->foreign('BoatId')->references('id')->on('sf_boats')->onDelete('cascade');
            $table->boolean('on_hold')->default(false);
            $table->string('hold_type')->nullable();
            $table->string('hold_Comment')->nullable();
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
        Schema::dropIfExists('sf_company_boats');
    }
};
