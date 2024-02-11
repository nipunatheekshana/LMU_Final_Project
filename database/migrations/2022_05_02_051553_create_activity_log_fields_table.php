<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_log_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id');
            $table->foreign('activity_id')->references('id')->on('activity_logs')->onDelete('cascade');
            $table->string('old_value')->nullable();
            $table->string('new_value');
            $table->string('field_name');
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
        Schema::dropIfExists('activity_log_fields');
    }
};
