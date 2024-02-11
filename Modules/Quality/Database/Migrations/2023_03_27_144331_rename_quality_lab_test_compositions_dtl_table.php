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
        Schema::rename('quality_lab_test_compositions_dtl', 'quality_lab_test_dtl_compositions_dtl');
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('quality_lab_test_dtl_compositions_dtl', 'quality_lab_test_compositions_dtl');
    }
};
