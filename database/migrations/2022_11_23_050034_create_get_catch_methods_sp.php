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
        $procedure = "DROP PROCEDURE IF EXISTS `get_catch_methods`;
        CREATE  PROCEDURE `get_catch_methods`(IN Search_like VARCHAR(20))
        BEGIN


        if (Search_like<='') THEN
                SELECT id,CatchMethodCode from sf_catch_method
                where enabled=1 order by list_index ASC;
        ELSE
            SELECT id,CatchMethodCode from sf_catch_method
            WHERE enabled=1 AND CatchMethodCode LIKE  CONCAT('%', Search_like , '%') order by list_index ASC ;
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
        $procedure = "DROP PROCEDURE IF EXISTS `get_catch_methods`;";

        DB::unprepared($procedure);
    }
};
