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
        Schema::create('settings_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_company_id');
            $table->foreign('parent_company_id')->references('id')->on('parent_companies')->onDelete('cascade');
            $table->string('Company_code', 20)->unique();
            $table->string('companyName', 200)->unique();
            $table->string('abbr', 20)->unique();
            $table->boolean('is_group')->default(false);
            $table->integer('list_index')->nullable();
            // $table->string('domain',40)->nullable();
            $table->string('domain_id')->nullable();
            // $table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
            $table->string('country_id')->nullable();
            // $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->text('company_logo', 40)->nullable();
            $table->integer('currency_id')->nullable();
            $table->integer('local_currency_id')->nullable();
            // $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->boolean('advDefaultSettingsDone')->default(false);
            $table->boolean('accountSettingDone')->default(false);
            $table->date('date_of_incorporation')->nullable();
            $table->date('date_of_commencement')->nullable();
            $table->string('phone_no', 150)->nullable();
            $table->string('fax', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('website', 150)->nullable();
            $table->string('registration_No', 100)->nullable();
            $table->text('company_description')->nullable();
            $table->text('registration_details')->nullable();
            $table->string('created_By', 20)->nullable();
            $table->string('modified_By', 20)->nullable();
            $table->boolean('enabled', 20)->default(true);
            // $table->integer('minFishSerialNo')->nullable();
            // $table->integer('minFishSerialNo')->nullable();


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
        Schema::dropIfExists('settings_companies');
    }
};
