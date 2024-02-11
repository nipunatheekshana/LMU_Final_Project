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
        $procedure = "DROP PROCEDURE IF EXISTS `save_fish_grn_header`;
        CREATE  PROCEDURE `save_fish_grn_header`(
            IN grnno varchar(45),
            IN grndate date,
            IN grn_type int,
            IN supplier_id int,
            IN supplier_ticket_id int,
            IN supplier_vehicle_no varchar(45),
            IN boat_id int,
            IN boat_skipper_name varchar(300),
            IN boat_number_of_crew int,
            IN boat_number_of_tanks int,
            IN boat_cooling_method varchar(45),
            IN boat_trip_start_date  date,
            IN boat_trip_end_date date,
            IN boat_fishing_method_id varchar(45),
            IN boat_landing_site_id int,
            IN user_id int,
            OUT save_status int
            )
            BEGIN

            DECLARE EXIT HANDLER FOR 1062
                BEGIN
                    SELECT 'DUPLICATE KEY ERROR' AS errorMessage;
                        SET save_status=-1;
                END;


            SELECT   @boat_registration_number:=BoatRegNo,
            @boat_licence_no:=LicenseNo, @boat_licence_exp_date:=LicenseExpDate
            FROM sf_boats
            WHERE id=boat_id;



            IF datediff(date(sysdate()),date(@boat_licence_exp_date))>0 THEN
            SET save_status=0;
            ELSE

            SET @create_date_time=sysdate();
            START TRANSACTION;


            INSERT INTO `buying_fish_grn_hd`
            (`grnno`,`grndate`,`grn_type`,`supplier_id`,`supplier_ticket_id`,`supplier_vehicle_no`,
            `boat_id`,`boat_registration_number`,`boat_licence_no`,`boat_licence_exp_date`,`boat_skipper_name`,
            `boat_number_of_crew`,`boat_number_of_tanks`,`boat_cooling_method`,
            `boat_trip_start_date`,`boat_trip_end_date`,`boat_fishing_method_id`,
            `boat_landing_site_id`,`create_date_time`,`create_user_id`)
            VALUES
            (grnno,grndate,grn_type,supplier_id,supplier_ticket_id,supplier_vehicle_no,
            boat_id,@boat_registration_number,@boat_licence_no,@boat_licence_exp_date,boat_skipper_name,
            boat_number_of_crew,boat_number_of_tanks,boat_cooling_method,
            boat_trip_start_date,boat_trip_end_date,boat_fishing_method_id,
            boat_landing_site_id,@create_date_time,user_id);


            SET save_status=1;

            COMMIT;
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
        $procedure = "DROP PROCEDURE IF EXISTS `save_fish_grn_header`;";

        DB::unprepared($procedure);
    }
};
