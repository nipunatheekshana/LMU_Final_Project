<?php

namespace Modules\Mnu\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use App\Http\common\nameingSeries;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Mnu\Entities\WorkSheetDetail;
use Modules\Settings\Entities\Process;

class PlaningDetailController extends Controller
{
    use commonFeatures, nameingSeries;
    public function split(Request $request)
    {
        // $validatedData = $request->validate([
        //     'date' => ['required'],
        //     'rqDate' => ['required'],
        //     'remarks' => ['required'],

        // ]);
        try {


            $Sheet = WorkSheetDetail::where('id', $request->wsId);

            $parentSheet = $Sheet->first();

            $planSubId1 = $this->nameSeris('Planning Number');
            $planSubId2 = 0;
            $splitedQty = 0;
            $splitedWeight = 0;
            foreach ($request->arr as $splitData) {
                $planId = $planSubId1 . $planSubId2;
                $splitData = json_decode($splitData);

                $WorkSheetDetail = new WorkSheetDetail();
                $WorkSheetDetail->plID = $planId;
                $WorkSheetDetail->mainPlID = $planSubId1;
                $WorkSheetDetail->rqDtlID = $parentSheet->rqDtlID;
                $WorkSheetDetail->plDate = $parentSheet->plDate;
                $WorkSheetDetail->planStatus = 0;
                $WorkSheetDetail->prodStatus = 0;
                $WorkSheetDetail->item = $parentSheet->item;
                $WorkSheetDetail->itemCode = $parentSheet->itemCode;
                $WorkSheetDetail->itemName = $parentSheet->itemName;
                $WorkSheetDetail->refType = $parentSheet->refType;
                $WorkSheetDetail->refNo = $parentSheet->refNo;
                $WorkSheetDetail->customer = $parentSheet->customer;
                $WorkSheetDetail->notify = $parentSheet->notify;
                $WorkSheetDetail->plannedQty = $splitData->AssignedQuantity;
                $WorkSheetDetail->plannedWeight = $splitData->AssignedWeight;
                $WorkSheetDetail->remainingQty = $splitData->AssignedQuantity;
                $WorkSheetDetail->remainingWeight = $splitData->AssignedWeight;
                $WorkSheetDetail->mnfDate = $parentSheet->mnfDate;
                $WorkSheetDetail->expDate = $parentSheet->expDate;
                $WorkSheetDetail->process = $parentSheet->process;
                $WorkSheetDetail->work_station = $splitData->workstationId;
                $WorkSheetDetail->created_by = Auth::user()->id;
                $save = $WorkSheetDetail->save();

                $planSubId2++;
                $splitedQty = (int)$splitedQty + (int)$splitData->AssignedQuantity;
                $splitedWeight = (int)$splitedWeight + (int)$splitData->AssignedWeight;
            }

            if ($save) {
                $Sheet->update([
                    'plannedQty' => (int)$parentSheet->plannedQty - (int)$splitedQty,
                    'plannedWeight' => (int)$parentSheet->plannedWeight - (int)$splitedWeight,
                    'remainingQty' => (int)$request->remainingQty,
                    'remainingWeight' => (int)$request->remainingWeight,
                ]);

                return $this->responseBody(true, "split", "WorkSheet Splited", (int)$parentSheet->plannedQty);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "split", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadProcess()
    {
        try {
            $Process = Process::where('enabled', true)->get();

            return $this->responseBody(true, "loadProcess", '', $Process);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadProcess", '', $ex->getMessage());
        }
    }
    public function loadProcessWorkstations($ProcessId)
    {
        try {
            $Process = DB::table('settings_workstations')
                ->leftJoin('settings_process_workstations', 'settings_process_workstations.WorkstationID', '=', 'settings_workstations.id')
                ->where('settings_process_workstations.ProcessID', $ProcessId)
                ->where('settings_workstations.enabled', true)
                ->select('settings_workstations.*')
                ->get();

            return $this->responseBody(true, "loadProcessWorkstations", '', $Process);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadProcessWorkstations", '', $ex->getMessage());
        }
    }
    public function loadPlans(Request $request)
    {
        try {
            $plans = DB::table('mnu_ws_plan_dtl')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_ws_plan_dtl.item')
                ->leftJoin('settings_workstations', 'settings_workstations.id', '=', 'inventory_items.work_station');


            if ($request->status != null) {
                $plans = $plans->where('mnu_ws_plan_dtl.prodStatus', $request->status);
            }
            if ($request->process != null) {
                $plans = $plans->where('mnu_ws_plan_dtl.process', $request->process);
            }
            if ($request->workStation != null) {
                $plans = $plans->where('mnu_ws_plan_dtl.work_station', $request->workStation);
            }
            if ($request->startDate != 0 && $request->endDate != 0) {
                $plans = $plans->whereBetween('mnu_ws_plan_dtl.plDate', [$request->startDate, $request->endDate]);
            }
            $plans = $plans->select('mnu_ws_plan_dtl.*', 'settings_workstations.WorkstationName')->get();

            return $this->responseBody(true, "loadPlans", '', $plans);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPlans", '', $ex->getMessage());
        }
    }
    public function loadSplitModel($wsId)
    {
        try {
            $plans = DB::table('mnu_ws_plan_dtl')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_ws_plan_dtl.item')
                ->leftJoin('settings_workstations', 'settings_workstations.id', '=', 'inventory_items.work_station')
                ->where('mnu_ws_plan_dtl.id', $wsId)
                ->select('mnu_ws_plan_dtl.*', 'settings_workstations.WorkstationName', 'inventory_items.avg_weight_per_unit')
                ->first();




            return $this->responseBody(true, "loadSplitModel", '', $plans);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSplitModel", '', $ex->getMessage());
        }
    }
    public function changeState($PlanID, $state)
    {
        try {
            $val = 0;

            switch ($state) {
                case 'hold':
                    $val = 2;
                    break;
                case 'unhold':
                    $val = 0;
                    break;
                case 'close':
                    $val = 1;
                    break;
                case 'reopen':
                    $val = 0;
                    break;

                default:
                    $val = 0;
                    break;
            }

            WorkSheetDetail::where('plID', $PlanID)->update([
                'planStatus' => $val,
                'prodStatus' => $val,
            ]);


            return $this->responseBody(true, "reOpenPlan", '', '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "reOpenPlan", '', $ex->getMessage());
        }
    }
    public function loadLastCompleatedPlans()
    {
        try {
            // $plans = DB::table('mnu_ws_plan_dtl')
            //     ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_ws_plan_dtl.item')
            //     ->select('mnu_ws_plan_dtl.*', 'settings_workstations.WorkstationName')->get();
            $plans=WorkSheetDetail::where('prodStatus',3)->latest('updated_at')->skip(0)->take(10)->get();

            return $this->responseBody(true, "loadPlans", '', $plans);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPlans", '', $ex->getMessage());
        }
    }
}
