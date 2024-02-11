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
        Schema::create('inventory_manufacturers', function (Blueprint $table) {
            $table->id();
            $table->string('name', )->nullable();
            $table->string('short_name', )->nullable();
            $table->string('website', )->nullable();
            $table->foreignId('country')->nullable();
            $table->foreign('country')->references('id')->on('settings_countries')->onDelete('cascade');
            $table->string('logo', )->nullable();
            $table->string('notes', )->nullable();
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
        Schema::dropIfExists('inventory_manufacturers');
    }
};
