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
        Schema::create('settings_drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->foreignId('employee')->nullable();
            $table->foreign('employee')->references('id')->on('hrm_employees')->onDelete('cascade');
            $table->string('full_name')->nullable();
            $table->string('address')->nullable();
            $table->string('company')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('licence_no')->nullable();
            $table->date('issued_date')->nullable();
            $table->date('expire_date')->nullable();
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
        Schema::dropIfExists('settings_drivers');
    }
};
