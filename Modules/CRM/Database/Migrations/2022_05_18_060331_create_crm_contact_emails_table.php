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
        Schema::create('crm_contact_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->nullable();
            $table->foreign('contact_id')->references('id')->on('crm_contacts')->onDelete('cascade');
            $table->string('email_address', 140)->nullable();
            $table->boolean('is_primary')->nullable();
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
        Schema::dropIfExists('crm_contact_emails');
    }
};
