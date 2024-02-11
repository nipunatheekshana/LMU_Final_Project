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
        Schema::create('settings_process_activity_employee_templates', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->foreignId('process');
            $table->foreign('process')->references('id')->on('settings_processes')->restrictOnDelete();
            $table->json('activities_employees_array');
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
        Schema::dropIfExists('settings_process_activity_employee_templates');
    }
};
