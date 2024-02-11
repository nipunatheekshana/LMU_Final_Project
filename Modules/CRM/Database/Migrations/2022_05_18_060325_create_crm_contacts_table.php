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
        Schema::create('crm_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('FirstName', 150)->nullable();
            $table->string('MiddleName', 150)->nullable();
            $table->string('LastName', 150)->nullable();
            $table->string('Salutation')->nullable();
            // $table->foreign('Salutation')->references('id')->on('salutations')->onDelete('cascade');
            $table->string('Designation', 150)->nullable();
            $table->string('Gender')->nullable();
            // $table->foreign('Gender')->references('id')->on('genders')->onDelete('cascade');
            $table->string('PrimaryAddress', 150)->nullable();
            $table->integer('list_index')->nullable();
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
        Schema::dropIfExists('crm_contacts');
    }
};
