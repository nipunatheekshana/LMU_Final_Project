<?php

namespace Modules\Buying\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Buying\Entities\BuyingFishSize;
use Modules\Buying\Entities\GRNDetail;
use Modules\Buying\Entities\GrnDetailPayRate;
use Modules\Buying\Entities\Supplier;
use Modules\Sf\Entities\Fishspecies;
use Modules\Sf\Entities\PresentationType;

class periodicPurchaseSummaryController extends Controller
{
    use commonFeatures;
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
    public function generateReport(Request $request)
    {
        try {
            // return $request->all();

            $selectArray = [
                // 'buying_suppliers.supplier_name',
                // 'sf_fish_species.FishName',
                // 'buying_fish_grn_dtl_pay_rate.rm_presentation',
                // 'buying_fish_grn_dtl_pay_rate.pay_grade',
                // 'buying_grn_fish_size_matrix.SizeDescription',
                DB::raw("AVG( buying_fish_grn_dtl_pay_rate.unit_rate_local_cur ) AS localAvgWeight"),
                DB::raw("AVG( buying_fish_grn_dtl_pay_rate.unit_rate_base_cur ) AS baseAvgWeight"),
                DB::raw("(`buying_fish_grn_dtl_pay_rate`.`rm_tot_weight`/SUM( `buying_fish_grn_dtl_pay_rate`.`rm_tot_weight` )over())*100 AS presentage"),
                DB::raw("SUM( buying_fish_grn_dtl_pay_rate.rm_qty ) AS rm_qty"),
                DB::raw("SUM( buying_fish_grn_dtl_pay_rate.rm_tot_weight ) AS rm_tot_weight"),
            ];
            $groupByArray = [
                // 'buying_suppliers.supplier_name',
                // 'sf_fish_species.FishName',
                // 'buying_fish_grn_dtl_pay_rate.rm_presentation',
                // 'buying_fish_grn_dtl_pay_rate.pay_grade',
                // 'buying_grn_fish_size_matrix.SizeDescription',
                // 'buying_fish_grn_dtl_pay_rate.rm_qty',
                // 'buying_fish_grn_dtl_pay_rate.rm_tot_weight',
            ];
            $reportData = DB::table('buying_fish_grn_dtl_pay_rate')
                ->leftJoin('buying_fish_grn_hd', 'buying_fish_grn_hd.grnno', '=', 'buying_fish_grn_dtl_pay_rate.lot_grnno')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl_pay_rate.fish_type_id');

            if ($request->startDate != 0 && $request->endDate != 0) {
                $reportData = $reportData->whereBetween('buying_fish_grn_hd.grndate', [$request->startDate, $request->endDate]);
            }

            if ($request->has('fishType') && $request->fishType != null) {
                $reportData = $reportData->whereIn('buying_fish_grn_dtl_pay_rate.fish_type_id', $request->fishType);
            }
            if ($request->reportType == 'supplier') {
                //if report type is supplier
                array_push($selectArray, 'buying_suppliers.supplier_name');
                array_push($selectArray, 'sf_fish_species.FishName');
                array_push($groupByArray, 'buying_suppliers.supplier_name');
                array_push($groupByArray, 'sf_fish_species.FishName');

                $reportData = $reportData->leftJoin('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id')
                    ->orderBy('buying_suppliers.supplier_name', 'asc')
                    ->orderBy('sf_fish_species.FishName', 'asc');

                if ($request->supplier != null) {
                    $reportData = $reportData->whereIn('buying_fish_grn_hd.supplier_id', $request->supplier);
                }
            } elseif ($request->reportType == 'fishType') {
                //if report type is fishtype
                array_push($selectArray, 'sf_fish_species.FishName');
                array_push($groupByArray, 'sf_fish_species.FishName');


                if ($request->supplier != 'false') {
                    array_push($selectArray, 'buying_suppliers.supplier_name');
                    array_push($groupByArray, 'buying_suppliers.supplier_name');

                    $reportData = $reportData->leftJoin('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id')
                        ->orderBy('sf_fish_species.FishName', 'asc')
                        ->orderBy('buying_suppliers.supplier_name', 'asc');

                    if ($request->supplier != null) {
                        $reportData = $reportData->whereIn('buying_fish_grn_hd.supplier_id', $request->supplier);
                    }
                }
            }
            if ($request->presentation != 'false') {
                array_push($selectArray,  'buying_fish_grn_dtl_pay_rate.rm_presentation');
                array_push($groupByArray,  'buying_fish_grn_dtl_pay_rate.rm_presentation');
                $reportData = $reportData->orderBy('buying_fish_grn_dtl_pay_rate.rm_presentation', 'asc');

                if ($request->presentation != null) {
                    $reportData = $reportData->whereIn('buying_fish_grn_dtl_pay_rate.rm_presentation', $request->presentation);
                }
            }
            if ($request->grade != 'false') {
                array_push($selectArray, 'buying_fish_grn_dtl_pay_rate.pay_grade');
                array_push($groupByArray, 'buying_fish_grn_dtl_pay_rate.pay_grade');
                $reportData = $reportData->orderBy('buying_fish_grn_dtl_pay_rate.pay_grade', 'asc');

                if ($request->grade != null) {
                    $reportData = $reportData->whereIn('buying_fish_grn_dtl_pay_rate.pay_grade', $request->grade);
                }
            }
            if ($request->size != 'false') {
                array_push($selectArray, 'buying_grn_fish_size_matrix.SizeDescription');
                array_push($groupByArray, 'buying_grn_fish_size_matrix.SizeDescription');
                $reportData = $reportData->leftJoin('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl_pay_rate.item_size')
                    ->orderBy('buying_grn_fish_size_matrix.SizeDescription', 'asc');

                if ($request->size != null) {
                    $reportData = $reportData->whereIn('buying_grn_fish_size_matrix.SizeDescription', $request->size);
                }
            }
            $reportData =  $reportData->groupBy($groupByArray)
                ->select($selectArray)
                ->get();

            $charts = $this->generateCharts($request->all());



            return $this->responseBody(true, "generateReport", "found", ['reportData' => $reportData, 'charts' => $charts]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "generateReport", "Something went wrong", $ex->getMessage());
        }
    }
    public function generateCharts($request)
    {
            $request = new Request($request);

        return $charts=[
            'WeightSummaryChart'=>$this->WeightSummaryChart($request),
            'GradeSummaryChart'=>$this->GradeSummaryChart($request),
            'PresentationSummaryChart'=>$this->PresentationSummaryChart($request),
        ];

    }
    public function WeightSummaryChart(Request $request){
        try {
            $selectArray = [DB::raw("Sum( buying_fish_grn_dtl_pay_rate.rm_tot_weight )AS weight")];
            $groupByArray = [];
            $chartData = DB::table('buying_fish_grn_dtl_pay_rate')
                ->leftJoin('buying_fish_grn_hd', 'buying_fish_grn_hd.grnno', '=', 'buying_fish_grn_dtl_pay_rate.lot_grnno')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl_pay_rate.fish_type_id')
                ->leftJoin('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id');
            if ($request->reportType == 'supplier') {
                array_push($selectArray, 'buying_suppliers.supplier_name',);
                array_push($groupByArray, 'buying_suppliers.supplier_name');
            } elseif ($request->reportType == 'fishType') {
                array_push($selectArray, 'sf_fish_species.FishName',);
                array_push($groupByArray, 'sf_fish_species.FishName');
            }
            if ($request->startDate != 0 && $request->endDate != 0) {
                $chartData = $chartData->whereBetween('buying_fish_grn_hd.grndate', [$request->startDate, $request->endDate]);
            }
            if ($request->has('fishType') && $request->fishType != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_dtl_pay_rate.fish_type_id', $request->fishType);
            }
            if ($request->supplier != 'false' && $request->supplier != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_hd.supplier_id', $request->supplier);
            }
            if ($request->presentation != 'false' && $request->presentation != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_dtl_pay_rate.rm_presentation', $request->presentation);
            }
            if ($request->grade != 'false' && $request->grade != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_dtl_pay_rate.pay_grade', $request->grade);
            }
            if ($request->size != 'false' && $request->size != null) {
                $chartData = $chartData->leftJoin('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl_pay_rate.item_size')
                    ->whereIn('buying_grn_fish_size_matrix.SizeDescription', $request->size);
            }
            $chartData =  $chartData->groupBy($groupByArray)
                ->select($selectArray)
                ->get();

            return $chartData;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function GradeSummaryChart(Request $request){
        try {
            // return $request->all();
            $selectArray = [
                'pay_grade',
                DB::raw("Sum( buying_fish_grn_dtl_pay_rate.rm_tot_weight )AS weight")
            ];
            $groupByArray = ['pay_grade'];
            $chartData = DB::table('buying_fish_grn_dtl_pay_rate')
                ->leftJoin('buying_fish_grn_hd', 'buying_fish_grn_hd.grnno', '=', 'buying_fish_grn_dtl_pay_rate.lot_grnno')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl_pay_rate.fish_type_id')
                ->leftJoin('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id')
                ->where('buying_fish_grn_dtl_pay_rate.fish_type_id',(int)$request->gradeWise);

            if ($request->startDate != 0 && $request->endDate != 0) {
                $chartData = $chartData->whereBetween('buying_fish_grn_hd.grndate', [$request->startDate, $request->endDate]);
            }
            if ($request->has('fishType') && $request->fishType != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_dtl_pay_rate.fish_type_id', $request->fishType);
            }
            if ($request->supplier != 'false' && $request->supplier != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_hd.supplier_id', $request->supplier);
            }
            if ($request->presentation != 'false' && $request->presentation != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_dtl_pay_rate.rm_presentation', $request->presentation);
            }
            if ($request->grade != 'false' && $request->grade != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_dtl_pay_rate.pay_grade', $request->grade);
            }
            if ($request->size != 'false' && $request->size != null) {
                $chartData = $chartData->leftJoin('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl_pay_rate.item_size')
                    ->whereIn('buying_grn_fish_size_matrix.SizeDescription', $request->size);
            }
            $chartData =  $chartData->groupBy($groupByArray)
                ->select($selectArray)
                ->get();

            return $chartData;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function PresentationSummaryChart(Request $request){
        try {
            // return $request->all();
            $selectArray = [
                'rm_presentation',
                DB::raw("Sum( buying_fish_grn_dtl_pay_rate.rm_tot_weight )AS weight")
            ];
            $groupByArray = ['rm_presentation'];
            $chartData = DB::table('buying_fish_grn_dtl_pay_rate')
                ->leftJoin('buying_fish_grn_hd', 'buying_fish_grn_hd.grnno', '=', 'buying_fish_grn_dtl_pay_rate.lot_grnno')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl_pay_rate.fish_type_id')
                ->leftJoin('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id')
                ->where('buying_fish_grn_dtl_pay_rate.fish_type_id',(int)$request->PresentationWise);

            if ($request->startDate != 0 && $request->endDate != 0) {
                $chartData = $chartData->whereBetween('buying_fish_grn_hd.grndate', [$request->startDate, $request->endDate]);
            }
            if ($request->has('fishType') && $request->fishType != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_dtl_pay_rate.fish_type_id', $request->fishType);
            }
            if ($request->supplier != 'false' && $request->supplier != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_hd.supplier_id', $request->supplier);
            }
            if ($request->presentation != 'false' && $request->presentation != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_dtl_pay_rate.rm_presentation', $request->presentation);
            }
            if ($request->grade != 'false' && $request->grade != null) {
                $chartData = $chartData->whereIn('buying_fish_grn_dtl_pay_rate.pay_grade', $request->grade);
            }
            if ($request->size != 'false' && $request->size != null) {
                $chartData = $chartData->leftJoin('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl_pay_rate.item_size')
                    ->whereIn('buying_grn_fish_size_matrix.SizeDescription', $request->size);
            }
            $chartData =  $chartData->groupBy($groupByArray)
                ->select($selectArray)
                ->get();

            return $chartData;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
