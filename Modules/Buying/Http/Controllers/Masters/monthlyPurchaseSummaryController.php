<?php

namespace Modules\Buying\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Buying\Entities\BuyingFishSize;
use Modules\Buying\Entities\GRNDetail;
use Modules\Buying\Entities\Supplier;
use Modules\Sf\Entities\FishGrade;
use Modules\Sf\Entities\FishSize;
use Modules\Sf\Entities\Fishspecies;
use Modules\Sf\Entities\PresentationType;

use function PHPUnit\Framework\isEmpty;

class monthlyPurchaseSummaryController extends Controller
{
    use commonFeatures;
    public function loadYears()
    {
        try {
            $years = [];

            $thisYear = (int)Carbon::now()->format('Y');

            for ($i = 0; $i < 10; $i++) {
                $year = $thisYear - $i;
                array_push($years, ['year' => $year]);
            }

            return $this->responseBody(true, "loadYears", "found",  $years);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadYears", "Something went wrong", $ex->getMessage());
        }
    }
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
            $FishGrade = GRNDetail::select('supplier_grade')->distinct('supplier_grade')->get();

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
                'GRNYear',
                // 'FishName',
                // 'supplier_name',
                // 'presentation',
                // 'supplier_grade',
                // 'SizeDescription',
                DB::raw("SUM( CASE WHEN `month` = 1 THEN net_weight END ) AS Jan"),
                DB::raw("SUM( CASE WHEN `month` = 2 THEN net_weight END ) AS Feb"),
                DB::raw("SUM( CASE WHEN `month` = 3 THEN net_weight END ) AS Mar"),
                DB::raw("SUM( CASE WHEN `month` = 4 THEN net_weight END ) AS Apr"),
                DB::raw("SUM( CASE WHEN `month` = 5 THEN net_weight END ) AS May"),
                DB::raw("SUM( CASE WHEN `month` = 6 THEN net_weight END ) AS Jun"),
                DB::raw("SUM( CASE WHEN `month` = 7 THEN net_weight END ) AS Jul"),
                DB::raw("SUM( CASE WHEN `month` = 8 THEN net_weight END ) AS Aug"),
                DB::raw("SUM( CASE WHEN `month` = 9 THEN net_weight END ) AS Sep"),
                DB::raw("SUM( CASE WHEN `month` = 10 THEN net_weight END ) AS Oct"),
                DB::raw("SUM( CASE WHEN `month` = 11 THEN net_weight END ) AS Nov"),
                DB::raw("SUM( CASE WHEN `month` = 12 THEN net_weight END ) AS 'Dec'")
            ];
            $groupByArray = [
                'GRNYear',
                // 'supplier_name',
                // 'FishName',
                // 'presentation',
                // 'supplier_grade',
                // 'SizeDescription'
            ];
            $reportData = DB::table('buying_fish_grn_dtl_monthly_purchase_summary')->orderBy('GRNYear', 'asc');

            if ($request->has('year') && $request->year != null) {
                $reportData = $reportData->whereIn('GRNYear', $request->year);
            }

            if ($request->has('fishType') && $request->fishType != null) {
                $reportData = $reportData->whereIn('fish_type_id', $request->fishType);
            }
            if ($request->reportType == 'supplier') {
                //if report type is supplier
                array_push($selectArray, 'supplier_name');
                array_push($selectArray, 'FishName');
                array_push($groupByArray, 'supplier_name');
                array_push($groupByArray, 'FishName');
                $reportData = $reportData->orderBy('supplier_name', 'asc')->orderBy('FishName', 'asc');

                if ($request->supplier != null) {
                    $reportData = $reportData->whereIn('supplier_id', $request->supplier);
                }
            } elseif ($request->reportType == 'fishType') {
                //if report type is fishtype
                array_push($selectArray, 'FishName');
                array_push($groupByArray, 'FishName');

                if ($request->supplier != 'false') {
                    array_push($selectArray, 'supplier_name');
                    array_push($groupByArray, 'supplier_name');

                    $reportData = $reportData->orderBy('FishName', 'asc')->orderBy('supplier_name', 'asc');

                    if ($request->supplier != null) {
                        $reportData = $reportData->whereIn('supplier_id', $request->supplier);
                    }
                }
            }
            if ($request->presentation != 'false') {
                array_push($selectArray, 'presentation');
                array_push($groupByArray, 'presentation');
                $reportData = $reportData->orderBy('presentation', 'asc');

                if ($request->presentation != null) {
                    $reportData = $reportData->whereIn('presentation', $request->presentation);
                }
            }
            if ($request->grade != 'false') {
                array_push($selectArray, 'supplier_grade');
                array_push($groupByArray, 'supplier_grade');
                $reportData = $reportData->orderBy('supplier_grade', 'asc');

                if ($request->grade != null) {
                    $reportData = $reportData->whereIn('supplier_grade', $request->grade);
                }
            }
            if ($request->size != 'false') {
                array_push($selectArray, 'SizeDescription');
                array_push($groupByArray, 'SizeDescription');
                $reportData = $reportData->orderBy('SizeDescription', 'asc');

                if ($request->size != null) {
                    $reportData = $reportData->whereIn('SizeDescription', $request->size);
                }
            }
            $reportData =  $reportData->groupBy($groupByArray)
                ->select($selectArray)
                ->get();


            // return $request->all();
            $chart = $this->generateChart($request->all());



            return $this->responseBody(true, "generateReport", "found",  ['reportData' => $reportData, 'chart' => $chart]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "generateReport", "Something went wrong", $ex->getMessage());
        }
    }
    private function generateChart($request)
    {
        try {
            $request = new Request($request);

            $selectArray = [
                'GRNYear',
                // 'FishName',
                DB::raw("SUM( CASE WHEN `month` = 1 THEN net_weight END ) AS Jan"),
                DB::raw("SUM( CASE WHEN `month` = 2 THEN net_weight END ) AS Feb"),
                DB::raw("SUM( CASE WHEN `month` = 3 THEN net_weight END ) AS Mar"),
                DB::raw("SUM( CASE WHEN `month` = 4 THEN net_weight END ) AS Apr"),
                DB::raw("SUM( CASE WHEN `month` = 5 THEN net_weight END ) AS May"),
                DB::raw("SUM( CASE WHEN `month` = 6 THEN net_weight END ) AS Jun"),
                DB::raw("SUM( CASE WHEN `month` = 7 THEN net_weight END ) AS Jul"),
                DB::raw("SUM( CASE WHEN `month` = 8 THEN net_weight END ) AS Aug"),
                DB::raw("SUM( CASE WHEN `month` = 9 THEN net_weight END ) AS Sep"),
                DB::raw("SUM( CASE WHEN `month` = 10 THEN net_weight END ) AS Oct"),
                DB::raw("SUM( CASE WHEN `month` = 11 THEN net_weight END ) AS Nov"),
                DB::raw("SUM( CASE WHEN `month` = 12 THEN net_weight END ) AS 'Dec'")
            ];
            $groupByArray = [
                'GRNYear',
            ];
            $reportData = DB::table('buying_fish_grn_dtl_monthly_purchase_summary');

            if ($request->has('year') && $request->year != null) {
                $reportData = $reportData->whereIn('GRNYear', $request->year);
            }
            if ($request->has('fishType') && $request->fishType != null) {
                $reportData = $reportData->whereIn('fish_type_id', $request->fishType);
            }
            if ($request->reportType == 'supplier') {
                //if report type is supplier
                array_push($groupByArray, 'supplier_name');
                array_push($selectArray, 'supplier_name');
                if ($request->supplier != null) {
                    $reportData = $reportData->whereIn('supplier_id', $request->supplier);
                }
            } elseif ($request->reportType == 'fishType') {
                //if report type is fishtype
                array_push($groupByArray, 'FishName');
                array_push($selectArray, 'FishName');
                if ($request->supplier != 'false') {
                    $reportData = $reportData->orderBy('supplier_name', 'asc');
                    if ($request->supplier != null) {
                        $reportData = $reportData->whereIn('supplier_id', $request->supplier);
                    }
                }
            }
            if ($request->presentation != 'false') {
                if ($request->presentation != null) {
                    $reportData = $reportData->whereIn('presentation', $request->presentation);
                }
            }
            if ($request->grade != 'false') {
                if ($request->grade != null) {
                    $reportData = $reportData->whereIn('supplier_grade', $request->grade);
                }
            }
            if ($request->size != 'false') {
                if ($request->size != null) {
                    $reportData = $reportData->whereIn('SizeDescription', $request->size);
                }
            }
            $reportData =  $reportData->groupBy($groupByArray)->orderBy(
                'GRNYear',
                'asc'
            )
                ->select($selectArray)
                ->get();
            return $reportData;
        } catch (Exception $ex) {
            //throw $th;
        }
    }
}
