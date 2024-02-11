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
        Schema::create('hrm_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salutation')->nullable();
            $table->foreign('salutation')->references('id')->on('hrm_salutations')->onDelete('cascade');
            $table->string('middle_name', 140)->nullable();
            $table->string('last_name', 140);
            $table->string('first_name', 140);
            $table->string('employee_name', 140);
            $table->string('gender', 20)->nullable();
            $table->string('company', 140)->nullable();
            $table->string('department', 140)->nullable();
            $table->string('designation', 140)->nullable();
            $table->string('national_id_card_number', 140)->unique();
            $table->date('date_of_birth');
            $table->text('image')->nullable();
            $table->string('status')->nullable();

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
        Schema::dropIfExists('hrm_employees');
    }
};
