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
        Schema::create('accounting_price_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company')->nullable();
            $table->foreign('company')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('price_list_name')->nullable();
            $table->foreignId('currency')->nullable();
            $table->foreign('currency')->references('id')->on('settings_currencies')->onDelete('cascade');
            $table->boolean('buying')->nullable();
            $table->boolean('selling')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->integer('list_index')->nullable();
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
        Schema::dropIfExists('accounting_price_list');
    }
};
