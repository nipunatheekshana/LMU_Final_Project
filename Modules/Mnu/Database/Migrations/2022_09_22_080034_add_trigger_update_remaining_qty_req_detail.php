<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER tr_update_remaining_values_requirement_dtl BEFORE UPDATE ON `mnu_requirements_dtl`
        FOR EACH ROW
        BEGIN
            IF (NEW.remainingQty  = 0) THEN
                    SET NEW.planStatus =1;
            END IF;
        END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `tr_update_remaining_values_requirement_dtl`');
    }
};
