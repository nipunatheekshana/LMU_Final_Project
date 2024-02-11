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
        $procedure = "DROP PROCEDURE IF EXISTS `get_fish_list`;
        CREATE  PROCEDURE `get_fish_list`(IN Search_like VARCHAR(20))
        BEGIN
            #Routine body goes here...

        if (Search_like<='') THEN
                SELECT id,FishCode,FishName from sf_fish_species
                where enabled=1;
        ELSE
            SELECT id,FishCode,FishName from sf_fish_species
            WHERE enabled=1 AND FishName LIKE  CONCAT('%', Search_like , '%') ;
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
        $procedure = "DROP PROCEDURE IF EXISTS `get_fish_list`;";

        DB::unprepared($procedure);
    }
};
