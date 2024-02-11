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
        Schema::create('mnu_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companyID')->nullable();
            $table->foreign('companyID')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('default_container_item_category', 50)->nullable();
            $table->string('default_label_item_category', 50)->nullable();
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
        Schema::dropIfExists('mnu_settings');
    }
};
