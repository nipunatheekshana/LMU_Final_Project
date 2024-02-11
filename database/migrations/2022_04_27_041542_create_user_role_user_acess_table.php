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
        Schema::create('user_role_user_acess', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userRoleId');
            $table->foreign('userRoleId')->references('id')->on('user_roles')->onDelete('cascade');
            $table->foreignId('AccessId');
            $table->foreign('accessId')->references('id')->on('useracess')->onDelete('cascade');
            $table->boolean('view')->default(true);
            $table->boolean('add')->default(false);
            $table->boolean('edit')->default(false);
            $table->boolean('delete')->default(false);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('user_role_user_acess');
    }
};
