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
        Schema::table('buying_supplier_groups', function (Blueprint $table) {
            $table->foreignId('ParentSupGroupID')->nullable();
            $table->foreign('ParentSupGroupID')->references('id')->on('buying_supplier_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buying_supplier_groups', function (Blueprint $table) {
            $table->foreignId('ParentSupGroupID')->nullable();
        });
    }
};
