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
        $procedure = "DROP PROCEDURE IF EXISTS `get_presentation_types`;
        CREATE  PROCEDURE `get_presentation_types`( IN FishSpeciesID BIGINT, IN Search_like VARCHAR(20))
        BEGIN
            #Routine body goes here...
        if (Search_like<='') THEN
            SELECT id,PrsntCode,PrsntName from sf_presentation_type WHERE enabled=1 and fish_species=FishSpeciesID;
        ELSE
            SELECT id,PrsntCode,PrsntName from sf_presentation_type
            WHERE enabled=1 AND  (fish_species=FishSpeciesID) AND PrsntName LIKE  CONCAT('%', Search_like , '%');


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
        $procedure = "DROP PROCEDURE IF EXISTS `get_presentation_types`;";

        DB::unprepared($procedure);
    }
};
