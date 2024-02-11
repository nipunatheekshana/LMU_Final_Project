<?php

namespace Modules\Mnu\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Buying\Entities\BuyingFishSize;
use Modules\Buying\Entities\GRN;
use Modules\Buying\Entities\GrnDetailPayRate;
use Modules\Buying\Entities\Supplier;
use Modules\Mnu\Entities\TemporyGRNDtlProcessModeSummary;
use Modules\Mnu\Entities\TemporyGrnDtlProcessSummary;
use Modules\Mnu\Entities\TemporyGrnDtlReceiveSummary;
use Modules\Mnu\Entities\TemporyYield;
use Modules\Sf\Entities\Fishspecies;
use Modules\Sf\Entities\PresentationType;

use function GuzzleHttp\Promise\all;

class ProductionRecoveryDetailsController extends Controller
{
    use commonFeatures;
    private $x;
    public function loadSuppliers()
    {
        try {
            $suppliers = Supplier::where('enabled', true)->select('id', 'supplier_name')->get();

            return $this->responseBody(true, "loadSuppliers", "found",  $suppliers);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSuppliers", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadGrades()
    {
        try {
            // $FishGrade = DB::table('sf_fish_grades')
            //     ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'sf_fish_grades.fish_species')
            //     ->where('sf_fish_species.enabled', true)
            //     ->select('sf_fish_grades.id', 'sf_fish_grades.PayFishGrade', 'sf_fish_species.FishCode')
            //     ->get();
            $FishGrade = GrnDetailPayRate::select('pay_grade')->distinct('pay_grade')->get();

            return $this->responseBody(true, "loadGrades", "found",  $FishGrade);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadGrades", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadFishTypes()
    {
        try {
            $Fishspecies = Fishspecies::where('enabled', true)->select('id', 'FishName')->get();
            return $this->responseBody(true, "loadFishTypes", "found",  $Fishspecies);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadPresentation(Request $request)
    {
        try {
            $Fishspecies = '';
            if (!empty($request->data)) {
                $Fishspecies = PresentationType::where('enabled', true)->whereIn('fish_species', $request->data)->select('id', 'PrsntName')->get();
            } else {
                $Fishspecies = PresentationType::where('enabled', true)->distinct('PrsntName')->get();
            }

            return $this->responseBody(true, "loadPresentation", "found",  $Fishspecies);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPresentation", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadSize(Request $request)
    {
        try {
            $BuyingFishSize = '';
            if (!empty($request->data)) {
                $BuyingFishSize = BuyingFishSize::where('enabled', true)->distinct('SizeDescription')->whereIn('FishSpeciesId', $request->data)->select('id', 'SizeDescription')->get();
            } else {
                $BuyingFishSize = BuyingFishSize::where('enabled', true)->distinct('SizeDescription')->select('id', 'SizeDescription')->get();
            }

            return $this->responseBody(true, "loadSize", "found",  $BuyingFishSize);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSize", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadGRNnumbers()
    {
        try {

            $grnNumbers = GRN::select('grnno')->distinct('grnno')->get();

            return $this->responseBody(true, "loadGRNnumbers", "found",  $grnNumbers);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadGRNnumbers", "Something went wrong", $ex->getMessage());
        }
    }
    public function generateReport(Request $request)
    {

        try {
            $this->create_grn_dtl_receive_summary($request);
            // return TemporyGrnDtlProcessSummary::all();

            $selectArray = [
                'temp_grn_dtl_receive_summary.lot_grnno AS lot_grnno',
                'temp_grn_dtl_receive_summary.grndate',
                'temp_grn_dtl_receive_summary.supplier_name',
                'temp_grn_dtl_receive_summary.SizeDescription',
                'temp_grn_dtl_receive_summary.fish_type_id AS fish_type_id',
                'temp_grn_dtl_receive_summary.FishName AS FishName',
                'temp_grn_dtl_receive_summary.quality_grade AS quality_grade',
                'temp_grn_dtl_receive_summary.presentation AS presentation',

                'temp_grn_dtl_receive_summary.countlot_serial_no AS RcvPcs',
                'temp_grn_dtl_receive_summary.sumnet_weight AS RcvWeight',

                'temp_grn_dtl_process_summary.item_Status AS item_Status',

                'temp_grn_dtl_process_summary.countlot_serial_no AS ProcessPcs',
                'temp_grn_dtl_process_summary.sumnet_weight AS ProcessWgt',

                'temp_grn_dtl_process_mode_summary.item_process_mode AS item_process_mode',

                'temp_grn_dtl_process_mode_summary.countlot_serial_no AS NoofPcs',
                'temp_grn_dtl_process_mode_summary.sumnet_weight AS PcsWgt',

                'temp_grn_dtl_process_mode_summary.batch_weight AS batch_weight',
                'temp_grn_dtl_process_mode_summary.std_Wg AS std_Wg',
                'temp_grn_dtl_process_mode_summary.prod_wg AS prod_wg',
                'temp_grn_dtl_process_mode_summary.pack_wg AS pack_wg',
                'temp_grn_dtl_process_mode_summary.tfr_typ_0_wg AS tfr_typ_0_wg',
                'temp_grn_dtl_process_mode_summary.tfr_typ_1_wg AS tfr_typ_1_wg',
                'temp_grn_dtl_process_mode_summary.rej_typ_0_wg AS rej_typ_0_wg',
                'temp_grn_dtl_process_mode_summary.rej_typ_1_wg AS rej_typ_1_wg',
                'temp_grn_dtl_process_mode_summary.exp_wg AS exp_wg',
                'temp_grn_dtl_process_mode_summary.gross_prod_wg AS gross_prod_wg',
                'temp_grn_dtl_process_mode_summary.net_prod_wg AS net_prod_wg'
            ];

            $reportData =  DB::table('temp_grn_dtl_process_summary');

            //assign local Request to Global Variable
            $this->x = $request;
            $reportData =   $reportData->join(
                'temp_grn_dtl_process_mode_summary',
                function ($join) {
                    $joins = $this->createJoins('mode_summary', $join, $this->x);
                }
            );
            $reportData =   $reportData->leftJoin(
                'temp_grn_dtl_receive_summary',
                function ($join) {
                    $joins = $this->createJoins('receive_summary', $join, $this->x);
                }
            );
                // ->join('buying_fish_grn_hd', 'buying_fish_grn_hd.grnno', '=', 'temp_grn_dtl_process_summary.lot_grnno')
                // ->join('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id')

                if ($request->grn_no != 'false') {
                    $reportData = $reportData->orderBy('temp_grn_dtl_receive_summary.lot_grnno');
                }
                if ($request->supplier != 'false') {
                    $reportData = $reportData->orderBy('temp_grn_dtl_receive_summary.supplier_name');
                }
                if ($request->fishType != 'false') {
                    $reportData = $reportData->orderBy('temp_grn_dtl_receive_summary.FishName');
                }
                if ($request->presentation != 'false') {
                    $reportData = $reportData->orderBy('temp_grn_dtl_receive_summary.presentation');
                }
                if ($request->grade != 'false') {
                    $reportData = $reportData->orderBy('temp_grn_dtl_receive_summary.quality_grade');
                }
                if ($request->size != 'false') {
                    $reportData = $reportData->orderBy('temp_grn_dtl_receive_summary.SizeDescription');
                }


                $reportData =   $reportData ->select($selectArray)
                ->orderBy('temp_grn_dtl_receive_summary.lot_grnno')
                ->get();

            return $this->responseBody(true, "generateReport", "Generated", $reportData);
        } catch (Exception $ex) {
            return $this->responseBody(false, "generateReport", "Something went wrong", $ex->getMessage());
        }
    }

    function create_grn_dtl_receive_summary(Request $request)
    {
        try {
            $selectArray = [
                DB::raw('GROUP_CONCAT(buying_fish_grn_dtl.id) AS GroupedIds'),
                // 'buying_fish_grn_dtl.id AS grnDtlId',
                // 'buying_fish_grn_dtl.lot_grnno AS lot_grnno',
                'buying_fish_grn_dtl.fish_type_id AS fish_type_id',
                'sf_fish_species.FishName AS FishName',
                // 'buying_fish_grn_dtl.quality_grade AS quality_grade',
                // 'buying_fish_grn_dtl.presentation AS presentation',
                'buying_fish_grn_hd.grndate',
                'buying_suppliers.supplier_name',
                // 'buying_grn_fish_size_matrix.SizeDescription',
                DB::raw('count( buying_fish_grn_dtl.lot_serial_no) AS countlot_serial_no'),
                DB::raw('sum(buying_fish_grn_dtl.net_weight) AS sumnet_weight')
            ];
            $groupByArray = [
                // 'buying_fish_grn_dtl.lot_grnno',
                'buying_fish_grn_dtl.fish_type_id',
                // 'buying_fish_grn_dtl.quality_grade',
                // 'buying_fish_grn_dtl.presentation'
            ];
            $grn_dtl_receive_summary = DB::table('buying_fish_grn_dtl')
                ->join('sf_fish_species', 'buying_fish_grn_dtl.fish_type_id', '=', 'sf_fish_species.id')
                ->join('buying_fish_grn_hd', 'buying_fish_grn_hd.grnno', '=', 'buying_fish_grn_dtl.lot_grnno')
                ->join('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id')
                ->join('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl.item_size_id');
            // ->where('buying_fish_grn_dtl.lot_grnno', 305);
            // ->where('buying_fish_grn_dtl.fish_type_id', 1);


            //filters bigin
            if ($request->grn_no != 'false') {
                array_push($selectArray,  'buying_fish_grn_dtl.lot_grnno');
                array_push($groupByArray,  'buying_fish_grn_dtl.lot_grnno');
                if ($request->grn_no != null) {
                    $grn_dtl_receive_summary = $grn_dtl_receive_summary->whereIn('buying_fish_grn_dtl.lot_grnno', $request->grn_no);
                }
            }
            if ($request->startDate != 0 && $request->endDate != 0) {
                $grn_dtl_receive_summary = $grn_dtl_receive_summary
                    ->whereBetween('buying_fish_grn_hd.grndate', [$request->startDate, $request->endDate]);
            }
            if ($request->has('supplier') && $request->supplier != null) {
                $grn_dtl_receive_summary = $grn_dtl_receive_summary->whereIn('buying_fish_grn_hd.supplier_id', $request->supplier);
            }
            if ($request->has('fishType') && $request->fishType != null) {
                $grn_dtl_receive_summary = $grn_dtl_receive_summary->whereIn('buying_fish_grn_dtl.fish_type_id', $request->fishType);
            }
            if ($request->presentation != 'false') {
                array_push($selectArray,  'buying_fish_grn_dtl.presentation');
                array_push($groupByArray,  'buying_fish_grn_dtl.presentation');
                if ($request->presentation != null) {
                    $grn_dtl_receive_summary = $grn_dtl_receive_summary->whereIn('buying_fish_grn_dtl.presentation', $request->presentation);
                }
            }
            if ($request->grade != 'false') {
                array_push($selectArray,  'buying_fish_grn_dtl.quality_grade');
                array_push($groupByArray,  'buying_fish_grn_dtl.quality_grade');
                if ($request->grade != null) {
                    $grn_dtl_receive_summary = $grn_dtl_receive_summary->whereIn('buying_fish_grn_dtl.quality_grade', $request->grade);
                }
            }
            if ($request->size != 'false') {
                array_push($selectArray, 'buying_grn_fish_size_matrix.SizeDescription');
                array_push($groupByArray, 'buying_grn_fish_size_matrix.SizeDescription');
                if ($request->size != null) {
                    $grn_dtl_receive_summary = $grn_dtl_receive_summary->whereIn('buying_grn_fish_size_matrix.SizeDescription', $request->size);
                }
            }
            //filters end

            $grn_dtl_receive_summary = $grn_dtl_receive_summary->groupBy($groupByArray)
                ->select($selectArray)
                // ->where('buying_fish_grn_dtl.lot_grnno',305)
                ->orderBy('buying_fish_grn_dtl.lot_serial_no')
                ->get();

            // creating a  temporrary table for tempory data
            // DB::statement(
            //     'CREATE TEMPORARY TABLE temp_grn_dtl_receive_summary (
            //         lot_grnno varchar(40),
            //         fish_type_id varchar(20),
            //         FishName varchar(50),
            //         quality_grade varchar(50),
            //         presentation varchar(50),
            //         grndate varchar(50),
            //         SizeDescription varchar(50),
            //         supplier_name varchar(255),
            //         countlot_serial_no DOUBLE(11,2),
            //         sumnet_weight DOUBLE(11,2),
            //         GroupedIds MEDIUMTEXT
            //     );'
            // );
            Schema::create('temp_grn_dtl_receive_summary', function (Blueprint $table) {
                $table->string('lot_grnno',40);
                $table->string('fish_type_id',20);
                $table->string('FishName',50);
                $table->string('quality_grade',50);
                $table->string('presentation',50);
                $table->string('grndate',50);
                $table->string('SizeDescription',50);
                $table->string('supplier_name',255);
                $table->double('countlot_serial_no',11,2);
                $table->double('sumnet_weight',11,2);
                $table->mediumText('GroupedIds',40);
                $table->temporary();
            });
            if ($grn_dtl_receive_summary) {
                $array = json_decode(json_encode($grn_dtl_receive_summary), true);

                //insert data in 5000 chunks to avoid toomany placeholders error
                foreach (array_chunk($array, 5000) as $chunck) {
                    TemporyGrnDtlReceiveSummary::insert($chunck);
                }
            }
            //  $this->resultToArray(TemporyGrnDtlReceiveSummary::all('GroupedIds'));

            $this->create_grn_dtl_process_summary($request, $this->resultToArray(TemporyGrnDtlReceiveSummary::all('GroupedIds')));
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function create_grn_dtl_process_summary(Request $request, $idArray)
    {
        try {
            $selectArray = [
                DB::raw('GROUP_CONCAT(buying_fish_grn_dtl.id) AS GroupedIds'),
                // 'buying_fish_grn_dtl.id AS grnDtlId',
                // 'buying_fish_grn_dtl.lot_grnno AS lot_grnno',
                'buying_fish_grn_dtl.fish_type_id AS fish_type_id',
                // 'buying_fish_grn_dtl.quality_grade AS quality_grade',
                // 'buying_fish_grn_dtl.presentation AS presentation',
                DB::raw('count(buying_fish_grn_dtl.lot_serial_no) AS countlot_serial_no'),
                DB::raw('sum(buying_fish_grn_dtl.net_weight) AS sumnet_weight'),
                'buying_fish_grn_dtl.item_Status AS item_Status',
                // 'buying_grn_fish_size_matrix.SizeDescription',

            ];
            $groupByArray = [
                // 'buying_fish_grn_dtl.lot_grnno',
                'buying_fish_grn_dtl.fish_type_id',
                // 'buying_fish_grn_dtl.quality_grade',
                // 'buying_fish_grn_dtl.presentation'
            ];
            $temp_grn_dtl_process_summary = DB::table('buying_fish_grn_dtl')
                ->join('sf_fish_species', 'buying_fish_grn_dtl.fish_type_id', '=', 'sf_fish_species.id')
                ->join('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl.item_size_id')

                // ->where('buying_fish_grn_dtl.lot_grnno', 305)
                // ->where('buying_fish_grn_dtl.fish_type_id', 1)
                ->where('buying_fish_grn_dtl.item_Status', 1)
                ->whereIn('buying_fish_grn_dtl.id', $idArray);

            //filters bigin
            if ($request->grn_no != 'false') {
                array_push($selectArray,  'buying_fish_grn_dtl.lot_grnno');
                array_push($groupByArray,  'buying_fish_grn_dtl.lot_grnno');
                if ($request->grn_no != null) {
                    $temp_grn_dtl_process_summary = $temp_grn_dtl_process_summary->whereIn('buying_fish_grn_dtl.lot_grnno', $request->grn_no);
                }
            }
            if ($request->presentation != 'false') {
                array_push($selectArray,  'buying_fish_grn_dtl.presentation');
                array_push($groupByArray,  'buying_fish_grn_dtl.presentation');
                // $grn_dtl_receive_summary = $grn_dtl_receive_summary->orderBy('buying_fish_grn_dtl_pay_rate.rm_presentation', 'asc');

                if ($request->presentation != null) {
                    $temp_grn_dtl_process_summary = $temp_grn_dtl_process_summary->whereIn('buying_fish_grn_dtl.presentation', $request->presentation);
                }
            }
            if ($request->grade != 'false') {
                array_push($selectArray,  'buying_fish_grn_dtl.quality_grade');
                array_push($groupByArray,  'buying_fish_grn_dtl.quality_grade');
                if ($request->grade != null) {
                    $temp_grn_dtl_process_summary = $temp_grn_dtl_process_summary->whereIn('buying_fish_grn_dtl.quality_grade', $request->grade);
                }
            }
            if ($request->size != 'false') {
                array_push($selectArray, 'buying_grn_fish_size_matrix.SizeDescription');
                array_push($groupByArray, 'buying_grn_fish_size_matrix.SizeDescription');
                if ($request->size != null) {
                    $temp_grn_dtl_process_summary = $temp_grn_dtl_process_summary->whereIn('buying_grn_fish_size_matrix.SizeDescription', $request->size);
                }
            }
            //filters end

             $temp_grn_dtl_process_summary = $temp_grn_dtl_process_summary->groupBy($groupByArray)
                ->select($selectArray)
                // ->where('buying_fish_grn_dtl.lot_grnno',305)

                ->orderBy('buying_fish_grn_dtl.lot_serial_no')
                ->get();

            //creating a  temporrary table for tempory data
            // DB::statement(
            //     'CREATE TEMPORARY TABLE temp_grn_dtl_process_summary (
            //             lot_grnno varchar(40),
            //             fish_type_id varchar(20),
            //             quality_grade varchar(50),
            //             presentation varchar(50),
            //             countlot_serial_no int(11),
            //             sumnet_weight DOUBLE(11,2),
            //             item_Status int(11),
            //             SizeDescription varchar(50),
            //             GroupedIds MEDIUMTEXT
            //             );'
            // );
            Schema::create('temp_grn_dtl_process_summary', function (Blueprint $table) {
                $table->string('lot_grnno',40);
                $table->string('fish_type_id',20);
                $table->string('quality_grade',50);
                $table->string('presentation',50);
                $table->integer('countlot_serial_no');
                $table->double('sumnet_weight',11,2);
                $table->integer('item_Status');
                $table->string('SizeDescription',50);
                $table->mediumText('GroupedIds');
                $table->temporary();
            });
            if ($temp_grn_dtl_process_summary) {
                $array = json_decode(json_encode($temp_grn_dtl_process_summary), true);

                //insert data in 5000 chunks to avoid toomany placeholders error
                foreach (array_chunk($array, 5000) as $chunck) {
                    TemporyGrnDtlProcessSummary::insert($chunck);
                }
            }

            $this->create_grn_dtl_process_mode_summary($request, $this->resultToArray(TemporyGrnDtlProcessSummary::all('GroupedIds')));
            // return TemporyGRNDtlProcessModeSummary::all();


        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function create_grn_dtl_process_mode_summary(Request $request, $idArray)
    {
        try {

            $selectArray = [
                //get batch weigt here
                // 'buying_fish_grn_dtl_yield.batch_weight',
                // 'buying_fish_grn_dtl.lot_grnno AS lot_grnno',
                'buying_fish_grn_dtl.fish_type_id AS fish_type_id',
                // 'buying_fish_grn_dtl.quality_grade AS quality_grade',
                // 'buying_fish_grn_dtl.presentation AS presentation',
                'buying_fish_grn_dtl.item_Status AS item_Status',
                'buying_fish_grn_dtl.item_process_mode AS item_process_mode',
                DB::raw('count(buying_fish_grn_dtl.lot_serial_no) AS countlot_serial_no'),
                DB::raw('sum(buying_fish_grn_dtl.net_weight) AS sumnet_weight'),
                DB::raw('sum( buying_fish_grn_dtl_yield.std_wg ) AS std_Wg'),
                DB::raw('sum( buying_fish_grn_dtl_yield.prod_wg ) AS prod_wg'),
                DB::raw('sum( buying_fish_grn_dtl_yield.pack_wg ) AS pack_wg'),
                DB::raw('sum( buying_fish_grn_dtl_yield.tfr_typ_0_wg ) AS tfr_typ_0_wg'),
                DB::raw('sum( buying_fish_grn_dtl_yield.tfr_typ_1_wg ) AS tfr_typ_1_wg'),
                DB::raw('sum( buying_fish_grn_dtl_yield.rej_typ_1_wg ) AS rej_typ_0_wg'),
                DB::raw('sum( buying_fish_grn_dtl_yield.rej_typ_1_wg ) AS rej_typ_1_wg'),
                DB::raw('sum( buying_fish_grn_dtl_yield.exp_wg ) AS exp_wg'),
                DB::raw('sum( buying_fish_grn_dtl_yield.gross_prod_wg ) AS gross_prod_wg'), //
                DB::raw('sum( buying_fish_grn_dtl_yield.net_prod_wg ) AS net_prod_wg'),
                DB::raw('sum( buying_fish_grn_dtl_yield.batch_weight ) AS batch_weight'),

            ];
            $groupByArray = [
                // 'buying_fish_grn_dtl.lot_grnno',
                'buying_fish_grn_dtl.fish_type_id',
                // 'buying_fish_grn_dtl.quality_grade',
                // 'buying_fish_grn_dtl.presentation',
            ];
            $grn_dtl_process_mode_summary = DB::table('buying_fish_grn_dtl')
                ->join('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl.fish_type_id')
                ->join('buying_fish_grn_dtl_yield', 'buying_fish_grn_dtl_yield.grn_dtl_lot_id', '=', 'buying_fish_grn_dtl.lot_id')
                ->join('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl.item_size_id')

                // ->where('buying_fish_grn_dtl.lot_grnno', 305)
                // ->where('buying_fish_grn_dtl.fish_type_id', 1)
                ->where('buying_fish_grn_dtl.item_Status', 1)
                ->whereIn('buying_fish_grn_dtl.id', $idArray);

            //filters bigin
            if ($request->grn_no != 'false') {
                array_push($selectArray,  'buying_fish_grn_dtl.lot_grnno');
                array_push($groupByArray,  'buying_fish_grn_dtl.lot_grnno');
                if ($request->grn_no != null) {
                    $grn_dtl_process_mode_summary = $grn_dtl_process_mode_summary->whereIn('buying_fish_grn_dtl.lot_grnno', $request->grn_no);
                }
            }
            if ($request->presentation != 'false') {
                array_push($selectArray,  'buying_fish_grn_dtl.presentation');
                array_push($groupByArray,  'buying_fish_grn_dtl.presentation');
                // $grn_dtl_receive_summary = $grn_dtl_receive_summary->orderBy('buying_fish_grn_dtl_pay_rate.rm_presentation', 'asc');

                if ($request->presentation != null) {
                    $grn_dtl_process_mode_summary = $grn_dtl_process_mode_summary->whereIn('buying_fish_grn_dtl.presentation', $request->presentation);
                }
            }
            if ($request->grade != 'false') {
                array_push($selectArray,  'buying_fish_grn_dtl.quality_grade');
                array_push($groupByArray,  'buying_fish_grn_dtl.quality_grade');
                if ($request->grade != null) {
                    $grn_dtl_process_mode_summary = $grn_dtl_process_mode_summary->whereIn('buying_fish_grn_dtl.quality_grade', $request->grade);
                }
            }
            if ($request->size != 'false') {
                array_push($selectArray, 'buying_grn_fish_size_matrix.SizeDescription');
                array_push($groupByArray, 'buying_grn_fish_size_matrix.SizeDescription');
                if ($request->size != null) {
                    $grn_dtl_process_mode_summary = $grn_dtl_process_mode_summary->whereIn('buying_grn_fish_size_matrix.SizeDescription', $request->size);
                }
            }
            //filters end

            $grn_dtl_process_mode_summary = $grn_dtl_process_mode_summary->groupBy($groupByArray)
                ->select($selectArray)
                ->orderBy('buying_fish_grn_dtl.lot_serial_no')
                // ->where('buying_fish_grn_dtl.lot_grnno',305)

                ->get();


            //creating a  temporrary table for tempory data
            // DB::statement(
            //     'CREATE TEMPORARY TABLE temp_grn_dtl_process_mode_summary (
            //             lot_grnno varchar(40),
            //             fish_type_id varchar(20),
            //             quality_grade varchar(50),
            //             presentation varchar(50),
            //             item_Status int(11),
            //             item_process_mode int(11),
            //             countlot_serial_no int(11),
            //             SizeDescription varchar(50),
            //             sumnet_weight DOUBLE(11,2),
            //             batch_weight DOUBLE(11,2),
            //             std_Wg DOUBLE(11,2),
            //             prod_wg DOUBLE(11,2),
            //             pack_wg DOUBLE(11,2),
            //             tfr_typ_0_wg DOUBLE(11,2),
            //             tfr_typ_1_wg DOUBLE(11,2),
            //             rej_typ_0_wg DOUBLE(11,2),
            //             rej_typ_1_wg DOUBLE(11,2),
            //             exp_wg DOUBLE(11,2),
            //             gross_prod_wg DOUBLE(11,2),
            //             net_prod_wg DOUBLE(11,2)
            //             );'
            // );
            Schema::create('temp_grn_dtl_process_mode_summary', function (Blueprint $table) {
                $table->string('lot_grnno',40);
                $table->string('fish_type_id',20);
                $table->string('quality_grade',50);
                $table->string('presentation',50);
                $table->integer('item_Status');
                $table->integer('item_process_mode');
                $table->integer('countlot_serial_no');
                $table->string('SizeDescription',50);
                $table->double('sumnet_weight',11,2);
                $table->double('batch_weight',11,2);
                $table->double('std_Wg',11,2);
                $table->double('prod_wg',11,2);
                $table->double('pack_wg',11,2);
                $table->double('tfr_typ_0_wg',11,2);
                $table->double('tfr_typ_1_wg',11,2);
                $table->double('rej_typ_0_wg',11,2);
                $table->double('rej_typ_1_wg',11,2);
                $table->double('exp_wg',11,2);
                $table->double('gross_prod_wg',11,2);
                $table->double('net_prod_wg',11,2);
                $table->temporary();
            });
            if ($grn_dtl_process_mode_summary) {
                $array = json_decode(json_encode($grn_dtl_process_mode_summary), true);

                //insert data in 5000 chunks to avoid toomany placeholders error
                foreach (array_chunk($array, 5000) as $chunck) {
                    TemporyGRNDtlProcessModeSummary::insert($chunck);
                }
            }

            $this->create_grn_dtl_receive_summary($request, $idArray);
            // return TemporyGrnDtlReceiveSummary::all();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function resultToArray($results)
    {
        $array = [];
        foreach ($results as $result) {
            $data = explode(',', $result->GroupedIds);
            foreach ($data as $id) {
                array_push($array, (int)$id);
            }
        }
        return $array;
    }
    function createJoins($table, $join, Request $request)
    {
        $joinArray = [];
        switch ($table) {
            case 'mode_summary':
                array_push(
                    $joinArray,
                    // $join->on('temp_grn_dtl_process_summary.lot_grnno', '=', 'temp_grn_dtl_process_mode_summary.lot_grnno'),
                    $join->on('temp_grn_dtl_process_summary.fish_type_id', '=', 'temp_grn_dtl_process_mode_summary.fish_type_id'),
                    // $join->on('temp_grn_dtl_process_summary.quality_grade', '=', 'temp_grn_dtl_process_mode_summary.quality_grade'),
                    // $join->on('temp_grn_dtl_process_summary.presentation', '=', 'temp_grn_dtl_process_mode_summary.presentation'),
                    $join->on('temp_grn_dtl_process_summary.item_Status', '=', 'temp_grn_dtl_process_mode_summary.item_Status'),
                );

                if ($request->presentation != 'false') {
                    array_push($joinArray,  $join->on('temp_grn_dtl_process_summary.presentation', '=', 'temp_grn_dtl_process_mode_summary.presentation'));
                }
                if ($request->grade != 'false') {
                    array_push($joinArray,  $join->on('temp_grn_dtl_process_summary.quality_grade', '=', 'temp_grn_dtl_process_mode_summary.quality_grade'));
                }
                if ($request->size != 'false') {
                    array_push($joinArray,  $join->on('temp_grn_dtl_process_summary.SizeDescription', '=', 'temp_grn_dtl_process_mode_summary.SizeDescription'));
                }
                if ($request->grn_no != 'false') {
                    array_push($joinArray,  $join->on('temp_grn_dtl_process_summary.lot_grnno', '=', 'temp_grn_dtl_process_mode_summary.lot_grnno'));
                }

                break;
            case 'receive_summary':
                array_push(
                    $joinArray,
                    // $join->on('temp_grn_dtl_receive_summary.lot_grnno', '=', 'temp_grn_dtl_process_summary.lot_grnno'),
                    $join->on('temp_grn_dtl_receive_summary.fish_type_id', '=', 'temp_grn_dtl_process_summary.fish_type_id'),
                    // $join->on('temp_grn_dtl_receive_summary.quality_grade', '=', 'temp_grn_dtl_process_summary.quality_grade'),
                    // $join->on('temp_grn_dtl_receive_summary.presentation', '=', 'temp_grn_dtl_process_summary.presentation'),
                );

                if ($request->presentation != 'false') {
                    array_push($joinArray, $join->on('temp_grn_dtl_receive_summary.presentation', '=', 'temp_grn_dtl_process_summary.presentation'));
                }
                if ($request->grade != 'false') {
                    array_push($joinArray, $join->on('temp_grn_dtl_receive_summary.quality_grade', '=', 'temp_grn_dtl_process_summary.quality_grade'));
                }
                if ($request->size != 'false') {
                    array_push($joinArray,  $join->on('temp_grn_dtl_receive_summary.SizeDescription', '=', 'temp_grn_dtl_process_summary.SizeDescription'));
                }
                if ($request->grn_no != 'false') {
                    array_push($joinArray,  $join->on('temp_grn_dtl_receive_summary.lot_grnno', '=', 'temp_grn_dtl_process_summary.lot_grnno'));
                }
                break;
            default:
                # code...
                break;

                return $joinArray;
        }
    }
}
