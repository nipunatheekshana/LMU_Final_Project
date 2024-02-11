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
        Schema::create('sf_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_receiving_sup_Inspection_required')->default(false);
            $table->string('sup_Inspection_rule')->nullable();
            $table->boolean('is_receiving_boat_Inspection_required')->default(false);
            $table->string('boat_Inspection_rule')->nullable();
            $table->boolean('is_automaric_receving_number')->default(false);
            $table->string('receving_number_mask')->nullable();
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
        Schema::dropIfExists('sf_settings');
    }
};
