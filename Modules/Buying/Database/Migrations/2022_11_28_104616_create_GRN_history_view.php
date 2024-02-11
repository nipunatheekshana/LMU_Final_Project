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

            "CREATE VIEW buying_grn_history_view AS
            SELECT
            buying_fish_grn_hd.id,
                                    buying_fish_grn_hd.grnno,
                                    buying_fish_grn_hd.grndate,
                                    buying_fish_grn_hd.grn_type,
                                    buying_suppliers.supplier_name,
                                    buying_fish_grn_hd.totalQty,
                                    buying_fish_grn_hd.totFishWeight,
                                    buying_fish_grn_hd.processedPcs,
                                    buying_fish_grn_hd.unprocessedPCs,
                                    buying_fish_grn_hd.transferPcs,
                                    buying_fish_grn_hd.rejectPcs,
                                    buying_fish_grn_hd.unload_status,
                                    buying_fish_grn_hd.finance_status,
                                    buying_fish_grn_hd.voucher_status,
                                    buying_fish_grn_hd.supplier_id,
                                    buying_fish_grn_hd.boat_registration_number
            FROM buying_fish_grn_hd
                            LEFT JOIN buying_suppliers
                            ON buying_fish_grn_hd.supplier_id = buying_suppliers.id
        ";
    }
    private function dropView(): string
    {
        return

            " DROP VIEW IF EXISTS `buying_grn_history_view`;";
    }
};
