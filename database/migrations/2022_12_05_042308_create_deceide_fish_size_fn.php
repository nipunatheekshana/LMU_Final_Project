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
        // $procedure = "DROP PROCEDURE IF EXISTS `DECIDE_FISH_SIZE`;
        // CREATE FUNCTION `DECIDE_FISH_SIZE`(fish_species int,fish_weight double) RETURNS varchar(10) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
        // BEGIN
        //     #Routine body goes here...

        //         SET @SIZE_CODE='';
        //         SELECT SizeCode INTO @SIZE_CODE FROM sf_fish_size_matrix
        //         WHERE (FishSpeciesId=fish_species) AND (min_Value<=fish_weight ) AND  (max_Value > fish_weight);



        //     IF @SIZE_CODE='' THEN 	 SET @SIZE_CODE='UNDEFINED'; END IF;


        //     RETURN @SIZE_CODE;
        // END";

        // DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $procedure = "DROP PROCEDURE IF EXISTS `DECIDE_FISH_SIZE`;";

        DB::unprepared($procedure);
    }
};
