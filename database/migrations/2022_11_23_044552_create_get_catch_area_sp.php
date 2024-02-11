<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        $procedure = "DROP PROCEDURE IF EXISTS `get_catch_area`;
        CREATE PROCEDURE `get_catch_area`(IN Search_like VARCHAR(20))
        BEGIN

        if (Search_like<='') THEN
                SELECT id,AreaCode from sf_catch_area
                where enabled=1;
        ELSE
            SELECT id,AreaCode from sf_catch_area
            WHERE enabled=1 AND AreaCode LIKE  CONCAT('%', Search_like , '%') ;
        END IF;

        END";

        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $procedure = "DROP PROCEDURE IF EXISTS `get_catch_area`;";

        DB::unprepared($procedure);
    }
};
