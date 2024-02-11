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
        DB::unprepared('CREATE TRIGGER calculate_yield_trigger BEFORE INSERT ON buying_fish_grn_dtl_yield
            FOR EACH ROW
            BEGIN
                SET NEW.gross_prod_yield = (NEW.gross_prod_wg / NEW.batch_weight) * 100;
                SET NEW.net_prod_yield = (NEW.net_prod_wg / NEW.batch_weight) * 100;
                SET NEW.exp_prod_yield = (NEW.exp_wg / NEW.batch_weight) * 100;
            END;
        ');

        DB::unprepared('CREATE TRIGGER update_yield
            BEFORE UPDATE ON buying_fish_grn_dtl_yield
            FOR EACH ROW
            BEGIN
                SET NEW.gross_prod_yield = (NEW.gross_prod_wg / NEW.batch_weight) * 100;
                SET NEW.net_prod_yield = (NEW.net_prod_wg / NEW.batch_weight) * 100;
                SET NEW.exp_prod_yield = (NEW.exp_wg / NEW.batch_weight) * 100;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS calculate_yield_trigger');
        DB::unprepared('DROP TRIGGER IF EXISTS update_yield');
    }
};
