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
        Schema::create('settings_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code', 20)->unique();
            $table->string('currency_name', 150)->nullable();
            $table->string('currency_symbol', 10)->nullable();
            $table->integer('list_index')->nullable();
            $table->string('fraction', 20)->nullable();
            $table->integer('fraction_units')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->string('number_format', 30)->nullable();
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
        Schema::dropIfExists('settings_currencies');
    }
};
