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
        $procedure = "DROP PROCEDURE IF EXISTS `get_fishing_boats`;
        CREATE  PROCEDURE `get_fishing_boats`(IN `search_criteria` varchar(30),IN `search_value` varchar(30))
        BEGIN
            #Routine body goes here...

        if (search_value='') THEN

        SELECT id,BoatID,BoatRegNo,BoatName,BoatShortName from sf_boats WHERE enabled=1;

        ELSE
            IF (search_criteria='RegNo') THEN
                SELECT id,BoatID,BoatRegNo,BoatName,BoatShortName from sf_boats
                WHERE enabled=1 AND BoatRegNo LIKE CONCAT('%', search_value , '%') ;
            END IF;

            IF (search_criteria='BoatName') THEN
        -- 			SELECT id,BoatID,BoatRegNo,BoatName,BoatShortName from sf_boats
        -- 			WHERE enabled=1 AND BoatName LIKE CONCAT('%', Search_like , '%') ;

                SELECT id,BoatID,BoatRegNo,BoatName,BoatShortName from sf_boats
                WHERE enabled=1 AND BoatName LIKE CONCAT('%', search_value , '%') ;
            END IF;


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
        $procedure = "DROP PROCEDURE IF EXISTS `get_fishing_boats`;";

        DB::unprepared($procedure);
    }
};
