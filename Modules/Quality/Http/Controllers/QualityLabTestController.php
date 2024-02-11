<?php

namespace Modules\Quality\Http\Controllers;

use App\Http\common\commonFeatures;
use App\Http\common\nameingSeries;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Quality\Entities\LabTestHd;
use Modules\Quality\Entities\LabTestType;
use Modules\Buying\Entities\GRN;
use Illuminate\Support\Facades\Auth;
use Modules\Buying\Entities\Supplier;
use Modules\HRM\Entities\Employee;
use Modules\Mnu\Entities\ProductionDetail;
use Modules\Quality\Entities\FishSpeciesLabTestThresholds;
use Modules\Quality\Entities\LabTestDtlComposition;
use Modules\Quality\Entities\LabTestDtlCompositionDetail;
use Modules\Quality\Entities\LabTestDtlCompositionsResults;
use Modules\Quality\Entities\LabTestDtlType;
use Modules\Quality\Entities\LotLabTestResult;
use Modules\Quality\Entities\ProdDtlLabTestResult;
use Modules\Sf\Entities\Fishspecies;

class QualityLabTestController extends Controller
{
    use commonFeatures, nameingSeries;

    public function loadqualitylabtests(Request $request)
    {
        try {

            $QualityLabTestHd = LabTestHd::select('quality_lab_test_hd.id', 'quality_lab_test_hd.labTestNo', 'quality_lab_test_hd.testDate', 'quality_lab_test_hd.status', DB::raw('GROUP_CONCAT(DISTINCT quality_lab_test_types.testTypeName SEPARATOR ",") as testTypes'), DB::raw('GROUP_CONCAT(DISTINCT buying_fish_grn_dtl.lot_grnno SEPARATOR ",") as lot_grnno'))
                ->orderBy('quality_lab_test_hd.id', 'ASC')
                ->leftJoin('quality_lab_test_dtl_types', 'quality_lab_test_dtl_types.testHdId', '=', 'quality_lab_test_hd.id')
                ->leftJoin('quality_lab_test_types', 'quality_lab_test_dtl_types.testTypeId', '=', 'quality_lab_test_types.id')
                ->leftJoin('quality_lab_test_dtl_compositions', 'quality_lab_test_dtl_compositions.testHdId', '=', 'quality_lab_test_hd.id')
                ->leftJoin('quality_lab_test_dtl_compositions_dtl', 'quality_lab_test_dtl_compositions_dtl.compHdId', '=', 'quality_lab_test_dtl_compositions.id')
                ->leftJoin('buying_fish_grn_dtl', 'buying_fish_grn_dtl.id', '=', 'quality_lab_test_dtl_compositions_dtl.grnDtlId')
                ->groupBy('quality_lab_test_hd.id')
                ->where('quality_lab_test_hd.companyId', '=', Auth::user()->company_id);

            if ($request->startDate != 0 && $request->endDate != 0) {
                $QualityLabTestHd = $QualityLabTestHd->whereBetween('quality_lab_test_hd.testDate', [$request->startDate, $request->endDate]);
            }
            if ($request->has('testType') && $request->testType != null) {
                $QualityLabTestHd = $QualityLabTestHd->where('quality_lab_test_dtl_types.testTypeId', $request->testType);
            }
            if ($request->has('status') && $request->status != null) {
                $QualityLabTestHd = $QualityLabTestHd->where('quality_lab_test_dtl_types.status', $request->status);
            }
            if ($request->has('grnNo') && $request->grnNo != null) {
                $QualityLabTestHd = $QualityLabTestHd->where('buying_fish_grn_dtl.lot_grnno', $request->grnNo);
            }
            $QualityLabTestHd =  $QualityLabTestHd->get();

            return $this->responseBody(true, "loadqualitylabtests", "found", $QualityLabTestHd);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadqualitylabtests", "Something went wrong", $ex->getMessage());
        }
    }
    public function deleteQualityLabTest($id)
    {
        try {
            $LabTestDtlType = LabTestDtlType::where('testHdId', $id)->delete();
            $QualityLabTestHd = LabTestHd::where('id', $id)->delete();

            return $this->responseBody(true, "deleteQualityLabTest", "LabTestType Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "deleteQualityLabTest", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadQualityLabTest($id)
    {
        try {
            $QualityLabTestHd = LabTestHd::where('id', $id)->first();
            return $this->responseBody(true, "loadQualityLabTest", "found ", $QualityLabTestHd);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadQualityLabTest", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadDropdownData()
    {
        try {
            $LabTestType = LabTestType::where('enabled', true)->select('id', 'testTypeCode', 'testTypeName');
            $grn = GRN::select('id', 'grnno', 'grndate');


            return $this->responseBody(true, "loadDropdownData", "found", [
                'LabTestType' => $LabTestType->get(),
                'grn' => $grn->get()
            ]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDropdownData", "Something went wrong", $ex->getMessage());
        }
    }
    public function newTestSave(Request $request)
    {
        $validatedData = $request->validate([
            'newtestNo' => ['required'],
            'labTestDate' => ['required'],
            'newtestDescription' => ['required'],
        ]);
        try {
            $LabTestHd = new LabTestHd();
            $LabTestHd->companyId = Auth::user()->company_id;
            $LabTestHd->labTestNo = $this->nameSeris('Lab Test');
            $LabTestHd->testDate = $request->labTestDate;
            $LabTestHd->testDescription = $request->newtestDescription;
            $LabTestHd->created_by = Auth::user()->id;
            $save = $LabTestHd->save();

            if ($save) {
                foreach ($request->newTestTestType as $newTestTestType) {
                    $LabTestDtlType = new  LabTestDtlType();
                    $LabTestDtlType->testHdId =  $LabTestHd->id;
                    $LabTestDtlType->testTypeId =  (int)$newTestTestType;
                    $LabTestDtlType->created_by = Auth::user()->id;
                    $LabTestDtlType->status =  0;
                    $LabTestDtlType->save();
                }
            }


            if ($save) {
                return $this->responseBody(true, "newTestSave", "New Test Saved", $LabTestHd->labTestNo);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "newTestSave", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            // 'testDescription' => ['required'],
        ]);
        try {
            $LabTestHd = LabTestHd::find($request->id);
            $LabTestHd->testDate = $request->labTestDetailsDate;
            $LabTestHd->testDescription = $request->testDescription;
            $LabTestHd->status = $request->testDetailsStatus;
            $LabTestHd->modified_by = Auth::user()->id;
            $save = $LabTestHd->save();

            if ($save) {
                return $this->responseBody(true, "update", "LabTestType Updated", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "update", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadGrns(Request $request)
    {

        try {
            $Grn = DB::table('buying_fish_grn_dtl')
                ->select('buying_fish_grn_dtl.id', 'buying_fish_grn_dtl.lot_grnno', 'buying_fish_grn_dtl.lot_serial_no', 'buying_fish_grn_dtl.net_weight', 'sf_fish_species.FishCode')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl.fish_type_id')
                ->join('buying_fish_grn_hd', 'buying_fish_grn_hd.id', '=', 'buying_fish_grn_dtl.grn_id')
                ->where('buying_fish_grn_dtl.fish_type_id', $request->sampFishType)
                ->where('buying_fish_grn_hd.supplier_id', $request->sampSupplier)
                ->where('buying_fish_grn_dtl.lot_grnno', $request->sampGRNNo)
                ->get();

            return $this->responseBody(true, "loadGrns", "found", $Grn);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadGrns", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadTestSampleRequiredData()
    {
        try {
            $Fishspecies = Fishspecies::where('enabled', true)->select('id', 'FishName')->get();
            $Supplier = Supplier::where('enabled', true)->select('id', 'supplier_name')->get();
            $GRNNo = GRN::select('grnno', 'grndate')->get();

            return $this->responseBody(
                true,
                "loadTestSampleRequiredData",
                "LabTestType saved",
                [
                    'Fishspecies' => $Fishspecies,
                    'Supplier' => $Supplier,
                    'GRNNo' => $GRNNo,
                ]
            );
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadTestSampleRequiredData", "Something went wrong", $exception->getMessage());
        }
    }
    public function saveSample(Request $request)
    {

        try {
            $LabTestDtlComposition = new LabTestDtlComposition();
            $LabTestDtlComposition->sam_no = $this->nameSeris('Test Sample');
            $LabTestDtlComposition->samType = $request->sampType;
            $LabTestDtlComposition->fish_type_id = $request->sampFishType;
            $LabTestDtlComposition->remarks = $request->sampleRemarks;
            $LabTestDtlComposition->testHdId = $request->labTestHdId;
            $LabTestDtlComposition->created_by =  Auth::user()->id;
            $save = $LabTestDtlComposition->save();
            if ($save) {
                $GRNDtlids = json_decode($request->GRNDtlids);
                foreach ($GRNDtlids as $GRNDtlid) {
                    $LabTestDtlCompositionDetail = new LabTestDtlCompositionDetail();
                    $LabTestDtlCompositionDetail->compHdId = $LabTestDtlComposition->id;
                    $LabTestDtlCompositionDetail->grnDtlId = $GRNDtlid;
                    $LabTestDtlCompositionDetail->created_by = Auth::user()->id;
                    $LabTestDtlCompositionDetail->save();
                }
            }

            return $this->responseBody(true, "saveSample", "Sample saved", '');
        } catch (Exception $exception) {
            return $this->responseBody(false, "saveSample", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadTestSamplesTable($labTestHdId)
    {

        try {
            $LabTestDtlComposition =   DB::table('quality_lab_test_dtl_compositions')
                ->join('quality_lab_test_dtl_compositions_dtl', 'quality_lab_test_dtl_compositions_dtl.compHdId', '=', 'quality_lab_test_dtl_compositions.id')
                ->join('buying_fish_grn_dtl', 'quality_lab_test_dtl_compositions_dtl.grnDtlId', '=', 'buying_fish_grn_dtl.id')
                ->select(
                    'quality_lab_test_dtl_compositions.id',
                    'quality_lab_test_dtl_compositions.sam_no',
                    DB::raw('GROUP_CONCAT(CONCAT(buying_fish_grn_dtl.lot_grnno, ".", buying_fish_grn_dtl.lot_serial_no)) as GrnToFish')
                )
                ->where('quality_lab_test_dtl_compositions.testHdId', $labTestHdId)
                ->groupBy('quality_lab_test_dtl_compositions.id')
                ->get();

            return $this->responseBody(true, "loadTestSamplesTable", "saved", $LabTestDtlComposition);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadTestSamplesTable", "Something went wrong", $exception->getMessage());
        }
    }
    public function deleteSample($id)
    {
        try {
            $LabTestDtlCompositionDetail = LabTestDtlCompositionDetail::where('compHdId', (int)$id)->delete();
            $LabTestDtlComposition = LabTestDtlComposition::where('id', (int)$id)->delete();

            return $this->responseBody(true, "deleteSample", "Sample Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "deleteSample", "Something went wrong", $exception->getMessage());
        }
    }
    public function editSample($id)
    {
        try {
            $LabTestDtlComposition = LabTestDtlComposition::select([
                'sam_no',
                'samType',
                'fish_type_id',
                'remarks',
                'testHdId',
                'id',
            ])
                ->where('id', (int)$id)
                ->first();

            $Grn = DB::table('buying_fish_grn_dtl')
                ->select('buying_fish_grn_dtl.id', 'buying_fish_grn_dtl.lot_grnno', 'buying_fish_grn_dtl.lot_serial_no', 'buying_fish_grn_dtl.net_weight', 'sf_fish_species.FishCode')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl.fish_type_id')
                ->join('buying_fish_grn_hd', 'buying_fish_grn_hd.id', '=', 'buying_fish_grn_dtl.grn_id')
                ->join('quality_lab_test_dtl_compositions_dtl', 'quality_lab_test_dtl_compositions_dtl.grnDtlId', '=', 'buying_fish_grn_dtl.id')
                ->where('quality_lab_test_dtl_compositions_dtl.compHdId', $id)
                ->get();
            return $this->responseBody(true, "editSample", "Sample Deleted", ['LabTestDtlComposition' => $LabTestDtlComposition, 'Grn' => $Grn]);
        } catch (Exception $exception) {
            return $this->responseBody(false, "editSample", "Something went wrong", $exception->getMessage());
        }
    }
    public function updateSample(Request $request)
    {

        try {
            $id = $request->compositionId;

            $LabTestDtlComposition =  LabTestDtlComposition::find($id);
            $LabTestDtlComposition->samType = $request->sampType;
            $LabTestDtlComposition->fish_type_id = $request->sampFishType;
            $LabTestDtlComposition->remarks = $request->sampleRemarks;
            $LabTestDtlComposition->modified_by =  Auth::user()->id;
            $save = $LabTestDtlComposition->save();

            if ($save) {
                $LabTestDtlCompositionDetail = LabTestDtlCompositionDetail::where('compHdId', (int)$id)->delete();
                $GRNDtlids = json_decode($request->GRNDtlids);
                foreach ($GRNDtlids as $GRNDtlid) {
                    $LabTestDtlCompositionDetail = new LabTestDtlCompositionDetail();
                    $LabTestDtlCompositionDetail->compHdId = $LabTestDtlComposition->id;
                    $LabTestDtlCompositionDetail->grnDtlId = $GRNDtlid;
                    $LabTestDtlCompositionDetail->created_by = Auth::user()->id;
                    $LabTestDtlCompositionDetail->save();
                }
            }

            return $this->responseBody(true, "updateSample", "Sample Updated", '');
        } catch (Exception $exception) {
            return $this->responseBody(false, "updateSample", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadTestType($labTestHdId)
    {
        try {
            $LabTestDtlType = DB::table('quality_lab_test_dtl_types')
                ->join('quality_lab_test_types', 'quality_lab_test_types.id', '=', 'quality_lab_test_dtl_types.testTypeId')
                ->select([
                    'quality_lab_test_types.testTypeName',
                    'quality_lab_test_dtl_types.status',
                    'quality_lab_test_dtl_types.id'
                ])
                ->where('quality_lab_test_dtl_types.testHdId', $labTestHdId)
                ->get();
            return $this->responseBody(true, "loadTestType", "Found", $LabTestDtlType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadTestType", "Something went wrong", $exception->getMessage());
        }
    }
    public function deleteTestType($id)
    {
        try {
            $LabTestDtlType = LabTestDtlType::where('id', (int)$id)->delete();

            return $this->responseBody(true, "deleteTestType", "Sample Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "deleteTestType", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadRequiredDataAddTestTypeModel()
    {
        try {
            $LabTestType = LabTestType::where('enabled', true)->select('id', 'testTypeName')->get();
            $employee = Employee::where('enabled', true)->select('id', 'employee_name')->get();

            return $this->responseBody(
                true,
                "loadRequiredDataAddTestTypeModel",
                "Sample Deleted",
                [
                    'LabTestType' => $LabTestType,
                    'employee' => $employee,
                ]
            );
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadRequiredDataAddTestTypeModel", "Something went wrong", $exception->getMessage());
        }
    }
    public function addTestType(Request $request)
    {
        if (LabTestDtlType::where('testHdId', $request->labTestHdId)->where('testTypeId', $request->selectedTestTypes)->exists()) {
            $this->validationError('selectedTestTypes', 'Test type already added');
        }
        try {

            $LabTestDtlType = new  LabTestDtlType();
            $LabTestDtlType->testHdId =  $request->labTestHdId;
            $LabTestDtlType->testTypeId =   $request->selectedTestTypes;
            $LabTestDtlType->testDateTime =   $request->labTestTypeDateTime;
            $LabTestDtlType->testEquipment =   $request->testEqup;
            $LabTestDtlType->testBy =   $request->testTypeTestBy;
            $LabTestDtlType->verifiedBy =   $request->testTypeVerifydBy;
            $LabTestDtlType->created_by = Auth::user()->id;
            $LabTestDtlType->status =  0;
            $LabTestDtlType->save();

            return $this->responseBody(true, "addTestType", "TestType Saved", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "addTestType", "Something went wrong", $exception->getMessage());
        }
    }
    public function editAndTestResults($LbtestDtLTypeId, $labTestHdId)
    {
        try {

            $LabTestDtlComposition = DB::table('quality_lab_test_dtl_compositions')
                ->leftJoin('quality_lab_test_dtl_compositions_results', function ($join) use ($LbtestDtLTypeId) {
                    $join->on('quality_lab_test_dtl_compositions_results.compHdId', '=', 'quality_lab_test_dtl_compositions.id')
                        ->where('quality_lab_test_dtl_compositions_results.testDtlTypeId', '=', (int)$LbtestDtLTypeId);
                })
                ->leftJoin('quality_fish_species_lab_test_thresholds', function ($join) {
                    $join->on('quality_fish_species_lab_test_thresholds.fishSpeciesId', '=', 'quality_lab_test_dtl_compositions.fish_type_id')
                        ->where('quality_fish_species_lab_test_thresholds.labTestTypeId', '=', 'quality_lab_test_dtl_compositions_results.testTypeId')
                        ->where('quality_fish_species_lab_test_thresholds.companyId', '=', Auth::user()->company_id);
                })
                ->select(
                    'quality_lab_test_dtl_compositions.id',
                    'quality_lab_test_dtl_compositions.sam_no',
                    'quality_lab_test_dtl_compositions_results.testResultValue',
                    'quality_lab_test_dtl_compositions_results.isResultsSet',
                    DB::raw('(CASE WHEN quality_lab_test_dtl_compositions_results.testResultValue < quality_fish_species_lab_test_thresholds.alertThreshold THEN 0
                    WHEN quality_lab_test_dtl_compositions_results.testResultValue >= quality_fish_species_lab_test_thresholds.alertThreshold
                    AND quality_lab_test_dtl_compositions_results.testResultValue < quality_fish_species_lab_test_thresholds.lockThreshold
                    THEN 1 ELSE 2 END) AS result_status')
                )
                ->where('quality_lab_test_dtl_compositions.testHdId', $labTestHdId)
                ->get();

            $LabTestDtlType = LabTestDtlType::join('quality_lab_test_types', 'quality_lab_test_types.id', '=', 'quality_lab_test_dtl_types.testTypeId')->select(
                'quality_lab_test_dtl_types.id',
                'quality_lab_test_dtl_types.testTypeId',
                'quality_lab_test_dtl_types.status',
                'quality_lab_test_dtl_types.testDateTime',
                'quality_lab_test_dtl_types.testEquipment',
                'quality_lab_test_dtl_types.testBy',
                'quality_lab_test_dtl_types.verifiedBy',
                'quality_lab_test_types.testTypeName',

            )->where('testHdId', $labTestHdId)->first();

            // $LabTestType = LabTestType::where('enabled', true)->select('id', 'testTypeName')->get();
            $employee = Employee::where('enabled', true)->select('id', 'employee_name')->get();


            return $this->responseBody(true, "editAndTestResults", "TestType Saved", [
                'LabTestDtlComposition' => $LabTestDtlComposition,
                'LabTestDtlType' => $LabTestDtlType,
                // 'LabTestType' => $LabTestType,
                'employee' => $employee,
            ]);
        } catch (Exception $exception) {
            return $this->responseBody(false, "editAndTestResults", "Something went wrong", $exception->getMessage());
        }
    }
    public function UpdatTestType(Request $request)
    {
        try {
            // return $request->all();
            $LabTestDtlType = LabTestDtlType::where('id', $request->id)
                ->update([
                    'testDateTime' => $request->labTestResultsDateTime,
                    'testEquipment' => $request->testEquipment,
                    'testBy' => $request->testBy,
                    'verifiedBy' => $request->verifiedBy,
                    'status' => $request->status,

                ]);

            return $this->responseBody(true, "UpdatTestType", "TestType Saved", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "UpdatTestType", "Something went wrong", $exception->getMessage());
        }
    }
    public function UpdateResulValue(Request $request)
    {
        try {
            $LotLabTestResult = LabTestDtlCompositionsResults::updateOrCreate(
                [
                    'compHdId' =>  $request->compHdId,
                    'testTypeId' => LabTestDtlType::where('id', $request->testDtlTypeId)->first('testTypeId')->testTypeId,
                    'testDtlTypeId' =>  $request->testDtlTypeId
                ],
                [
                    'created_by' => Auth::user()->id,
                    'modified_by' => Auth::user()->id,
                    'testResultValue' => $request->val,
                ]
            );

            return $this->responseBody(true, "UpdateResulValue", "TestType Saved", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "UpdateResulValue", "Something went wrong", $exception->getMessage());
        }
    }
    public function UpdateResult(Request $request)
    {
        try {
            // return $request->all();
            $arr = [];

            $LabTestDtlCompositionDetails = LabTestDtlCompositionDetail::where('compHdId', $request->LabTestDtlCompositionId)->get('grnDtlId');
            $fish_type_id = LabTestDtlComposition::where('id', $request->LabTestDtlCompositionId)->first('fish_type_id')->fish_type_id;
            $testTypeId = LabTestDtlType::where('id', $request->testDtlTypeId)->select('testTypeId')->first()->testTypeId;
            $testTypeName = LabTestType::where('id', $testTypeId)->select('testTypeName')->first()->testTypeName;
            $labTestNo = LabTestHd::where('id', $request->labTestHdId)->select('labTestNo')->first('labTestNo')->labTestNo;
            $threshold = FishSpeciesLabTestThresholds::where('fishSpeciesId', $fish_type_id)
                ->where('companyId', Auth::user()->company_id)->where('labTestTypeId', $testTypeId)->first();



            foreach ($LabTestDtlCompositionDetails as  $LabTestDtlCompositionDetail) {
                LotLabTestResult::updateOrCreate(
                    [
                        'grnDtlId' => $LabTestDtlCompositionDetail->grnDtlId,
                        'testTypeId' => $testTypeId, //detail type -testDtlTypeId
                    ],
                    [
                        'labTestId' =>  $request->labTestHdId,
                        'labTestNo' =>  $labTestNo, //lab test hd
                        'labTestDtlCompId' =>  $request->LabTestDtlCompositionId,
                        'labTestDateTime' =>  $request->testDateTime,
                        'testTypeName' => $testTypeName,
                        'resultValue' =>  $request->value,
                        'alertThreshold' =>  $threshold->alertThreshold,
                        'lockThreshold' =>  $threshold->lockThreshold,
                        'isAutoLock' =>  $request->withStatus,
                        'resultUpdatedAt' => Carbon::now()->toDateTimeString(),
                        'resultUpdatedBy' => Auth::user()->id,
                        'created_by' =>  Auth::user()->id,
                        'modified_by' =>  Auth::user()->id,
                    ]
                );
                array_push($arr, $LabTestDtlCompositionDetail->grnDtlId);
            }
            $ProductionDetailIds = ProductionDetail::whereIn('grn_dtl_lot_id', $arr)->select('id')->get();

            foreach ($ProductionDetailIds as $ProductionDetailId) {
                $LotLabTestResult = ProdDtlLabTestResult::updateOrCreate(
                    ['prodDtlId' => $ProductionDetailId->id, 'testTypeId' =>  $testTypeId],
                    [
                        'labTestId' =>  $request->labTestHdId,
                        'labTestNo' =>  $labTestNo,
                        'labTestDtlCompId' => $request->LabTestDtlCompositionId,
                        'labTestDateTime' => $request->testDateTime,
                        'testTypeName' => $testTypeName,
                        'resultValue' =>  $request->value,
                        'alertThreshold' => $threshold->alertThreshold,
                        'lockThreshold' => $threshold->lockThreshold,
                        'isAutoLock' => $request->withStatus,
                        'resultUpdatedAt' => Carbon::now()->toDateTimeString(),
                        'resultUpdatedBy' => Auth::user()->id,
                        'created_by' =>  Auth::user()->id,
                        'modified_by' =>  Auth::user()->id,

                    ]
                );
            }

            return $this->responseBody(true, "UpdateResult", "TestType Saved", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "UpdateResult", "Something went wrong", $exception->getMessage());
        }
    }
    public function scanToAdd($barcode)
    {
        try {
            $Grn = DB::table('buying_fish_grn_dtl')
                ->select('buying_fish_grn_dtl.id', 'buying_fish_grn_dtl.lot_grnno', 'buying_fish_grn_dtl.lot_serial_no', 'buying_fish_grn_dtl.net_weight', 'sf_fish_species.FishCode')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl.fish_type_id')
                ->join('buying_fish_grn_hd', 'buying_fish_grn_hd.id', '=', 'buying_fish_grn_dtl.grn_id')
                ->where('buying_fish_grn_dtl.lot_barcode', $barcode)
                ->get();
            return $this->responseBody(true, "UpdateResulValue", "TestType Saved", $Grn);
        } catch (Exception $exception) {
            return $this->responseBody(false, "UpdateResulValue", "Something went wrong", $exception->getMessage());
        }
    }
}
