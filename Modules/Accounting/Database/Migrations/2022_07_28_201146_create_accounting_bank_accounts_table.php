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
        Schema::create('accounting_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company')->nullable();
            $table->foreign('company')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('account_title')->nullable();
            $table->foreignId('account_type')->nullable();
            $table->foreign('account_type')->references('id')->on('accounting_bank_account_types')->onDelete('cascade');
            $table->foreignId('bank')->nullable();
            $table->foreign('bank')->references('id')->on('accounting_banks')->onDelete('cascade');
            $table->string('bank_code')->nullable();
            $table->string('branch')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->foreignId('default_currency')->nullable();
            $table->foreign('default_currency')->references('id')->on('settings_currencies')->onDelete('cascade');
            $table->string('swift_code')->nullable();
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
        Schema::dropIfExists('accounting_bank_accounts');
    }
};
