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
        Schema::create('quality_qc_rule_parameters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('QualityRuleID')->nullable();
            $table->foreign('QualityRuleID')->references('id')->on('quality_qc_rule')->onDelete('cascade');
            $table->foreignId('QParameterId')->nullable();
            $table->foreign('QParameterId')->references('id')->on('quality_qualitycheck_paramaters')->onDelete('cascade');
            $table->string('QParamName', 255);
            $table->string('QParamDescription', 255)->nullable();
            $table->integer('MinValue')->nullable();
            $table->integer('MaxValue')->nullable();
            $table->integer('DefaultValue')->nullable();
            $table->boolean('is_status_value_required')->nullable();
            $table->boolean('is_status_value_number')->nullable();
            $table->string('status_value_comment', 150)->nullable();
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
        Schema::dropIfExists('quality_qc_rule_parameters');
    }
};
