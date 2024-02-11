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
        $procedure = "DROP PROCEDURE IF EXISTS `save_fish_grn_details`;
        CREATE  PROCEDURE `save_fish_grn_details`(
            IN lotgrnno varchar(45),
            IN lotitemmode INT,
            IN lotserialno INT,
            IN fishtypeid INT,
            IN qualitygrade varchar(50),
            IN presentation varchar(50),
            IN receivePcs INT,
            IN scaleweight DOUBLE,
            IN receiveweight DOUBLE,
            IN dmgweight DOUBLE,
            IN fishtemperature DOUBLE,
            IN fishcomment varchar(50),
            IN fishselectorid INT,
            IN mobileuserid INT,
            IN boattankno INT,
            IN boattanklayer varchar(4),
            IN boattanktemp DECIMAL,
            IN catchdate date,
            IN groundtankid INT,
            IN companyid INT,
            IN workstationid INT,
            OUT save_status int
            )
            BEGIN
                #Routine body goes here...



                -- Calculate gross weight
                SET @net_fish_weight=receiveweight-dmgweight;


                -- decide fish size	by using DECIDE_FISH_SIZE() function
                 SET @fish_size=DECIDE_FISH_SIZE(fishtypeid,@net_fish_weight);


                -- get supplier fish grade
                SELECT  PayFishGrade INTO @PayFishGrade  FROM sf_fish_grades
                WHERE fish_species=fishtypeid AND QFishGrade=qualitygrade;


            -- 	SELECT EXISTS(SELECT PayFishGrade from sf_fish_grades 	WHERE fish_species=fishtypeid AND QFishGrade=qualitygrade) INTO @PayFishGrade ;

                SELECT @PayFishGrade;

                -- check already available FishNo

                SELECT EXISTS(SELECT lot_id from buying_fish_grn_dtl 	WHERE (lot_grnno =lotgrnno) AND (lot_serial_no = lotserialno) AND (fish_type_id = fishtypeid)) INTO @Fishcount ;

            -- 	SELECT @Fishcount;


                if (@Fishcount=1) THEN


             SELECT  lot_id,lot_barcode
             INTO  @lot_id,@lot_barcode
             FROM buying_fish_grn_dtl
             WHERE (lot_grnno =lotgrnno) AND (lot_serial_no = lotserialno) AND (fish_type_id = fishtypeid);

            -- SELECT @lot_id,@lot_barcode,@fish_size,@net_fish_weight;


            START TRANSACTION;
            UPDATE buying_fish_grn_dtl SET
                quality_grade=qualitygrade,
                supplier_grade=@PayFishGrade,
                item_size=@fish_size,
                presentation=presentation,
                scale_weight=scaleweight,
                receive_weight=receiveweight,
                dmg_weight=dmgweight,
                net_weight=@net_fish_weight,
                fish_temperature=fishtemperature,
                fish_comment=fishcomment
                WHERE lot_id=@lot_id;
             COMMIT;
            --
                SET save_status=2;

            ELSE

                SET @com= LPAD(companyid, 2, 0);
                SET @YR= DATE_FORMAT(sysdate(), '%y');
                SET @fish= LPAD(fishtypeid, 4, 0);
                SET @lotsrn= LPAD(lotserialno, 4, 0);



                SET @lot_barcode=CONCAT(@com,@YR,lotgrnno,@fish,@lotsrn);

                START TRANSACTION;
                INSERT INTO buying_fish_grn_dtl
                (
                lot_barcode,
                lot_grnno,
                lot_item_mode,
                lot_serial_no,
                fish_type_id,
                supplier_grade,
                quality_grade,
                item_size,
                presentation,
                receive_workstation,
                fish_selector_id,
                receive_Pcs,
                scale_weight,
                receive_weight,
                dmg_weight,
                net_weight,
                fish_temperature,
                fish_comment
                )
                VALUES
                (
                @lot_barcode,
                lotgrnno,
                lotitemmode,
                lotserialno,
                fishtypeid,
                @PayFishGrade,
                qualitygrade,
                @fish_size,
                presentation,
                workstationid,
                fishselectorid,
                receivePcs,
                scaleweight,
                receiveweight,
                dmg_weight,
                @net_fish_weight,
                fishtemperature,
                fishcomment
                );
             COMMIT;

                SET save_status=1;
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
        $procedure = "DROP PROCEDURE IF EXISTS `save_fish_grn_details`;";

        DB::unprepared($procedure);
    }
};
