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
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }
    private function createView(): string
    {
        return

            "CREATE VIEW mnu_production_dtl_view AS SELECT
            mnu_production_dtl.pcs_no AS PcsNo,
            mnu_production_dtl.PcsID,
            inventory_items.item_name,
            selling_customers.CusName,
            mnu_production_dtl.pcs_weight AS PcsWeight,
            mnu_production_dtl.production_mob_user AS MobUser,
            mnu_production_dtl.trim_supervisor AS TrimSupCode,
            mnu_production_dtl.trimmer AS TrimmerCode,
            mnu_production_dtl.production_datetime AS PRDateTime,
            mnu_production_dtl.pcs_status AS pcsStatus,
            mnu_production_dtl.lot_serial_no,
            mnu_production_dtl.lot_grn_no AS lot_grnno

            FROM
                mnu_production_dtl
                LEFT JOIN inventory_items ON mnu_production_dtl.master_product_id = inventory_items.id
                LEFT JOIN selling_customers ON mnu_production_dtl.cust_id = selling_customers.id ;";
    }
    private function dropView(): string
    {
        return

            " DROP VIEW IF EXISTS `mnu_production_dtl_view`;";
    }
};
