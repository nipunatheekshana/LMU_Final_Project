<?php

namespace Modules\Quality\Http\Controllers;

use App\Http\common\activityLog;
use App\Http\common\commonFeatures;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Buying\Entities\GRN;
use Modules\Buying\Entities\GRNDetail;
use Modules\Mnu\Entities\ProductionDetail;
use Modules\Quality\Entities\LabTestType;
use Modules\Quality\Entities\LotLabTestResult;
use Modules\Quality\Entities\ProdDtlLabTestResult;
use Modules\Sf\Entities\Boat;
use Modules\Sf\Entities\FishGrade;
use Modules\Sf\Entities\Landingsite;

class QualityControleController extends Controller
{
    use commonFeatures, activityLog;
    public function loadGrns(Request $request)
    {
        try {
            // return $request->all();
            $selectarr = [
                'buying_fish_grn_hd.grnno',
                'buying_fish_grn_hd.grndate',
                'buying_fish_grn_hd.grn_type',
                'buying_suppliers.supplier_name',
                'buying_fish_grn_hd.totalQty',
                'buying_fish_grn_hd.totFishWeight',
                'buying_fish_grn_hd.unprocessedPCs',
                'buying_fish_grn_hd.processedPcs',
                'buying_fish_grn_hd.transferPcs',
                'buying_fish_grn_hd.rejectPcs',
                'buying_fish_grn_hd.unload_status',
                'buying_fish_grn_hd.finance_status',
                'buying_fish_grn_hd.voucher_status',
                'buying_fish_grn_hd.id',
            ];
            // $Grns=GRN::all();
            $Grns = DB::table('buying_fish_grn_hd')
                ->leftJoin('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id');
            if ($request->supplier != null) {
                $Grns = $Grns->where('buying_fish_grn_hd.supplier_id', (int)$request->supplier);
            }
            if ($request->boat != null) {
                $Grns = $Grns->where('buying_fish_grn_hd.boat_registration_number', $request->boat);
            }
            if ($request->type != null) {
                $Grns = $Grns->where('buying_fish_grn_hd.grn_type', $request->type);
            }
            // return $request->endDate ;
            if ($request->startDate != 0 && $request->endDate != 0) {
                $Grns = $Grns->whereBetween('buying_fish_grn_hd.grndate', [$request->startDate, $request->endDate]);
            }
            // elseif ((int)$request->startDate == 0 && (int)$request->endDate == 0) {
            //     $Grns = $Grns->whereBetween('buying_fish_grn_hd.grndate', [ Carbon::today()->subDays(30)->toDateString(),Carbon::today()->toDateString()]);
            // }
            $Grns =  $Grns->select($selectarr)
                ->get();

            return $this->responseBody(true, "loadGrns", "found", $Grns);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadGrns", "Something went wrong", $ex->getMessage());
        }
    }
    public function addGrn($GrnId, $testType)
    {
        try {
            $selectarr = [
                'buying_fish_grn_hd.grnno',
                'buying_fish_grn_hd.grndate',
                'buying_suppliers.supplier_name',
                'buying_fish_grn_hd.totalQty',
                'buying_fish_grn_hd.unprocessedPCs',
                'buying_fish_grn_hd.processedPcs',
                'buying_fish_grn_hd.unload_status',
                'buying_fish_grn_hd.finance_status',
                'buying_fish_grn_hd.voucher_status',
                'buying_fish_grn_hd.id',
                'buying_fish_grn_hd.boat_landing_site_id',
                'buying_fish_grn_hd.boat_id',

            ];
            $GrnsHeader = DB::table('buying_fish_grn_hd')
                ->leftJoin('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id')
                ->where('buying_fish_grn_hd.id', (int)$GrnId)
                ->select($selectarr)
                ->first();

            $grnDetails = DB::table('buying_fish_grn_dtl')
                ->join('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl.fish_type_id')
                ->leftJoin('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl.item_size_id')
                ->leftJoin('quality_lot_lab_test_result', function ($join) use ($testType) {
                    $join->on('buying_fish_grn_dtl.id', '=', 'quality_lot_lab_test_result.grnDtlId')
                        ->where('quality_lot_lab_test_result.testTypeId', '=', (int)$testType);
                })
                ->where('buying_fish_grn_dtl.grn_id', (int)$GrnId)
                ->select([
                    'buying_fish_grn_dtl.lot_serial_no',
                    'sf_fish_species.FishCode',
                    'buying_fish_grn_dtl.quality_grade',
                    'buying_grn_fish_size_matrix.SizeDescription',
                    'buying_fish_grn_dtl.net_weight',
                    'buying_fish_grn_dtl.item_Status',
                    'quality_lot_lab_test_result.resultValue AS ppm_level',
                    'buying_fish_grn_dtl.quality_verify_status',
                    'buying_fish_grn_dtl.id',
                ])
                ->get();
            return $this->responseBody(true, "addGrn", "found", ['GrnsHeader' => $GrnsHeader, 'grnDetails' => $grnDetails]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "addGrn", "Something went wrong", $ex->getMessage());
        }
    }

    public function loadPcsDetails($grnDtlId, $testType)
    {
        try {
            $pce = DB::table('mnu_production_dtl')
                ->leftJoin('quality_prod_dtl_lab_test_result', function ($join) use ($testType) {
                    $join->on('quality_prod_dtl_lab_test_result.prodDtlId', '=', 'mnu_production_dtl.id')
                        ->where('quality_prod_dtl_lab_test_result.testTypeId', '=', (int)$testType);
                })
                ->where('mnu_production_dtl.grn_dtl_lot_id', (int)$grnDtlId)
                ->select([
                    'mnu_production_dtl.pcs_no',
                    'mnu_production_dtl.pcs_barcode',
                    'mnu_production_dtl.pcs_weight',
                    'mnu_production_dtl.pcs_status',
                    'quality_prod_dtl_lab_test_result.resultValue',
                    'mnu_production_dtl.lock_status',
                    'mnu_production_dtl.id',

                ])
                ->get();
            return $this->responseBody(true, "loadPcsDetails", "found", $pce);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPcsDetails", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadTestTypes()
    {
        try {
            $LabTestType = LabTestType::where('enabled', true)
                ->where('companyId', Auth::user()->company_id)
                ->select('id', 'testTypeName')
                ->get();
            return $this->responseBody(true, "loadTestTypes", "found", $LabTestType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadTestTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function locuUnlockgrnDetails($GrnDtlId, $status)
    {
        try {

            $GRNDetail =  GRNDetail::where('id', (int)$GrnDtlId);
            $ProductionDetail =  ProductionDetail::where('grn_dtl_lot_id', (int)$GrnDtlId);
            switch ($status) {
                case 'unlock':
                    $GRNDetail =  $GRNDetail->update([
                        'quality_verify_status' => 0,
                        'quality_verify_date' => Carbon::now()->toDateTimeString(),
                        'quality_verify_userid' => Auth::user()->id,
                    ]);
                    $ProductionDetail = $ProductionDetail->update(['lock_status' => 0]);

                    //log activity
                    $this->logActivity('fa fa-unlock', 'success', 'Fish Status Unlock', 'grnDetail', $GrnDtlId);
                    break;
                case 'lock':
                    $GRNDetail =  $GRNDetail->update([
                        'quality_verify_status' => 1,
                        'quality_verify_date' => Carbon::now()->toDateTimeString(),
                        'quality_verify_userid' => Auth::user()->id,
                    ]);
                    $ProductionDetail = $ProductionDetail->update(['lock_status' => 1]);
                    //log activity
                    $this->logActivity('fa fa-lock', 'danger', 'Fish Status lock', 'grnDetail', $GrnDtlId);

                    break;
            }

            return $this->responseBody(true, "locuUnlockgrnDetails", "found", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "locuUnlockgrnDetails", "Something went wrong", $ex->getMessage());
        }
    }
    public function lockUnlockPcs($pcsId, $status)
    {
        try {
            $ProductionDetail =  ProductionDetail::where('id', (int)$pcsId);
            switch ($status) {
                case 'unlock':
                    $ProductionDetail = $ProductionDetail->update(['lock_status' => 0]);
                    break;
                case 'lock':
                    $ProductionDetail = $ProductionDetail->update(['lock_status' => 1]);
                    break;
            }
            return $this->responseBody(true, "locuUnlockgrnDetails", "found", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "locuUnlockgrnDetails", "Something went wrong", $ex->getMessage());
        }
    }
    public function bulkLockUnlockFish(Request $request, $status)
    {
        try {

            $GRNDetail =  GRNDetail::whereIn('id', $request->arr);
            $ProductionDetail =  ProductionDetail::whereIn('grn_dtl_lot_id', $request->arr);
            switch ($status) {
                case 'unlock':
                    $GRNDetail =  $GRNDetail->update([
                        'quality_verify_status' => 0,
                        'quality_verify_date' => Carbon::now()->toDateTimeString(),
                        'quality_verify_userid' => Auth::user()->id,
                    ]);
                    $ProductionDetail = $ProductionDetail->update(['lock_status' => 0]);

                    //log activity
                    foreach ($request->arr as $id) {
                        $this->logActivity('fa fa-unlock', 'success', 'Fish Status Unlock', 'grnDetail', $id);
                    }
                    break;
                case 'lock':
                    $GRNDetail =  $GRNDetail->update([
                        'quality_verify_status' => 1,
                        'quality_verify_date' => Carbon::now()->toDateTimeString(),
                        'quality_verify_userid' => Auth::user()->id,
                    ]);
                    $ProductionDetail = $ProductionDetail->update(['lock_status' => 1]);

                    //log activity
                    foreach ($request->arr as $id) {
                        $this->logActivity('fa fa-lock', 'danger', 'Fish Status lock', 'grnDetail', $id);
                    }
                    break;
            }

            return $this->responseBody(true, "bulkLockUnlockFish", "found",  $request->arr);
        } catch (Exception $ex) {
            return $this->responseBody(false, "bulkLockUnlockFish", "Something went wrong", $ex->getMessage());
        }
    }
    public function bulkLockUnlockPcs(Request $request,  $status)
    {
        try {
            $ProductionDetail =  ProductionDetail::whereIn('id',  $request->arr);
            switch ($status) {
                case 'unlock':
                    $ProductionDetail = $ProductionDetail->update(['lock_status' => 0]);
                    break;
                case 'lock':
                    $ProductionDetail = $ProductionDetail->update(['lock_status' => 1]);
                    break;
            }
            return $this->responseBody(true, "bulkLockUnlockPcs", "found", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "bulkLockUnlockPcs", "Something went wrong", $ex->getMessage());
        }
    }
    public function updateTestValues(Request $request)
    {
        try {
            foreach ($request->arr as $id) {
                $LotLabTestResult = LotLabTestResult::updateOrCreate(
                    ['grnDtlId' => $id, 'testTypeId' =>  $request->testType],
                    ['resultValue' => $request->val]
                );

                //log activity
                $this->logActivity(
                    'fa fa-flask',
                    'info',
                    LabTestType::where('id', $request->testType)->first('testTypeName')->testTypeName . " Set to $request->val",
                    'grnDetail',
                    $id
                );
            }
            $ProductionDetailIds = ProductionDetail::whereIn('grn_dtl_lot_id', $request->arr)->select('id')->get();

            foreach ($ProductionDetailIds as $ProductionDetailId) {
                $LotLabTestResult = ProdDtlLabTestResult::updateOrCreate(
                    ['prodDtlId' => $ProductionDetailId->id, 'testTypeId' =>  $request->testType],
                    ['resultValue' => $request->val]
                );
            }

            return $this->responseBody(true, "updateTestValues", "found", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "updateTestValues", "Something went wrong", $ex->getMessage());
        }
    }
    public function rejectAllowFish(Request $request, $status)
    {
        try {
            $GRNDetail =  GRNDetail::whereIn('id', $request->arr);
            $ProductionDetail =  ProductionDetail::whereIn('grn_dtl_lot_id', $request->arr);

            switch ($status) {
                case 'rej':
                    $GRNDetail =  $GRNDetail->update([
                        'quality_verify_status' => 2,
                        'quality_verify_date' => Carbon::now()->toDateTimeString(),
                        'quality_verify_userid' => Auth::user()->id,
                        'reject_status' => 1,
                        'reject_reason_code' => $request->reson,
                        'reject_datetime' => Carbon::now()->toDateTimeString(),
                        'reject_user_id' => Auth::user()->id,
                    ]);
                    $ProductionDetail =   $ProductionDetail->update(['lock_status' => 2]);

                    //log activity
                    foreach ($request->arr as $id) {
                        $this->logActivity('fa fa-times-circle', 'warning', ' Fish Status Rejected', 'grnDetail', $id);
                    }
                    break;
                case 'allow':
                    $GRNDetail =  $GRNDetail->update([
                        'quality_verify_status' => 0,
                        'quality_verify_date' => Carbon::now()->toDateTimeString(),
                        'quality_verify_userid' => Auth::user()->id,
                        'reject_status' => 0,
                        'reject_reason_code' => '',
                        'reject_datetime' => Carbon::now()->toDateTimeString(),
                        'reject_user_id' => Auth::user()->id,
                    ]);
                    $ProductionDetail =   $ProductionDetail->update(['lock_status' => 0]);

                    //log activity
                    foreach ($request->arr as $id) {
                        $this->logActivity('fa fa-check-circle', 'secondary', 'Fish Status Allowed', 'grnDetail', $id);
                    }
                    break;
            }
            return $this->responseBody(true, "rejectAllowFish", "found", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "rejectAllowFish", "Something went wrong", $ex->getMessage());
        }
    }
    public function rejectAllowPcs(Request $request, $status)
    {
        try {
            $ProductionDetail =  ProductionDetail::whereIn('id', $request->arr);


            switch ($status) {
                case 'rej':
                    $ProductionDetail = $ProductionDetail->update(['lock_status' => 2]);
                    break;
                case 'allow':
                    $ProductionDetail = $ProductionDetail->update(['lock_status' => 0]);
                    break;
            }


            return $this->responseBody(true, "rejectAllowPcs", "found", $request->arr);
        } catch (Exception $ex) {
            return $this->responseBody(false, "rejectAllowPcs", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadBoatsAndLandingSites()
    {
        try {
            $Boat = Boat::where('enabled', true)->select('BoatRegNo', 'BoatName', 'LicenseExpDate', 'id')->get();
            $Landingsite = Landingsite::where('enabled', true)->select('id', 'LandingSiteName')->get();
            return $this->responseBody(true, "rejectAllowPcs", "found", ['Boat' => $Boat, 'Landingsite' => $Landingsite]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "rejectAllowPcs", "Something went wrong", $ex->getMessage());
        }
    }
    public function updateAdminChanges(Request $request, $GrnId)
    {
        try {
            $Boat = Boat::where('id', $request->boat)
                ->select([
                    'BoatRegNo',
                    'LicenseNo',
                    'LicenseExpDate',
                    'SkipperName',
                    'NoofCrew',
                    'NoofTanks',
                ])
                ->first();

            GRN::where('id', $GrnId)->update([
                'boat_landing_site_id' => $request->landingSit,
                'boat_id' => $request->boat,
                'boat_registration_number' => $Boat->BoatRegNo,
                'boat_licence_no' => $Boat->LicenseNo,
                'boat_licence_exp_date' => $Boat->LicenseExpDate,
                'boat_skipper_name' => $Boat->SkipperName,
                'boat_number_of_crew' => $Boat->NoofCrew,
                'boat_number_of_tanks' => $Boat->NoofTanks,
            ]);
            return $this->responseBody(true, "updateAdminChanges", "Updated", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "updateAdminChanges", "Something went wrong", $ex->getMessage());
        }
    }
    public function edit($GrnDtlId)
    {
        try {
            $GRNDetail = DB::table('buying_fish_grn_dtl')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl.fish_type_id')
                ->leftJoin('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl.item_size_id')
                ->where('buying_fish_grn_dtl.id', $GrnDtlId)
                ->select([
                    'buying_fish_grn_dtl.lot_serial_no',
                    'sf_fish_species.FishCode',
                    'buying_grn_fish_size_matrix.SizeDescription',
                    'buying_fish_grn_dtl.net_weight',
                    'buying_fish_grn_dtl.quality_grade',
                    'buying_fish_grn_dtl.fish_type_id'
                ])
                ->first();
            $QualityGrades = FishGrade::where('fish_species', $GRNDetail->fish_type_id)->select('QFishGrade')->get();

            return $this->responseBody(
                true,
                "edit",
                "found",
                [
                    'GRNDetail' => $GRNDetail,
                    'QualityGrades' => $QualityGrades,
                    'history' => $this->getActivityLog($GrnDtlId, 'grnDetail')
                ]
            );
        } catch (Exception $ex) {
            return $this->responseBody(false, "edit", "Something went wrong", $ex->getMessage());
        }
    }
    public function UpdateFish($quality_grade, $grnDtlId)
    {
        try {
            GRNDetail::where('id', $grnDtlId)->update(['quality_grade' => $quality_grade]);
            return $this->responseBody(true, "UpdateFish", "Updated", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "UpdateFish", "Something went wrong", $ex->getMessage());
        }
    }
}
