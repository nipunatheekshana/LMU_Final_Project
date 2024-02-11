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

            "CREATE VIEW buying_fish_grn_dtl_monthly_purchase_summary AS
            SELECT YEAR
                ( buying_fish_grn_hd.grndate ) AS GRNYear,
                MONTHNAME( buying_fish_grn_hd.grndate ) AS GRNmonthName,
                DATE_FORMAT( buying_fish_grn_hd.grndate, '%b' ) AS month_Short_name,
                MONTH(buying_fish_grn_hd.grndate) AS 'month',
                buying_fish_grn_hd.grndate,
                buying_fish_grn_hd.grnno,
                buying_fish_grn_dtl.fish_type_id,
                sf_fish_species.FishName,
                buying_fish_grn_hd.supplier_id,
                buying_suppliers.supplier_name,
                buying_fish_grn_dtl.presentation,
                buying_fish_grn_dtl.supplier_grade,
                buying_fish_grn_hd.id AS headerId,
                buying_fish_grn_dtl.id AS detailId,
                buying_fish_grn_dtl.net_weight,
                buying_fish_grn_dtl.item_size_id,
	            buying_grn_fish_size_matrix.SizeDescription

            FROM
                buying_fish_grn_dtl
                JOIN buying_fish_grn_hd ON buying_fish_grn_dtl.lot_grnno = buying_fish_grn_hd.grnno
                LEFT JOIN sf_fish_species ON 	buying_fish_grn_dtl.fish_type_id = sf_fish_species.id
                LEFT JOIN buying_suppliers ON buying_fish_grn_hd.supplier_id = buying_suppliers.id
                LEFT JOIN buying_grn_fish_size_matrix ON buying_grn_fish_size_matrix.id = buying_fish_grn_dtl.item_size_id;";
    }
    private function dropView(): string
    {
        return " DROP VIEW IF EXISTS `buying_fish_grn_dtl_monthly_purchase_summary`;";
    }
};
