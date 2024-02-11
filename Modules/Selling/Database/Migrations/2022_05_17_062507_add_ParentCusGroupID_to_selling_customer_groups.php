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
        Schema::table('selling_customer_groups', function (Blueprint $table) {
            $table->foreignId('ParentCusGroupID')->nullable();
            $table->foreign('ParentCusGroupID')->references('id')->on('selling_customer_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('selling_customer_groups', function (Blueprint $table) {
            $table->dropColumn('ParentCusGroupID');

        });
    }
};
