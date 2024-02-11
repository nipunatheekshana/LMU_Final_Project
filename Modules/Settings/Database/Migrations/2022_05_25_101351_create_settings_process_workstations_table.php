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
        Schema::create('settings_process_workstations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ProcessID')->nullable();
            $table->foreign('ProcessID')->references('id')->on('settings_processes')->onDelete('cascade');
            $table->foreignId('WorkstationID')->nullable();
            $table->foreign('WorkstationID')->references('id')->on('settings_workstations')->onDelete('cascade');
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
        Schema::dropIfExists('settings_process_workstations');
    }
};
