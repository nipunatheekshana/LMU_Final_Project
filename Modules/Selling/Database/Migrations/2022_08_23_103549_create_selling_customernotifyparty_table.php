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
        Schema::create('selling_customernotifyparty', function (Blueprint $table) {
            $table->id();

            $table->foreignId('CusCode')->nullable();
            $table->foreign('CusCode')->references('id')->on('selling_customers')->onDelete('cascade');
            $table->foreignId('notifypartyID')->nullable();
            $table->foreign('notifypartyID')->references('id')->on('crm_addresses')->onDelete('cascade');
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
        Schema::dropIfExists('selling_customernotifyparty');
    }
};
