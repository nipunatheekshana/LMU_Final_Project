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
        Schema::create('settings_process_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ActivityID')->nullable();
            $table->foreign('ActivityID')->references('id')->on('settings_activities')->onDelete('cascade');
            $table->foreignId('ProcessID')->nullable();
            $table->foreign('ProcessID')->references('id')->on('settings_processes')->onDelete('cascade');
            $table->string('ProcessActivityDescription')->nullable();
            $table->boolean('AssignToIndivdualOutput')->nullable();
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
        Schema::dropIfExists('settings_process_activities');
    }
};
