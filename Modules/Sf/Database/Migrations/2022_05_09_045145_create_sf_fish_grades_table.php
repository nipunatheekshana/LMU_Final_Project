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
        Schema::create('sf_fish_grades', function (Blueprint $table) {
            $table->id();
            $table->string('QFishGrade');
            $table->string('PayFishGrade')->nullable();
            $table->boolean('HNG_GRADE')->default(false);
            $table->integer('list_index')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            //index
            $table->index('id', 'id');
            $table->index('enabled', 'enabled');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sf_fish_grades');
    }
};
