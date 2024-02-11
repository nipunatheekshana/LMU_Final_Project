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
        Schema::create('sf_fish_reject_reasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companyID')->nullable();
            $table->foreign('companyID')->references('id')->on('settings_companies')->restrictOnDelete();
            $table->string('rejectReason', 150);
            $table->string('rejectCode', 15);
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
        Schema::dropIfExists('sf_fish_reject_reasons');
    }
};
