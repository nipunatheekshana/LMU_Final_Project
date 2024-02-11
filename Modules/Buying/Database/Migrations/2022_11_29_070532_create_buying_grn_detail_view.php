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

            "CREATE VIEW buying_grn_detail_view AS
            SELECT
            buying_fish_grn_dtl.lot_grnno,
                        buying_fish_grn_dtl.lot_serial_no,
                        buying_fish_grn_dtl.lot_barcode,
                        sf_fish_species.id as FishSpID,
                        sf_fish_species.FishCode,
                        buying_fish_grn_dtl.presentation,
                        buying_fish_grn_dtl.supplier_grade,
                        buying_fish_grn_dtl.quality_grade,
                        buying_grn_fish_size_matrix.SizeDescription as item_size,
                        buying_fish_grn_dtl.net_weight as FishWeight,
                        buying_fish_grn_dtl.item_Status,
                        buying_fish_grn_dtl.dmg_weight,
                        buying_fish_grn_dtl.fish_temperature,
                        hrm_employees.employee_name as fish_selector,
                        settings_workstations.WorkstationName,
                        users.name as mobile_user
            FROM buying_fish_grn_dtl
                                LEFT JOIN sf_fish_species
                                ON  buying_fish_grn_dtl.fish_type_id = sf_fish_species.id
                                LEFT JOIN hrm_employees
                                ON hrm_employees.id = buying_fish_grn_dtl.fish_selector_id
                                LEFT JOIN settings_workstations
                                ON settings_workstations.id = buying_fish_grn_dtl.process_workstation
                                LEFT JOIN users
                                ON users.id = buying_fish_grn_dtl.mobile_user_id
                                LEFT JOIN buying_grn_fish_size_matrix
                                ON buying_grn_fish_size_matrix.id = buying_fish_grn_dtl.item_size_id;";
    }
    private function dropView(): string
    {
        return " DROP VIEW IF EXISTS `buying_grn_detail_view`;";
    }
};

