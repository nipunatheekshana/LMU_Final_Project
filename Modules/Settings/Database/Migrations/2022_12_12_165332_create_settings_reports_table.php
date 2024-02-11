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
        Schema::create('settings_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('report_name')->unique();
            $table->string('report_description')->nullable();
            $table->string('module')->nullable();
            $table->string('referance');
            $table->string('report_file_location');
            $table->string('report_type')->nullable();
            $table->tinyInteger('default_letter_head')->nullable();
            $table->boolean('is_financial_report')->default(0);
            $table->integer('report_level')->default(0)->comment('"0" is Lowest and "10" is Highest');
            $table->boolean('enabled')->default(1);
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
        Schema::dropIfExists('settings_reports');
    }
};
