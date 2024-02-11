<?php

namespace Modules\Buying\Http\Controllers\Masters;

use App\FrappeApiClient;
use App\Http\common\commonFeatures;
use App\Http\common\nameingSeries;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Accounting\Entities\ExchangeRate;
use Modules\Buying\Entities\BuyingFishSize;
use Modules\Buying\Entities\GRN;
use Modules\Buying\Entities\GRNDetail;
use Modules\Buying\Entities\GrnDetailPayRate;
use Modules\Buying\Entities\GrnDetailYeild;
use Modules\Buying\Entities\Supplier;
use Modules\Buying\Entities\Views\GRNDetailsView;
use Modules\Buying\Entities\Views\GRNHeaderDetailsView;
use Modules\Buying\Entities\Views\GRNHistoryView;
use Modules\Inventory\Entities\Item;
use Modules\Inventory\Entities\Warehouse;
use Modules\Mnu\Entities\Views\ProductionDetailView;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\Currency;
use Modules\Sf\Entities\Boat;
use Modules\Sf\Entities\FishGrade;
use Modules\Sf\Entities\FishSize;
use Modules\Sf\Entities\Fishspecies;
use Modules\Sf\Entities\PresentationType;

class grnHistoryController extends Controller
{
    use commonFeatures, nameingSeries;
    public function loadGrnHistory(Request $request)
    {
        try {
            $selectArr = [
                'grnno',
                'grndate',
                'grn_type',
                'supplier_name',
                'totalQty',
                'totFishWeight',
                'unprocessedPCs',
                'processedPcs',
                'transferPcs',
                'rejectPcs',
                'unload_status',
                'finance_status',
                'voucher_status',
            ];
            $GRNHistory = GRNHistoryView::orderBy('id', 'desc');
            if ($request->supplier != null) {
                $GRNHistory = $GRNHistory->where('supplier_id', (int)$request->supplier);
            }
            if ($request->boat != null) {
                $GRNHistory = $GRNHistory->where('boat_registration_number', $request->boat);
            }
            if ($request->type != null) {
                $GRNHistory = $GRNHistory->where('grn_type', $request->type);
            }
            // return $request->endDate ;
            if ($request->startDate != 0 && $request->endDate != 0) {
                $GRNHistory = $GRNHistory->whereBetween('grndate', [$request->startDate, $request->endDate]);
            } elseif ((int)$request->startDate == 0 && (int)$request->endDate == 0) {
                $GRNHistory = $GRNHistory->whereBetween('grndate', [Carbon::today()->subDays(30)->toDateString(), Carbon::today()->toDateString()]);
            }


            $GRNHistory = $GRNHistory->select($selectArr);
            return $this->responseBody(true, "loadGrnHistory", "found", $GRNHistory->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadGrnHistory", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadSuppliers()
    {
        try {
            $Supplier = Supplier::where('enabled', true)->select('id', 'supplier_name');


            return $this->responseBody(true, "loadSuppliers", "found", $Supplier->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSuppliers", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadBoats()
    {
        try {
            $Boat = Boat::where('enabled', true)->select('id', 'BoatName');
            return $this->responseBody(true, "loadBoats", "found", $Boat->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBoats", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadGrnDetails($id)
    {
        try {
            $arr = [
                'grnno',
                'grndate',
                'batch_no',
                'supID',
                'supplier_name',
                'BoatRegNo',
                'BoatName',
                'totalQty',
                'totFishWeight',
                'processedPcs',
                'unprocessedPCs',
            ];
            $GRNHeaderDetailsView = GRNHeaderDetailsView::where('grnno', (int)$id)->select($arr)->first();
            return $this->responseBody(true, "loadGrnDetails", "found", $GRNHeaderDetailsView);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadGrnDetails", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadFishDetailsTable(Request $request)
    {
        $array = [
            'lot_serial_no',
            'lot_grnno',
            'lot_barcode',
            'FishCode',
            'presentation',
            'supplier_grade',
            'quality_grade',
            'item_size',
            'FishWeight',
            'item_Status',
            'dmg_weight',
            'fish_temperature',
            'fish_selector',
            'WorkstationName',
            'mobile_user',
        ];
        try {
            $GRNDetailsView = GRNDetailsView::where('lot_grnno', (int)$request->GRNNo);

            if ($request->type != null) {
                $GRNDetailsView = $GRNDetailsView->where('FishSpID', (int)$request->type);
            }
            if ($request->presentation != null) {
                $GRNDetailsView = $GRNDetailsView->where('presentation', $request->presentation);
            }
            if ($request->size != null) {
                $GRNDetailsView = $GRNDetailsView->where('item_size', $request->size);
            }
            if ($request->pay_grade != null) {
                $GRNDetailsView = $GRNDetailsView->where('supplier_grade', $request->pay_grade);
            }
            if ($request->quality_grade != null) {
                $GRNDetailsView = $GRNDetailsView->where('quality_grade', $request->quality_grade);
            }

            $GRNDetailsView = $GRNDetailsView->select($array);

            return $this->responseBody(true, "loadFishDetailsTable", "found", $GRNDetailsView->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishDetailsTable", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadPresentation()
    {
        try {
            $PresentationType = PresentationType::where('enabled', true)->select('PrsntName');


            return $this->responseBody(true, "loadPresentation", "found", $PresentationType->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPresentation", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadSize($GRNno)
    {
        try {
            $FishSize = BuyingFishSize::where('enabled', true)->where('grnNo', (int)$GRNno)->select('id', 'SizeDescription');


            return $this->responseBody(true, "loadSize", "found", $FishSize->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSize", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadFishGrade()
    {
        try {
            $FishGrade = FishGrade::where('enabled', true)->select('PayFishGrade', 'QFishGrade');


            return $this->responseBody(true, "loadFishGrade", "found", $FishGrade->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishGrade", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadFishDetailSummary(Request $request)
    {
        try {

            ############ raw SQL Quary ###############

            // 'SELECT
            //     sf_fish_species.FishName AS fishType,
            //     COUNT(*) AS qty,
            //     SUM( FishWaight ) AS Weight,
            //     COUNT( CASE WHEN `Status` = 1 THEN 1 END ) AS ProcessedQty,
            //     SUM( CASE WHEN `Status` = 1 THEN PRWg END ) AS ProcessedWeight,
            //     COUNT( CASE WHEN `Status` = 0 THEN 1 END ) AS UnProcessedQty,
            //     SUM( CASE WHEN `Status` = 0 THEN FishWaight END ) AS UnProcessedWeight,
            //     COUNT( CASE WHEN `Status` = 3 THEN 1 END ) AS TransferQty,
            //     SUM( CASE WHEN `Status` = 3 THEN TFRWg END ) AS TransferWeight,
            //     COUNT( CASE WHEN `Status` = 2 THEN 1 END ) AS RejectQty,
            //     SUM( CASE WHEN `Status` = 2 THEN RJWg END ) AS RejectWeight
            // FROM
            //     buying_grn_dtl
            //     LEFT JOIN sf_fish_species ON buying_grn_dtl.FishCode = sf_fish_species.id
            // WHERE
            //     GRNNo = 285
            // GROUP BY
            //     sf_fish_species.FishName';

            $GRNSummary = DB::table('buying_fish_grn_dtl')
                ->select(
                    array(
                        'sf_fish_species.FishName AS fishType',
                        'buying_fish_grn_dtl.fish_type_id',

                        DB::raw('COUNT(*) AS qty'),
                        DB::raw("SUM( buying_fish_grn_dtl_yield.net_prod_wg ) AS Weight"),
                        DB::raw('COUNT( CASE WHEN `item_Status` = 1 THEN 1 END ) AS ProcessedQty'),
                        DB::raw('SUM( CASE WHEN `item_Status` = 1 THEN buying_fish_grn_dtl_yield.prod_wg END ) AS ProcessedWeight'),
                        DB::raw('COUNT( CASE WHEN `item_Status` = 0 THEN 1 END ) AS UnProcessedQty'),
                        DB::raw('SUM( CASE WHEN `item_Status` = 0 THEN buying_fish_grn_dtl_yield.net_prod_wg END ) AS UnProcessedWeight'),
                        DB::raw('COUNT( CASE WHEN `item_Status` = 3 THEN 1 END ) AS TransferQty'),
                        DB::raw('SUM( CASE WHEN `item_Status` = 3 THEN buying_fish_grn_dtl_yield.tfr_typ_0_wg END ) AS TransferWeight'),
                        DB::raw('COUNT( CASE WHEN `item_Status` = 2 THEN 1 END ) AS RejectQty'),
                        DB::raw('SUM( CASE WHEN `item_Status` = 2 THEN buying_fish_grn_dtl_yield.rej_typ_0_wg END ) AS RejectWeight')
                    )
                )
                ->leftJoin('sf_fish_species', 'buying_fish_grn_dtl.fish_type_id', '=', 'sf_fish_species.id')
                ->leftJoin('buying_fish_grn_dtl_yield', 'buying_fish_grn_dtl_yield.grn_dtl_lot_id', '=', 'buying_fish_grn_dtl.id')
                ->where('buying_fish_grn_dtl.lot_grnno', (int)$request->GRNNo)
                ->groupBy('sf_fish_species.FishName', 'buying_fish_grn_dtl.fish_type_id')->get();

            return $this->responseBody(true, "loadFishDetailSummary", "found", $GRNSummary);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishDetailSummary", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadFishGradeData($GRNNo, $fishCode)
    {
        try {
            // $FishGrade = GRNDetail::where('GRNNo', (int)$GRNNo)
            //     ->where('FishCode', (int)$fishCode)
            //     ->select(
            //         array(
            //             'PayGrade AS grade',
            //             DB::raw('SUM(FishWaight) AS weight')
            //         )
            //     )->groupBy('PayGrade')->get();
            $FishGrade = DB::table('buying_fish_grn_dtl')
                ->leftJoin('buying_fish_grn_dtl_yield', 'buying_fish_grn_dtl_yield.grn_dtl_lot_id', '=', 'buying_fish_grn_dtl.id')
                ->where('buying_fish_grn_dtl.fish_type_id', (int)$fishCode)
                ->where('buying_fish_grn_dtl.lot_grnno', (int)$GRNNo)
                ->select(
                    array(
                        'buying_fish_grn_dtl.supplier_grade AS grade',
                        DB::raw('SUM(buying_fish_grn_dtl_yield.net_prod_wg) AS weight')
                    )
                )->groupBy('buying_fish_grn_dtl.supplier_grade')->get();

            return $this->responseBody(true, "loadFishGradeData", "found", $FishGrade);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishGradeData", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadAdminDetails($GRNno)
    {
        try {
            $GRN = GRN::where('grnno', (int)$GRNno)->select('boat_id', 'supplier_id')->first();


            return $this->responseBody(true, "loadAdminDetails", "found", $GRN);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadAdminDetails", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadBoatDetails($boatId)
    {
        try {
            $boat = Boat::where('id', (int)$boatId)->select('SkipperName', 'LicenseNo', 'LicenseExpDate')->first();


            return $this->responseBody(true, "loadBoatDetails", "found",  $boat);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBoatDetails", "Something went wrong", $ex->getMessage());
        }
    }
    public function UpdateBoatDetails(Request $request)
    {
        try {
            $GRN = GRN::where('grnno', (int)$request->GRNno)
                ->update(['supplier_id' => $request->supplier, 'boat_id' => $request->boat]);
            if ($GRN) {
                $Boat = Boat::find((int)$request->boat);
                $Boat->SkipperName = $request->skipper_name;
                $Boat->LicenseNo = $request->licence_no;
                $Boat->LicenseExpDate = $request->licence_expire_date;
                $Boat->save();
            }
            return $this->responseBody(true, "UpdateBoatDetails", "Updated", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "UpdateBoatDetails", "Something went wrong", $ex->getMessage());
        }
    }
    public function LoadFishDetails($grnno, $fishNo)
    {
        try {
            $array = [
                'buying_fish_grn_dtl.fish_type_id',
                'buying_fish_grn_dtl.lot_grnno',
                'buying_fish_grn_dtl.item_size_id',
                'buying_fish_grn_dtl_yield.net_prod_wg', //fish weight
                'buying_fish_grn_dtl.fish_temperature',
                'buying_fish_grn_dtl.presentation',
                'buying_fish_grn_dtl.supplier_grade',
                'buying_fish_grn_dtl.quality_grade',

            ];
            // $GRNDetail = GRNDetail::where('GRNNo', (int)$grnno)->where('FishNo', (int)$fishNo)->select($array)->first();
            $GRNDetail = DB::table('buying_fish_grn_dtl')
                ->leftJoin('buying_fish_grn_dtl_yield', 'buying_fish_grn_dtl_yield.grn_dtl_lot_id', '=', 'buying_fish_grn_dtl.id')
                ->where('buying_fish_grn_dtl.lot_grnno', (int)$grnno)
                ->where('buying_fish_grn_dtl.lot_serial_no', (int)$fishNo)
                ->select($array)->first();

            return $this->responseBody(true, "LoadFishDetails", "Updated", $GRNDetail);
        } catch (Exception $ex) {
            return $this->responseBody(false, "LoadFishDetails", "Something went wrong", $ex->getMessage());
        }
    }
    public function UpdateFishDetails(Request $request)
    {
        try {
            $id = GRNDetail::where('lot_grnno', (int)$request->grnno)->where('lot_serial_no', (int)$request->fishNo)->select('id')->first()->id;

            $GRNDetail = GRNDetail::find($id);
            $GRNDetail->fish_type_id = $request->FishDetailModel_fishtype;
            $GRNDetail->item_size_id = $request->FishDetailModel_sizeCode;
            // $GRNDetail->FishWaight = $request->FishDetailModel_Weight;
            $GRNDetail->fish_temperature = $request->FishDetailModel_temperature;
            $GRNDetail->presentation = $request->FishDetailModel_presentation_type;
            $GRNDetail->supplier_grade = $request->FishDetailModel_pay_grade;
            $GRNDetail->quality_grade = $request->FishDetailModel_quality_grade;
            $save = $GRNDetail->save();

            if ($save) {
                $GrnDetailYeild = GrnDetailYeild::where('grn_dtl_id', (int)$id);

                if ($GrnDetailYeild) {
                    $GrnDetailYeild->update(['net_weight' =>  $request->FishDetailModel_Weight]);
                }
            }

            return $this->responseBody(true, "UpdateFishDetails", "Updated", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "UpdateFishDetails", "Something went wrong", $ex->getMessage());
        }
    }
    public function LoadProductionDetail($fishNo, $GRNno)
    {
        try {

            $array = [
                'buying_fish_grn_dtl.lot_serial_no',
                'buying_fish_grn_dtl.lot_grnno',
                'sf_fish_species.FishName',
                'buying_fish_grn_dtl_yield.net_prod_wg', //get from fish detail yeield
                'buying_fish_grn_dtl_yield.prod_wg', //get from fish detail yeield
                'buying_fish_grn_hd.grndate',
                'buying_suppliers.supplier_name',
            ];
            $array2 = [
                'PcsNo',
                'PcsID',
                'item_name',
                'CusName',
                'PcsWeight',
                'MobUser',
                'TrimSupCode',
                'TrimmerCode',
                'PRDateTime',
            ];
            $GRNDetail = DB::table('buying_fish_grn_dtl')
                ->leftJoin('buying_fish_grn_hd', 'buying_fish_grn_hd.grnno', '=', 'buying_fish_grn_dtl.lot_grnno')
                ->leftJoin('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl.fish_type_id')
                ->leftJoin('buying_fish_grn_dtl_yield', 'buying_fish_grn_dtl_yield.grn_dtl_lot_id', '=', 'buying_fish_grn_dtl.id')
                ->where('buying_fish_grn_dtl.lot_grnno', (int)$GRNno)
                ->select($array)
                ->first();
            $ProductionDetailView = ProductionDetailView::where('lot_serial_no', (int)$fishNo)->where('lot_grnno', (int)$GRNno)->select($array2)->get();
            return $this->responseBody(true, "LoadProductionDetail", "Updated", ['ProductionDetailView' => $ProductionDetailView, 'GRNDetail' => $GRNDetail]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "LoadProductionDetail", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadFishSizeTOFIsh($GRNno, $FishCode)
    {
        try {
            $FishSize = BuyingFishSize::where('enabled', true)->where('grnNo', (int)$GRNno)->where('FishSpeciesId', (int)$FishCode)->select('id', 'SizeDescription');


            return $this->responseBody(true, "loadFishSizeTOFIsh", "found", $FishSize->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishSizeTOFIsh", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadTypesInTable($GRNno)
    {
        try {
            $FishTypes = DB::table('buying_fish_grn_dtl')
                ->select(
                    array(
                        'sf_fish_species.id',
                        'sf_fish_species.FishCode'
                    )
                )
                ->distinct('buying_fish_grn_dtl.fish_type_id')
                ->where('lot_grnno', (int)$GRNno)
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl.fish_type_id');


            return $this->responseBody(true, "loadTypesInTable", "found", $FishTypes->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadTypesInTable", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadFishSpecies()
    {
        try {
            $FishTypes = Fishspecies::where('enabled', true)->select('id', 'FishCode')->select('id', 'FishCode');


            return $this->responseBody(true, "loadFishSpecies", "found", $FishTypes->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishSpecies", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadResiverdFishSpecies($GRNno)
    {
        try {
            $FishTypes = DB::table('sf_fish_species')
                ->select('sf_fish_species.FishName', 'sf_fish_species.id', 'sf_fish_species.FishCode')
                ->leftJoin('buying_fish_grn_dtl', 'buying_fish_grn_dtl.fish_type_id', '=', 'sf_fish_species.id')
                ->groupBy('buying_fish_grn_dtl.fish_type_id', 'sf_fish_species.FishName', 'sf_fish_species.id', 'sf_fish_species.FishCode')
                ->where('buying_fish_grn_dtl.lot_grnno', (int)$GRNno);


            return $this->responseBody(true, "loadResiverdFishSpecies", "found", $FishTypes->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadResiverdFishSpecies", "Something went wrong", $ex->getMessage());
        }
    }
    public function LoadSizeTable($GRNno, $fishId)
    {
        try {
            // $FishTypes = DB::table('buying_grn_fish_size_matrix')
            //     ->leftJoin('buying_grn_dtl', 'buying_grn_dtl.FishCode', '=', 'sf_fish_species.id')
            //     ->where('buying_grn_dtl.GRNNo', (int)$GRNno);
            $BuyingFishSize = BuyingFishSize::where('grnNo', (int)$GRNno)->where('FishSpeciesId', (int)$fishId)->select('id', 'SizeDescription', 'SizeCode');

            return $this->responseBody(true, "LoadSizeTable", "found", $BuyingFishSize->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "LoadSizeTable", "Something went wrong", $ex->getMessage());
        }
    }
    public function deleteSize($id)
    {
        try {
            $maxValue = BuyingFishSize::where('id', $id)->select('grnNo', 'FishSpeciesId')->first();
            $grnNo = $maxValue->grnNo;
            $fishSPid = $maxValue->FishSpeciesId;

            $maxID = BuyingFishSize::where('enabled', true)
                ->where('grnNo', (int)$grnNo)
                ->where('FishSpeciesId', (int)$fishSPid)
                ->orderBy('id', 'desc')
                ->first()->id;

            if ($maxID == $id) {
                $BuyingFishSize = BuyingFishSize::where('id', (int)$id)->delete();
                return $this->responseBody(true, "User", "FishSize Deleted", null);
            } else {
                return $this->responseBody(false, "User", "Delete Last item first", '');
            }

            return $this->responseBody(true, "User", "FishSize Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function getNewMinValue($GRNno, $fishId)
    {
        try {
            $maxValue = BuyingFishSize::where('grnNo', (int)$GRNno)
                ->where('FishSpeciesId', (int)$fishId)
                ->where('enabled', true)
                ->orderBy('id', 'desc')
                ->select('maxValue')
                ->first();
            if (!$maxValue) {
                $maxValue = 0.01;
            } else {
                $maxValue = $maxValue->maxValue;
            }
            return $this->responseBody(true, "getNewMinValue", '', $maxValue);
        } catch (Exception $ex) {
            return $this->responseBody(false, "getNewMinValue", '', $ex->getMessage());
        }
    }
    public function saveSize(Request $request, $GRNno)
    {
        $validatedData = $request->validate([
            'modelFishSizeTable_FishSpecies' => ['required'],
            'modelFishSizeTable_minValue' => ['required'],
            'modelFishSizeTable_maxValue' => ['required'],
            'modelFishSizeTable_Discription' => ['required'],

        ]);
        $SizeCode = $request->modelFishSizeTable_minValue . '-' . $request->modelFishSizeTable_maxValue;
        if (BuyingFishSize::where('enabled', true)->where('grnNo',  (int)$GRNno)->where('FishSpeciesId', (int)$request->FishSpeciesId)->where('SizeCode', $SizeCode)->exists()) {
            $this->validationError('SizeCode', 'Size Code exists');
        }
        try {
            $FishSize = new BuyingFishSize();
            $FishSize->grnNo = $GRNno;
            $FishSize->FishSpeciesId = $request->modelFishSizeTable_FishSpecies;
            $FishSize->minValue = $request->modelFishSizeTable_minValue;
            $FishSize->maxValue = $request->modelFishSizeTable_maxValue;
            $FishSize->SizeCode = $SizeCode;
            $FishSize->SizeDescription = $request->modelFishSizeTable_Discription;
            $FishSize->enabled = true;
            $FishSize->created_by = Auth::user()->id;
            $save = $FishSize->save();

            if ($save) {
                return $this->responseBody(true, "save", "FishSize saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function SetStatus(Request $request, $GRNno)
    {

        try {
            $GRN = GRN::where('grnno', (int)$GRNno);
            if ($request->type == 'receiveHold') {
                $GRN->update(['unload_status' => 1, 'resive_hold_reason' => $request->modelStatusSetting_receive_reson]);
            }
            if ($request->type == 'receiveClose') {
                $GRN->update(['unload_status' => 2, 'resive_hold_reason' => $request->modelStatusSetting_receive_reson]);
            }
            if ($request->type == 'financeClose') {
                $GRN->update(['finance_status' => 1, 'finance_close_reason' => $request->modelStatusSetting_finance_remark]);
            }
            if ($request->type == 'voucherceClose') {
                $GRN->update(['voucher_status' => 1, 'voucher_close_reason' => $request->modelStatusSetting_voucher_remark]);
            }


            if ($GRN) {
                return $this->responseBody(true, "save", "SetStatus", 'States saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "SetStatus", $exception->getMessage());
        }
    }
    public function loadStatus($GRNno)
    {

        try {
            $GRN = GRN::where('grnno', (int)$GRNno)->select('unload_status', 'finance_status', 'voucher_status')->first();


            if ($GRN) {
                return $this->responseBody(true, "save", "SetStatus", $GRN);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "SetStatus", $exception->getMessage());
        }
    }
    public function loadGrnPricingTable($GRNno)
    {

        try {
            $select = [
                'sf_fish_species.FishName',
                'buying_fish_grn_dtl.presentation',
                'buying_fish_grn_dtl.supplier_grade',
                'buying_grn_fish_size_matrix.SizeDescription',
                DB::raw('COUNT(*) AS qty'),
                DB::raw("SUM( buying_fish_grn_dtl.net_weight ) AS Weight"),
                'buying_fish_grn_dtl.fish_type_id',
                'buying_fish_grn_dtl.item_size_id',

            ];
            $groupBy = [
                'sf_fish_species.FishName',
                'buying_fish_grn_dtl.presentation',
                'buying_fish_grn_dtl.supplier_grade',
                'buying_fish_grn_dtl.item_size_id',
                'buying_grn_fish_size_matrix.SizeDescription',
                'buying_fish_grn_dtl.fish_type_id',
                'buying_fish_grn_dtl.item_size_id',
            ];
            // $GRNDetail=GRNDetail::where('')->select()->get();
            $GRNDetail = DB::table('buying_fish_grn_dtl')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl.fish_type_id')
                ->leftJoin('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl.item_size_id')
                ->where('buying_fish_grn_dtl.lot_grnno', (int)$GRNno)
                ->select($select)
                ->groupBy($groupBy)
                ->get();

            $GRN = DB::table('buying_fish_grn_hd')
                ->leftJoin('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id')
                ->select('buying_fish_grn_hd.grndate', 'buying_fish_grn_hd.grnno', 'buying_suppliers.supplier_name')
                ->where('buying_fish_grn_hd.grnno', (int)$GRNno)
                ->first();

            $fishTypes = DB::table('buying_fish_grn_dtl')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl.fish_type_id')
                ->where('buying_fish_grn_dtl.lot_grnno', (int)$GRNno)
                ->select('sf_fish_species.id', 'sf_fish_species.FishName')
                ->distinct('buying_fish_grn_dtl.fish_type_id')
                ->get();

            $Presentations = GRNDetail::where('lot_grnno', (int)$GRNno)->distinct('presentation')->select('presentation')->get();
            $SupplierGrade = GRNDetail::where('lot_grnno', (int)$GRNno)->distinct('supplier_grade')->select('supplier_grade')->get();

            $Size = DB::table('buying_fish_grn_dtl')
                ->leftJoin('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl.item_size_id')
                ->where('buying_fish_grn_dtl.lot_grnno', (int)$GRNno)
                ->select('buying_grn_fish_size_matrix.id', 'buying_grn_fish_size_matrix.SizeDescription')
                ->distinct('buying_fish_grn_dtl.item_size_id')
                ->get();
            $localCurrancy = DB::table('buying_fish_grn_hd')
                ->leftJoin('settings_companies', 'settings_companies.id', '=', 'buying_fish_grn_hd.company_id')
                ->leftJoin('settings_currencies', 'settings_currencies.id', '=', 'settings_companies.local_currency_id')
                ->where('buying_fish_grn_hd.grnno', (int)$GRNno)
                ->select('settings_currencies.id')
                ->first();


            if ($GRNDetail) {
                return $this->responseBody(
                    true,
                    "loadGrnPricingTable",
                    "found",
                    [
                        'GRNDetail' => $GRNDetail,
                        'GRN' => $GRN,
                        'date' => Carbon::now()->format('Y-m-d h:i:s'),
                        'user' => Auth::user()->name,
                        'fishTypes' => $fishTypes,
                        'Presentations' => $Presentations,
                        'SupplierGrade' => $SupplierGrade,
                        'Size' => $Size,
                        'localCurrancy' => $localCurrancy,

                    ]
                );
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadGrnPricingTable", "Something went Wrong", $exception->getMessage());
        }
    }
    public function loadCurrancy()
    {

        try {
            $currancy = Currency::where('enabled', true)->select('id', 'currency_name')->get();

            if ($currancy) {
                return $this->responseBody(true, "save", "loadCurrancy", $currancy);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "loadCurrancy", $exception->getMessage());
        }
    }
    public function getExchangeRateToDate($currancyId, $GRNno)
    {

        try {
            $companyId = GRN::where('grnno', (int)$GRNno)->first()->company_id;
            $ExchangeRate = ExchangeRate::where('company_id', (int)$companyId)
                ->where('currency', (int)$currancyId)
                ->where('date', Carbon::today()->format('Y-m-d'))
                ->first('exchange_rate');

            if ($ExchangeRate) {
                return $this->responseBody(true, "getExchangeRateToDate", "found", $ExchangeRate);
            } else {
                return $this->responseBody(false, "getExchangeRateToDate", "motFound", $ExchangeRate);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "getExchangeRateToDate", "loadCurrancy", $exception->getMessage());
        }
    }
    public function saveGRNPricing(Request $request)
    {
        $companyId = GRN::where('grnno', $request->lot_grnno)->first('company_id')->company_id;
        $baseCurrancyRate =  DB::table('buying_fish_grn_hd')
            ->leftJoin('settings_companies', 'settings_companies.id', '=', 'buying_fish_grn_hd.company_id')
            ->join(
                'accounting_exchange_rate',
                function ($join) {
                    $join->on('accounting_exchange_rate.company_id', '=', 'settings_companies.id');
                    $join->on('accounting_exchange_rate.currency', '=', 'settings_companies.currency_id');
                }
            )
            ->where('buying_fish_grn_hd.grnno', $request->lot_grnno);
        // return $baseCurrancyRate->tosql();
        if (!$baseCurrancyRate->exists()) {
            $this->validationError('', 'Invalid Base currancy exchange rate');
        }
        try {
            $baseCurrancyRate = (int)$baseCurrancyRate->first('exchange_rate')->exchange_rate;
            foreach ($request->arr as $pricingItem) {
                $pricingItem = json_decode($pricingItem);
                $GrnDetailPayRate = new GrnDetailPayRate();
                $GrnDetailPayRate->rm_cost_id = $this->nameSeris('Raw Material Cost ID');
                $GrnDetailPayRate->lot_grnno = $request->lot_grnno;
                $GrnDetailPayRate->fish_type_id = $pricingItem->fish_type_id;
                $GrnDetailPayRate->pay_grade = $pricingItem->suplier_grade;
                $GrnDetailPayRate->item_size = $pricingItem->item_size;
                $GrnDetailPayRate->rm_presentation = $pricingItem->rm_presentation;
                $GrnDetailPayRate->rm_qty = $pricingItem->rm_qty;
                $GrnDetailPayRate->rm_tot_weight = $pricingItem->rm_tot_weight;
                $GrnDetailPayRate->rm_uom = Fishspecies::where('id', $pricingItem->fish_type_id)->first('default_weight_unit')->default_weight_unit;
                $GrnDetailPayRate->rm_pay_currency = $request->rm_pay_currency;
                $GrnDetailPayRate->rm_pay_rate = (int)$pricingItem->rm_pay_rate;
                $GrnDetailPayRate->rm_pay_value = (int)$pricingItem->rm_pay_value;
                $GrnDetailPayRate->pay_currency_exch_rate = (int)$request->Pay_exchangeRate;
                $GrnDetailPayRate->base_currency_exch_rate = $baseCurrancyRate;
                $unit_rate_local_cur = (int)$request->Pay_exchangeRate * (int)$pricingItem->rm_pay_rate;
                $GrnDetailPayRate->unit_rate_local_cur = $unit_rate_local_cur;
                $GrnDetailPayRate->unit_rate_base_cur = (int)$unit_rate_local_cur / $baseCurrancyRate;
                $GrnDetailPayRate->created_by = Auth::user()->id;
                $GrnDetailPayRate->save();
            }
            //update GrnAfter Pricing
            GRN::where('grnno', $request->lot_grnno)
                ->update(['finance_status' => 1]);


            return $this->responseBody(true, "saveGRNPricing", "found", '');
        } catch (Exception $exception) {
            return $this->responseBody(false, "saveGRNPricing", "loadCurrancy", $exception->getMessage());
        }
    }
    public function loadAddWastageModleData()
    {

        try {
            $Item = Item::where('is_by_product', true)->where('enabled', true)->select('Item_Code', 'item_name')->get();
            $Warehouse = Warehouse::where('enabled', true)->select('warehouse_name')->get();


            return $this->responseBody(true, "save", "loadAddWastageModleData", ['Item' => $Item, 'Warehouse' => $Warehouse]);
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "loadAddWastageModleData", $exception->getMessage());
        }
    }
    public function saveWastage(Request $request)
    {
        try {
            $data = [
                "stock_entry_type" => "Material Receipt",
                "grn_number" => $request->GRNno,
                "items" => [
                    [
                        "item_code" => $request->Item,
                        "qty" => $request->qty,
                        "t_warehouse" => $request->Warehouse,
                        "grn_number" => $request->GRNno
                    ]
                ]
            ];

            $frappeApi = new FrappeApiClient();
            $result = $frappeApi->save('Stock Entry', $data);

            if ($result['error']) {
                return $this->responseBody(false, "save", "saveWastage", $result['data']);
            } else {
                $docName = $result['data']['data']['name'];
                $updateResult = $frappeApi->update('Stock Entry', $docName, ["docstatus" => 1]);

                if ($updateResult['error']) {
                    return $this->responseBody(false, "save", "saveWastage", $updateResult['data']);
                } else {
                    return $this->responseBody(true, "save", "saveWastage", $updateResult['data']);
                }
            }
        } catch (Exception $exception) {
            $errorMessage = $exception->getMessage();
            return $this->responseBody(false, "save", "saveWastage", $errorMessage);
        }
    }
    public function loadWastageModleData($GRNno)
    {
        try {
            $frappeApi = new FrappeApiClient();
            $result = $frappeApi->customGetMethod('grn_waste_stock', ['grn_no' => $GRNno]);

            if ($result['error']) {
                return $this->responseBody(false, "loadWastageModleData", "error", $result['data']);
            } else {
                return $this->responseBody(true, "loadWastageModleData", "found", $result['data']['data']);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadWastageModleData", "error", $exception->getMessage());
        }
    }

}
