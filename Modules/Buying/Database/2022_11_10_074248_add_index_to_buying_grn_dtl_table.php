<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mnu_production_dtl', function (Blueprint $table) {
            $table->index(['GRNNo', 'FishNo'], 'GRNNo_FishNo');
        });
        Schema::table('buying_grn_dtl', function (Blueprint $table) {
            $table->index('GRNNo', 'GRNNo');
            $table->index('FishCode', 'FishCode');
            $table->index('FishSize', 'FishSize');
            $table->index('Presentation', 'Presentation');
            $table->index('PayGrade', 'PayGrade');
            $table->index('QFishGrade', 'QFishGrade');
            $table->index(['GRNNo', 'FishNo'], 'GRNNo_FishNo');

            $table->index(['GRNNo', 'Presentation'], 'GRNNo_Presentation');
            $table->index(['GRNNo', 'PayGrade'], 'GRNNo_PayGrade');
            $table->index(['GRNNo', 'QFishGrade'], 'GRNNo_QFishGrade');
            $table->index(['GRNNo', 'Presentation','PayGrade'], 'GRNNo_Presentation_PayGrade');
            $table->index(['GRNNo', 'Presentation','QFishGrade'], 'GRNNo_Presentation_QFishGrade');
            $table->index(['GRNNo', 'PayGrade','QFishGrade'], 'GRNNo_PayGrade_QFishGrade');
            $table->index(['GRNNo', 'Presentation','PayGrade','QFishGrade'], 'GRNNo_Presentation_PayGrade_QFishGrade');




        });
        Schema::table('buying_grn', function (Blueprint $table) {
            $table->index('GRNNo', 'GRNNo');
            $table->index('AssignBoat', 'AssignBoat');

            $table->index('SupID', 'SupID');
            $table->index('RefNo', 'RefNo');
            $table->index('GRNType', 'GRNType');
            $table->index('GRNDate', 'GRNDate');

            $table->index(['GRNDate', 'GRNType'], 'GRNDate_GRNType');
            $table->index(['GRNDate', 'RefNo'], 'GRNDate_RefNo');
            $table->index(['GRNDate', 'SupID'], 'GRNDate_SupID');
            $table->index(['GRNType', 'RefNo'], 'GRNType_RefNo');
            $table->index(['GRNType', 'SupID'], 'GRNType_SupID');
            $table->index(['RefNo', 'SupID'], 'RefNo_SupID');

            $table->index(['GRNDate', 'GRNType', 'RefNo'], 'GRNDate_GRNType_RefNo');
            $table->index(['GRNDate', 'GRNType', 'SupID'], 'GRNDate_GRNType_SupID');
            $table->index(['GRNType', 'RefNo', 'SupID'], 'GRNType_RefNo_SupID');
            $table->index(['RefNo', 'GRNDate', 'SupID'], 'RefNo_GRNDate_SupID');

            $table->index(['RefNo', 'GRNDate', 'SupID', 'GRNType'], 'RefNo_GRNDate_SupID_GRNType');
        });
        Schema::table('buying_suppliers', function (Blueprint $table) {
            $table->index('id', 'id');
            $table->index('enabled', 'enabled');
        });
        Schema::table('sf_boats', function (Blueprint $table) {
            $table->index('id', 'id');
            $table->index('enabled', 'enabled');
        });
        Schema::table('sf_fish_species', function (Blueprint $table) {
            $table->index('id', 'id');
            $table->index('enabled', 'enabled');
        });
        Schema::table('buying_grn_fish_size_matrix', function (Blueprint $table) {
            $table->index('id', 'id');
            $table->index('SizeDescription', 'SizeDescription');
            $table->index('grnNo', 'grnNo');
            $table->index('enabled', 'enabled');
            // $table->index(['grnNo','FishSpeciesId'],'grnNo_FishSpeciesId');
            $table->index(['enabled', 'FishSpeciesId'], 'enabled_FishSpeciesId');
            $table->index(['grnNo', 'FishSpeciesId','enabled'], 'grnNo_FishSpeciesId_enabled');

        });
        Schema::table('sf_presentation_type', function (Blueprint $table) {
            $table->index('id', 'id');
            $table->index('enabled', 'enabled');
        });
        Schema::table('sf_fish_grades', function (Blueprint $table) {
            $table->index('id', 'id');
            $table->index('enabled', 'enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mnu_production_dtl', function (Blueprint $table) {
            $table->dropIndex('GRNNo_FishNo');
        });
        Schema::table('buying_grn_dtl', function (Blueprint $table) {
            $table->dropIndex('GRNNo');
            $table->dropIndex('FishCode');
            $table->dropIndex('FishSize');
            $table->dropIndex('Presentation');
            $table->dropIndex('PayGrade');
            $table->dropIndex('QFishGrade');
            $table->dropIndex('GRNNo_FishNo');
            $table->dropIndex('GRNNo_Presentation');
            $table->dropIndex('GRNNo_PayGrade');
            $table->dropIndex('GRNNo_QFishGrade');
            $table->dropIndex('GRNNo_Presentation_PayGrade');
            $table->dropIndex('GRNNo_Presentation_QFishGrade');
            $table->dropIndex('GRNNo_PayGrade_QFishGrade');
            $table->dropIndex('GRNNo_Presentation_PayGrade_QFishGrade');


        });
        Schema::table('buying_grn', function (Blueprint $table) {
            $table->dropIndex('GRNNo');
            $table->dropIndex('SupID');
            $table->dropIndex('RefNo');
            $table->dropIndex('GRNType');
            $table->dropIndex('GRNDate');
            $table->dropIndex('AssignBoat');

            $table->dropIndex('GRNDate_GRNType');
            $table->dropIndex('GRNDate_RefNo');
            $table->dropIndex('GRNDate_SupID');
            $table->dropIndex('GRNType_RefNo');
            $table->dropIndex('GRNType_SupID');
            $table->dropIndex('RefNo_SupID');

            $table->dropIndex('GRNDate_GRNType_RefNo');
            $table->dropIndex('GRNDate_GRNType_SupID');
            $table->dropIndex('GRNType_RefNo_SupID');
            $table->dropIndex('RefNo_GRNDate_SupID');

            $table->dropIndex('RefNo_GRNDate_SupID_GRNType');
        });
        Schema::table('buying_suppliers', function (Blueprint $table) {
            $table->dropIndex('id');
            $table->dropIndex('enabled');
        });
        Schema::table('sf_boats', function (Blueprint $table) {
            $table->dropIndex('id');
            $table->dropIndex('enabled');
        });
        Schema::table('sf_fish_species', function (Blueprint $table) {
            $table->dropIndex('id');
            $table->dropIndex('enabled');
        });
        Schema::table('buying_grn_fish_size_matrix', function (Blueprint $table) {
            $table->dropIndex('id');
            $table->dropIndex('SizeDescription');
            $table->dropIndex('grnNo');
            $table->dropIndex('enabled');
            // $table->dropIndex('grnNo_FishSpeciesId');
            $table->dropIndex('enabled_FishSpeciesId');
            $table->dropIndex('grnNo_FishSpeciesId_enabled');

        });
        Schema::table('sf_presentation_type', function (Blueprint $table) {
            $table->dropIndex('id');
            $table->dropIndex('enabled');
        });
        Schema::table('sf_fish_grades', function (Blueprint $table) {
            $table->dropIndex('id');
            $table->dropIndex('enabled');
        });
    }
};
