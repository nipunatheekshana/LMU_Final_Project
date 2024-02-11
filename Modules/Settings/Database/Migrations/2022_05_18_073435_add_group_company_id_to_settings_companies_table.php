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
        Schema::table('settings_companies', function (Blueprint $table) {
            $table->foreignId('group_company_id')->nullable();
            $table->foreign('group_company_id')->references('id')->on('settings_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings_companies', function (Blueprint $table) {
            $table->dropColumn('group_company_id');

        });
    }
};
