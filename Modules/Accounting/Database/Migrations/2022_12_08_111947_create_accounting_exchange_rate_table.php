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
        Schema::create('accounting_exchange_rate', function (Blueprint $table) {
            $table->comment('');
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->restrictOnDelete();
            $table->date('date')->nullable();
            $table->foreignId('currency')->nullable();
            $table->foreign('currency')->references('id')->on('settings_currencies')->restrictOnDelete();
            $table->double('exchange_rate', 10, 2)->default(1.00);
            $table->boolean('for_buying')->default(true);
            $table->boolean('for_selling')->default(true);
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
        Schema::dropIfExists('accounting_exchange_rate');
    }
};
