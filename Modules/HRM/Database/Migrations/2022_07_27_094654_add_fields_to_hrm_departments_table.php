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
        Schema::table('hrm_departments', function (Blueprint $table) {
            $table->foreignId('parent_department')->nullable();
            $table->foreign('parent_department')->references('id')->on('hrm_departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrm_departments', function (Blueprint $table) {
            // $table->foreignId('parentDepartment')->nullable();
        });
    }
};
