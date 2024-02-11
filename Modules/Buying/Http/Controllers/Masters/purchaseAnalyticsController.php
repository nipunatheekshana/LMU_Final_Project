<?php

namespace Modules\Buying\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Buying\Entities\Views\AnnualPurchaseGradeWeightView;
use Modules\Buying\Entities\Views\AnnualPurchaseSizeWeightView;
use Modules\Buying\Entities\Views\AnnualPurchaseGradePriceView;
use Modules\Settings\Entities\UserSetting;
use Modules\Sf\Entities\Fishspecies;

class purchaseAnalyticsController extends Controller
{
    use commonFeatures;


    // Fish Species Select Loading Function
    public function loadFishSpecies()
    {
        try {
            $FishTypes = Fishspecies::where('enabled', true)->select('id', 'FishName');

            return $this->responseBody(true, "loadFishSpecies", "Found", $FishTypes->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishSpecies", "Something Went Wrong", $ex->getMessage());
        }
    }

    // Tables Loading Functions
    public function loadAnnualPurchaseGradeWeight(Request $request)
    {
        try {
            $AnnualPurchaseGradeWeight = DB::table('buying_fish_grn_hd')
                ->join('buying_fish_grn_dtl', 'buying_fish_grn_hd.id', '=', 'buying_fish_grn_dtl.grn_id')
                ->groupBy([
                    'buying_fish_grn_dtl.fish_type_id',
                    'buying_fish_grn_dtl.quality_grade'
                ])
                ->select([
                    'buying_fish_grn_dtl.quality_grade AS grade',
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 4 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year1'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 3 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year2'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 2 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year3'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 1 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year4'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 0 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year5'),
                ])
                ->where('buying_fish_grn_dtl.fish_type_id', (int)$request->fishtype)
                ->get();

            return $this->responseBody(true, "loadAnnualPurchaseGradeWeightView", "Found", $AnnualPurchaseGradeWeight);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadAnnualPurchaseGradeWeightView", "Something Went Wrong", $ex->getMessage());
        }
    }

    public function loadAnnualPurchaseSizeWeight(Request $request)
    {
        try {
            $AnnualPurchaseSizeWeight = DB::table('buying_fish_grn_hd')
                ->join('buying_fish_grn_dtl', 'buying_fish_grn_hd.id', '=', 'buying_fish_grn_dtl.grn_id')
                ->join('buying_grn_fish_size_matrix', 'buying_fish_grn_dtl.item_size_id', '=', 'buying_grn_fish_size_matrix.id')
                ->groupBy([
                    'buying_fish_grn_dtl.fish_type_id',
                    'buying_grn_fish_size_matrix.SizeDescription'
                ])
                ->select([
                    'buying_grn_fish_size_matrix.SizeDescription AS SizeDescription',
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 4 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year1'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 3 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year2'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 2 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year3'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 1 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year4'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 0 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year5'),
                ])
                ->where('buying_fish_grn_dtl.fish_type_id', (int)$request->fishtype)
                ->get();

            return $this->responseBody(true, "loadAnnualPurchaseSizeWeightView", "Found", $AnnualPurchaseSizeWeight);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadAnnualPurchaseSizeWeightView", "Something Went Wrong", $ex->getMessage());
        }
    }

    public function loadAnnualPurchaseGradePrice(Request $request)
    {
        try {
            $AnnualPurchaseGradePrice = DB::table('buying_fish_grn_hd')
                ->join('buying_fish_grn_dtl_pay_rate', 'buying_fish_grn_hd.grnno', '=', 'buying_fish_grn_dtl_pay_rate.lot_grnno')
                ->groupBy([
                    'buying_fish_grn_dtl_pay_rate.fish_type_id',
                    'buying_fish_grn_dtl_pay_rate.pay_grade'
                ])
                ->select([
                    'buying_fish_grn_dtl_pay_rate.pay_grade AS pay_grade',
                    DB::raw('round( avg( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 4 THEN buying_fish_grn_dtl_pay_rate.unit_rate_base_cur ELSE 0 END ), 2 ) AS Year1'),
                    DB::raw('round( avg( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 3 THEN buying_fish_grn_dtl_pay_rate.unit_rate_base_cur ELSE 0 END ), 2 ) AS Year2'),
                    DB::raw('round( avg( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 2 THEN buying_fish_grn_dtl_pay_rate.unit_rate_base_cur ELSE 0 END ), 2 ) AS Year3'),
                    DB::raw('round( avg( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 1 THEN buying_fish_grn_dtl_pay_rate.unit_rate_base_cur ELSE 0 END ), 2 ) AS Year4'),
                    DB::raw('round( avg( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 0 THEN buying_fish_grn_dtl_pay_rate.unit_rate_base_cur ELSE 0 END ), 2 ) AS Year5'),
                ])
                ->where('buying_fish_grn_dtl_pay_rate.fish_type_id', (int)$request->fishtype)

                ->get();

            return $this->responseBody(true, "loadAnnualPurchaseGradePriceView", "Found", $AnnualPurchaseGradePrice);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadAnnualPurchaseGradePriceView", "Something Went Wrong", $ex->getMessage());
        }
    }

    public function updateAnnualPurchaseSumCharts(Request $request)
    {
        try {
            $AnnualPurchaseGradeWeight = DB::table('buying_fish_grn_hd')
                ->join('buying_fish_grn_dtl', 'buying_fish_grn_hd.id', '=', 'buying_fish_grn_dtl.grn_id')
                ->groupBy([
                    'buying_fish_grn_dtl.fish_type_id',
                ])
                ->select([
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 4 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year1'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 3 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year2'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 2 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year3'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 1 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year4'),
                    DB::raw('round( sum( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 0 THEN buying_fish_grn_dtl.net_weight ELSE 0 END ), 3 ) AS Year5'),
                ])
                ->where('buying_fish_grn_dtl.fish_type_id', (int)$request->fishtype)
                ->first();

            return $this->responseBody(true, "updateAnnualPurchaseSumCharts", "Found", $AnnualPurchaseGradeWeight);
        } catch (Exception $ex) {
            return $this->responseBody(false, "updateAnnualPurchaseSumCharts", "Something Went Wrong", $ex->getMessage());
        }
    }

    public function updateAnnualAvaragePriceCharts(Request $request)
    {
        try {
            $AnnualPurchaseGradePrice = DB::table('buying_fish_grn_hd')
                ->join('buying_fish_grn_dtl_pay_rate', 'buying_fish_grn_hd.grnno', '=', 'buying_fish_grn_dtl_pay_rate.lot_grnno')
                ->groupBy([
                    'buying_fish_grn_dtl_pay_rate.fish_type_id',
                    // 'buying_fish_grn_dtl_pay_rate.pay_grade'
                ])
                ->select([
                    DB::raw('round( avg( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 4 THEN buying_fish_grn_dtl_pay_rate.unit_rate_base_cur ELSE 0 END ), 2 ) AS Year1'),
                    DB::raw('round( avg( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 3 THEN buying_fish_grn_dtl_pay_rate.unit_rate_base_cur ELSE 0 END ), 2 ) AS Year2'),
                    DB::raw('round( avg( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 2 THEN buying_fish_grn_dtl_pay_rate.unit_rate_base_cur ELSE 0 END ), 2 ) AS Year3'),
                    DB::raw('round( avg( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 1 THEN buying_fish_grn_dtl_pay_rate.unit_rate_base_cur ELSE 0 END ), 2 ) AS Year4'),
                    DB::raw('round( avg( CASE WHEN YEAR (buying_fish_grn_hd.grndate) = YEAR ( curdate()) - 0 THEN buying_fish_grn_dtl_pay_rate.unit_rate_base_cur ELSE 0 END ), 2 ) AS Year5'),
                ])
                ->where('buying_fish_grn_dtl_pay_rate.fish_type_id', (int)$request->fishtype)

                ->first();

            return $this->responseBody(true, "updateAnnualAvaragePriceCharts", "Found", $AnnualPurchaseGradePrice);
        } catch (Exception $ex) {
            return $this->responseBody(false, "updateAnnualAvaragePriceCharts", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function saveSelection(Request $request)
    {
        try {

           UserSetting::updateOrCreate(['user_id'=>Auth::user()->id], ['buying_purchaseAnalytics_fishType'=>$request->fishId]);

            return $this->responseBody(true, "saveSelection", "Saved", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "saveSelection", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function loadPreviousFishData(Request $request)
    {
        try {

          $PreviousFish =UserSetting::where('user_id',Auth::user()->id);
          if($PreviousFish->exists()){
            $PreviousFish=$PreviousFish->first()->buying_purchaseAnalytics_fishType;
          }
          else{
            $PreviousFish=null;
          }

            return $this->responseBody(true, "loadPreviousFishData", "Found", $PreviousFish);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPreviousFishData", "Something Went Wrong", $ex->getMessage());
        }
    }
}
