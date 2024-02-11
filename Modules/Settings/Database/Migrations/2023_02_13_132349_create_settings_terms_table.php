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
        Schema::create('settings_terms', function (Blueprint $table) {
            $table->id();
            $table->string('title', 10)->nullable();
            $table->string('description')->nullable();
            $table->string('type', 25)->nullable();
            $table->boolean('is_financial')->default(false);
            $table->boolean('enabled')->default(true);
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
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
        Schema::dropIfExists('settings_terms');
    }
};
