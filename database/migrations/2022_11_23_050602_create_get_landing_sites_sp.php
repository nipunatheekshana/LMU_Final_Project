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
        $procedure = "DROP PROCEDURE IF EXISTS `get_landing_sites`;
        CREATE  PROCEDURE `get_landing_sites`(IN Search_like VARCHAR(20))
        BEGIN

        if (Search_like<='') THEN
            SELECT id,LandingSiteID,LandingSiteName from sf_landingsite WHERE enabled=1;
        ELSE
            SELECT id,LandingSiteID,LandingSiteName from sf_landingsite
            WHERE enabled=1 AND LandingSiteName LIKE  CONCAT('%', Search_like , '%') ;
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
        $procedure = "DROP PROCEDURE IF EXISTS `get_landing_sites`;";

        DB::unprepared($procedure);
    }
};
