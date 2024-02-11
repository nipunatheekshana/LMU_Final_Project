<?php

namespace Modules\Mnu\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use App\Http\common\nameingSeries;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\Item;
use Modules\Mnu\Entities\RequirementDetail;
use Modules\Mnu\Entities\RequirementDetailOfPlan;
use Modules\Mnu\Entities\WorksheetChangeRequest;
use Modules\Mnu\Entities\WorkSheetDetail;
use Modules\Settings\Entities\Process;

class ProductionPlanController extends Controller

{
    use commonFeatures, nameingSeries;
    public function loadCounts()
    {
        try {
            $Todayrequirements = RequirementDetail::where('created_at', Carbon::today())->where('planStatus', 0)->count();
            $requirements = RequirementDetail::where('planStatus', 0)->count();
            $ChangeReq = WorksheetChangeRequest::where('status', 0)->count();
            $hasChangeReqs = WorksheetChangeRequest::where('status', 0)->exists();
            $counts = [
                'Todayrequirements' => $Todayrequirements,
                'requirements' => $requirements,
                'ChangeReq' => $ChangeReq,
                'hasChangeReqs' => $hasChangeReqs,

            ];



            return $this->responseBody(true, "loadCounts", "found", $counts);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCounts", "error", $exception->getMessage());
        }
    }
    public function save(Request $request)
    {
        // $validatedData = $request->validate([
        //     'SupGroupCode' => ['required'],
        //     'SupGroupName' => ['required'],
        // ]);
        try {
            $workSheets = [];
            $RequirementDEtailsofPlans = [];
            $Requirements = [];
            if ($request->productionPlans) {
                $planSubId1 = $this->nameSeris('Planning Number');
                $planSubId2 = 0;
                //create requirement Details Table
                foreach ($request->productionPlans as $productionPlan) {
                    $productionPlan = json_decode($productionPlan);

                    $planId = $planSubId1 . $planSubId2;
                    $workSheet = [
                        'plID' => $planId,
                        'mainPlID' => $planSubId1,
                        'rqDtlID' => $productionPlan->RequirementId,
                        'plDate' => $productionPlan->PlaningDate,
                        'planStatus' => 0,
                        'prodStatus' => 0,
                        'item' => $productionPlan->ItemId,
                        'itemCode' => $productionPlan->itemCode,
                        'itemName' => $productionPlan->Item,
                        'refType' => $productionPlan->refType,
                        'refNo' => $productionPlan->RefNumber,
                        'customer' => $productionPlan->Customer,
                        'notify' => $productionPlan->NotifyParty,
                        'plannedQty' => $productionPlan->PlaningQty,
                        'plannedWeight' => $productionPlan->PlaningWeight,
                        'remainingQty' => $productionPlan->PlaningQty,
                        'remainingWeight' => $productionPlan->PlaningWeight,
                        'mnfDate' => $productionPlan->ProductionDate,
                        'expDate' => $productionPlan->ExpiryDate,
                        'process' => $productionPlan->processId,
                        'work_station' => $productionPlan->WorkstationId,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    array_push($workSheets, $workSheet);
                    $planSubId2++;
                }
                // create requirement Details of plan
                foreach ($workSheets as $workSheet) {

                    $Item = Item::where('id', $workSheet['item'])->first();

                    $MainItems = DB::table('mnu_bom_item_details')
                        ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_bom_item_details.item_id')
                        ->where('mnu_bom_item_details.bom_item_id', $Item->id)
                        ->where('mnu_bom_item_details.is_main_item', true)
                        ->select('mnu_bom_item_details.qty', 'mnu_bom_item_details.item_id', 'inventory_items.item_name', 'inventory_items.Item_Code', 'inventory_items.avg_weight_per_unit', 'inventory_items.is_manufacturing_item')
                        ->get();

                    if (!empty($MainItems)) {
                        foreach ($MainItems as $MainItem) {
                            $rqID = $this->nameSeris('Requirement ID');

                            if (!$MainItem->is_manufacturing_item) {

                                $qty = $workSheet['plannedQty'] * $MainItem->qty;
                                $RequirementDEtailsofPlan = [
                                    'rqID' => $rqID,
                                    'plID' => $workSheet['plID'],
                                    'item' => $MainItem->item_id,
                                    'itemName' => $MainItem->item_name,
                                    'itemCode' => $MainItem->Item_Code,
                                    'rqDate' => $workSheet['plDate'],
                                    'rqQty' => $qty,
                                    'rqWeight' => $MainItem->avg_weight_per_unit * $qty,
                                    'customer' => $workSheet['customer'],
                                    'notify' => $workSheet['notify'],
                                    'mnfDate' => $workSheet['mnfDate'],
                                    'expDate' => $workSheet['expDate'],
                                    'refType' => 'PL',
                                    'refNo' => $workSheet['refNo'],
                                    'created_by' => Auth::user()->id,
                                    'planStatus' => 0,
                                    'prodStatus' => 0,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ];
                            } else {
                                if (!empty($RequirementDEtailsofPlans)) {
                                    //give dsame plan number to Matching Requirements
                                    foreach ($RequirementDEtailsofPlans as $data) {
                                        if ($this->isMatchingRequirementDEtailsofPlans($MainItem, $workSheet, $data)) {
                                            $rqID = $data['rqID'];
                                        }
                                    }
                                }
                                $qty = $workSheet['plannedQty'] * $MainItem->qty;
                                $RequirementDEtailsofPlan = [
                                    'rqID' => $rqID,
                                    'plID' => $workSheet['plID'],
                                    'item' => $MainItem->item_id,
                                    'itemName' => $MainItem->item_name,
                                    'itemCode' => $MainItem->Item_Code,
                                    'rqDate' => $workSheet['plDate'],
                                    'rqQty' => $qty,
                                    'rqWeight' => $MainItem->avg_weight_per_unit * $qty,
                                    'customer' => $workSheet['customer'],
                                    'notify' => $workSheet['notify'],
                                    'mnfDate' => $workSheet['mnfDate'],
                                    'expDate' => $workSheet['expDate'],
                                    'refType' => 'PL',
                                    'refNo' => $workSheet['refNo'],
                                    'created_by' => Auth::user()->id,
                                    'planStatus' => 0,
                                    'prodStatus' => 0,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),

                                ];
                            }

                            array_push($RequirementDEtailsofPlans, $RequirementDEtailsofPlan);
                        }
                    }
                }
                //create temp array for Developing Purpse

                $tempArry2 = [];
                foreach ($RequirementDEtailsofPlans as $RequirementDEtailsofPlan) {
                    $temp2Row = [
                        'rqID' => $RequirementDEtailsofPlan['rqID'],
                        'plID' => $RequirementDEtailsofPlan['plID'],
                        'item' => $RequirementDEtailsofPlan['item'],
                        'itemName' => $RequirementDEtailsofPlan['itemName'],
                        'itemCode' => $RequirementDEtailsofPlan['itemCode'],
                        'rqQty' => $RequirementDEtailsofPlan['rqQty'],
                        'rqWeight' => $RequirementDEtailsofPlan['rqWeight'],
                        'customer' => $RequirementDEtailsofPlan['customer'],
                        'notify' => $RequirementDEtailsofPlan['notify'],
                        'mnfDate' => $RequirementDEtailsofPlan['mnfDate'],
                        'expDate' => $RequirementDEtailsofPlan['expDate'],
                        'refType' => $RequirementDEtailsofPlan['refType'],
                        'refNo' => $RequirementDEtailsofPlan['refNo'],
                        'rqDate' => $RequirementDEtailsofPlan['rqDate'],
                        'created_by' => Auth::user()->id,
                        'added' => 0 //tempory field to check if aded

                    ];
                    array_push($tempArry2, $temp2Row);
                }

                //create requirement
                for ($i = 0; $i < count($tempArry2); $i++) {
                    if (!$tempArry2[$i]['added'] == 1) {

                        $reqQty = $tempArry2[$i]['rqQty'];
                        $rqWeight = $tempArry2[$i]['rqWeight'];

                        for ($j = 0; $j < count($tempArry2); $j++) {
                            if (!$i == $j) {
                                if (!$tempArry2[$j]['added'] == 1) {
                                    if ($tempArry2[$i]['rqID'] == $tempArry2[$j]['rqID']) {

                                        $reqQty = $reqQty + $tempArry2[$j]['rqQty'];
                                        $rqWeight = $rqWeight + $tempArry2[$j]['rqWeight'];
                                        $tempArry2[$j]['added'] = 1;
                                    }
                                }
                            }
                        }

                        $procesAndWorkStation = Item::where('id', $tempArry2[$i]['item'])->select('process', 'work_station')->first();

                        $Requirement = [
                            'rqID' => $tempArry2[$i]['rqID'],
                            'item' => $tempArry2[$i]['item'],
                            'itemName' => $tempArry2[$i]['itemName'],
                            'itemCode' => $tempArry2[$i]['itemCode'],
                            'rqQty' =>  $reqQty,
                            'rqWeight' => $rqWeight,
                            'remainingQty' =>  $reqQty,
                            'remainingWeight' => $rqWeight,
                            'customer' => $tempArry2[$i]['customer'],
                            'notify' => $tempArry2[$i]['notify'],
                            //  'mnfDate' => $tempArry2[$i]['mnfDate'],
                            //  'expDate' => $tempArry2[$i]['expDate'],
                            'refType' => $tempArry2[$i]['refType'],
                            'refNo' => $tempArry2[$i]['refNo'],
                            'rqDate' => $tempArry2[$i]['rqDate'],
                            'planStatus' => 0,
                            'prodStatus' => 0,
                            'process' => $procesAndWorkStation->process,
                            'work_station' => $procesAndWorkStation->work_station,
                            'created_by' => Auth::user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                        $tempArry[$i]['added'] = 1;

                        array_push($Requirements, $Requirement);
                    }
                }
                $save = [
                    WorkSheetDetail::insert($workSheets),
                    RequirementDetailOfPlan::insert($RequirementDEtailsofPlans),
                    RequirementDetail::insert($Requirements),
                ];
            }
            if ($save) {
                foreach ($request->productionPlans as $productionPlan) {
                    $productionPlan = json_decode($productionPlan);
                    $this->updateRemainingQty(
                        $productionPlan->PlaningQty,
                        $productionPlan->PlaningWeight,
                        $productionPlan->RemainingQty,
                        $productionPlan->RemainingWeight,
                        $productionPlan->RequirementId
                    );
                }

                return $this->responseBody(
                    true,
                    "save",
                    "productionPlan saved",
                    [
                        'workSheets' => $workSheets,
                        'RequirementDEtailsofPlans' => $RequirementDEtailsofPlans,
                        'Requirements' => $Requirements,
                    ]
                );
            }
            return $this->responseBody(true, "save", "productionPlan saved", '');
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'SupGroupCode' => ['required'],
            'SupGroupName' => ['required'],
        ]);
        try {
            // $productionPlan = productionPlan::find($request->id);
            // $productionPlan->SupGroupCode = $request->SupGroupCode;
            // $productionPlan->SupGroupName = $request->SupGroupName;
            // $productionPlan->ParentSupGroupID = $request->ParentSupGroupID;
            // $productionPlan->list_index = $request->list_index;
            // $productionPlan->isGroup = $request->has('isGroup');
            // $productionPlan->enabled = $request->has('enabled');
            // $productionPlan->modified_by = Auth::user()->id;
            // $save = $productionPlan->save();

            // if ($save) {
            //     return $this->responseBody(true, "save", "productionPlan saved", 'data saved');
            // }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadproductionPlan($id)
    {
        try {
            // $productionPlan = productionPlan::where('id', $id)->first();
            // return $this->responseBody(true, "loadproductionPlan", "found", $productionPlan);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadproductionPlan", "error", $exception->getMessage());
        }
    }
    public function loadRequirements(Request $request)
    {
        try {
            $Requirements = DB::table('mnu_requirements_dtl')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_requirements_dtl.item')
                ->leftJoin('settings_processes', 'settings_processes.id', '=', 'mnu_requirements_dtl.process')
                ->leftJoin('settings_workstations', 'settings_workstations.id', '=', 'mnu_requirements_dtl.work_station')
                ->leftJoin('selling_customers', 'selling_customers.id', '=', 'mnu_requirements_dtl.customer')
                ->leftJoin('crm_addresses', 'crm_addresses.id', '=', 'mnu_requirements_dtl.notify');


            if ($request->process != null) {
                $Requirements = $Requirements->where('mnu_requirements_dtl.process', $request->process);
            }
            if ($request->workStation != null) {
                $Requirements = $Requirements->where('mnu_requirements_dtl.work_station', $request->workStation);
            }
            if ($request->startDate != 0 && $request->endDate != 0) {
                $Requirements = $Requirements->whereBetween('mnu_requirements_dtl.rqDate', [$request->startDate, $request->endDate]);
            }
            $Requirements = $Requirements->where('mnu_requirements_dtl.planStatus', 0)
                ->select(
                    'mnu_requirements_dtl.*',
                    'settings_processes.ProcessName',
                    'settings_workstations.WorkstationName',
                    'inventory_items.avg_weight_per_unit',
                    'selling_customers.CusName',
                    'crm_addresses.AddressTitle',
                )
                ->get();

            return $this->responseBody(true, "loadRequirements", '', $Requirements);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadRequirements", '', $ex->getMessage());
        }
    }
    public function loadTodayPlans(Request $request)
    {
        try {
            $totalPlaned = 0;
            $totalCompleated = 0;

            $Requirements = DB::table('mnu_ws_plan_dtl')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_ws_plan_dtl.item')
                ->where('mnu_ws_plan_dtl.planStatus', 0);

            if ($request->date != null) {
                $Requirements = $Requirements->where('mnu_ws_plan_dtl.plDate', $request->date);
            }
            if ($request->process != null) {
                $Requirements = $Requirements->where('inventory_items.process', $request->process);
            }
            if ($request->work_station != null) {
                $Requirements = $Requirements->where('inventory_items.work_station', $request->work_station);
            }

            $Requirements = $Requirements->select('mnu_ws_plan_dtl.*')->get();


            foreach ($Requirements as $Requirement) {
                $totalPlaned = $totalPlaned + $Requirement->plannedQty;
                $totalCompleated = $totalCompleated + $Requirement->completedQty;
            }

            return $this->responseBody(
                true,
                "loadTodayPlans",
                '',
                [
                    'Requirements' => $Requirements,
                    'totalCompleated' => $totalCompleated,
                    'totalPlaned' => $totalPlaned
                ]
            );
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadTodayPlans", '', $ex->getMessage());
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
    public function loadItemRequirements(Request $request)
    {
        try {
            $returnArry = [];

            foreach ($request->arr as $arryItem) {
                $Item = Item::where('id', $arryItem['ItemId'])->first();

                if ($Item->is_bom_inner_item) {
                    // $mainItem = BOMItemDetail::where('bom_item_id', $Item->id)->where('is_main_item', true)->select('qty', 'item_id')->first();
                    $mainItems = DB::table('mnu_bom_item_details')
                        ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_bom_item_details.item_id')
                        ->where('mnu_bom_item_details.bom_item_id', $Item->id)
                        ->where('mnu_bom_item_details.is_main_item', true)
                        ->select('mnu_bom_item_details.qty', 'mnu_bom_item_details.item_id', 'inventory_items.item_name')
                        ->first();
                    if (!$mainItems == null) {
                        $qty = $mainItems->qty;
                        array_push($returnArry, ['reqQty' => $qty * $mainItems->qty, 'item' => $mainItems->item_name]);
                    }
                } elseif ($Item->is_bom_outer_item) {

                    $mainItems = DB::table('mnu_bom_item_details')
                        ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_bom_item_details.item_id')
                        ->where('mnu_bom_item_details.bom_item_id', $Item->id)
                        ->where('mnu_bom_item_details.is_main_item', true)
                        ->select('mnu_bom_item_details.qty', 'mnu_bom_item_details.item_id', 'inventory_items.item_name')
                        ->get();

                    if (!$mainItems == null) {
                        foreach ($mainItems as $mainItem) {
                            $qty = $mainItem->qty;
                            array_push($returnArry, ['reqQty' => $qty * $mainItem->qty, 'item' => $mainItem->item_name]);
                        }
                    }
                } else {
                }
            }

            return $this->responseBody(true, "loadTodayPlans", '', $returnArry);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadTodayPlans", '', $ex->getMessage());
        }
    }
    public function loadPackingMaterialRequirements(Request $request)
    {
        try {
            $returnArry = [];

            foreach ($request->arr as $arryItem) {
                $Item = Item::where('id', $arryItem['ItemId'])->first();


                $PackingItems = DB::table('mnu_bom_item_details')
                    ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_bom_item_details.item_id')
                    ->where('mnu_bom_item_details.bom_item_id', $Item->id)
                    ->where('mnu_bom_item_details.is_container_item', true)
                    ->select('mnu_bom_item_details.qty', 'mnu_bom_item_details.item_id', 'inventory_items.item_name')
                    ->get();

                if (!$PackingItems == null) {
                    foreach ($PackingItems as $PackingItem) {
                        $qty = $PackingItem->qty;
                        array_push($returnArry, ['reqQty' => $qty * $PackingItem->qty, 'item' => $PackingItem->item_name]);
                    }
                }
            }

            return $this->responseBody(true, "loadTodayPlans", '', $returnArry);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadTodayPlans", '', $ex->getMessage());
        }
    }
    private function isMatchingRequirementDEtailsofPlans($item, $workSheet, $RequirementDEtailsofPlan)
    {
        $bool = false;

        if (date("d-m-Y", strtotime($RequirementDEtailsofPlan['mnfDate'])) == date("d-m-Y", strtotime($workSheet['mnfDate']))) {
            $bool = true;
        } else {
            $bool = false;
        }
        if (date("d-m-Y", strtotime($RequirementDEtailsofPlan['expDate'])) == date("d-m-Y", strtotime($workSheet['expDate']))) {
            $bool = true;
        } else {
            $bool = false;
        }
        if ($RequirementDEtailsofPlan['customer'] == $workSheet['customer']) {
            $bool = true;
        } else {
            $bool = false;
        }
        if ($RequirementDEtailsofPlan['notify'] == $workSheet['notify']) {
            $bool = true;
        } else {
            $bool = false;
        }
        if ($RequirementDEtailsofPlan['itemName'] == $item->item_name) {
            $bool = true;
        } else {
            $bool = false;
        }
        if ($RequirementDEtailsofPlan['item'] == $item->item_id) {
            $bool = true;
        } else {
            $bool = false;
        }

        return $bool;
    }
    private function updateRemainingQty($plnQty, $plnWeight, $remainqty, $remainWeight, $reqID)
    {
        try {
            $newRemainqty = $remainqty - $plnQty;
            $newPlnWeight = $remainWeight - $plnWeight;

            $RequirementDetail = RequirementDetail::find($reqID);
            $RequirementDetail->remainingQty = $newRemainqty;
            $RequirementDetail->remainingWeight = $newPlnWeight;
            $RequirementDetail->save();
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadChangeRequest()
    {
        try {
            // $WorksheetChangeRequest=WorksheetChangeRequest::where('status',0)->select('')->get();
            $WorksheetChangeRequest = DB::table('mnu_ws_plan_change_requests')
                ->leftJoin('selling_customers', 'selling_customers.id', '=', 'mnu_ws_plan_change_requests.customer_id')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_ws_plan_change_requests.item_id')
                ->leftJoin('mnu_requirements_dtl', 'mnu_requirements_dtl.id', '=', 'mnu_ws_plan_change_requests.rq_id')
                ->where('mnu_ws_plan_change_requests.status', 0)
                ->select(
                    'selling_customers.CusName',
                    'mnu_requirements_dtl.refNo',
                    'inventory_items.item_name',
                    'mnu_ws_plan_change_requests.old_qty',
                    'mnu_ws_plan_change_requests.new_qty',
                    'mnu_ws_plan_change_requests.id',
                )
                ->get();


            return $this->responseBody(true, "loadChangeRequest", "Found", $WorksheetChangeRequest);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadChangeRequest", "Something went wrong", $exception->getMessage());
        }
    }
    public function viewChangeRequests($wsReqId)
    {
        try {
            // $WorksheetChangeRequest=WorksheetChangeRequest::where('status',0)->select('')->get();
            $WorksheetChangeRequest = DB::table('mnu_ws_plan_change_requests')
                ->leftJoin('selling_customers', 'selling_customers.id', '=', 'mnu_ws_plan_change_requests.customer_id')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_ws_plan_change_requests.item_id')
                ->leftJoin('mnu_requirements_dtl', 'mnu_requirements_dtl.id', '=', 'mnu_ws_plan_change_requests.rq_id')
                ->leftJoin('crm_addresses', 'crm_addresses.id', '=', 'mnu_ws_plan_change_requests.notify_party')
                ->where('mnu_ws_plan_change_requests.id', (int)$wsReqId)
                ->select(
                    'mnu_ws_plan_change_requests.id as WsChangeReqId',
                    'mnu_requirements_dtl.id',
                    'mnu_requirements_dtl.rqDate',
                    'inventory_items.item_name',
                    'mnu_requirements_dtl.refNo',
                    'selling_customers.CusName',
                    'crm_addresses.AddressTitle',
                    'mnu_ws_plan_change_requests.new_qty',
                    'mnu_ws_plan_change_requests.item_id',
                    'inventory_items.Item_Code',
                    'mnu_ws_plan_change_requests.customer_id',
                    'mnu_ws_plan_change_requests.notify_party',
                )
                ->first();
            // $planQry =  DB::table('mnu_ws_plan_dtl')
            //     ->leftJoin('mnu_ws_plan_change_requests', 'mnu_ws_plan_change_requests.rq_id', '=', 'mnu_ws_plan_dtl.rqDtlID')
            //     ->where('mnu_ws_plan_change_requests.id', (int)$wsReqId)

            //     ->select(
            //         DB::raw("SUM( plannedQty ) AS plannedQty"),
            //     )->first()->plannedQty;
            $ProcessId = DB::table('mnu_ws_plan_change_requests')
                ->leftJoin('mnu_requirements_dtl', 'mnu_requirements_dtl.id', '=', 'mnu_ws_plan_change_requests.rq_id')
                ->where('mnu_ws_plan_change_requests.id', $wsReqId)
                ->select('mnu_requirements_dtl.process')
                ->first()->process;
            // ->toSql();
            return $this->responseBody(
                true,
                "viewChangeRequests",
                "Found",
                [
                    'WorksheetChangeRequest' => $WorksheetChangeRequest,
                    // 'planQry' => $planQry,
                    'ProcessId' => $ProcessId
                ]
            );
        } catch (Exception $exception) {
            return $this->responseBody(false, "viewChangeRequests", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadWorkSheetSToTheChangeRequest($wsReqId)
    {
        try {
            $WorkSheets = DB::table('mnu_ws_plan_dtl')
                ->leftJoin('mnu_ws_plan_change_requests', 'mnu_ws_plan_change_requests.rq_id', '=', 'mnu_ws_plan_dtl.rqDtlID')
                ->leftJoin('settings_workstations', 'settings_workstations.id', '=', 'mnu_ws_plan_dtl.work_station')
                ->where('mnu_ws_plan_change_requests.id', $wsReqId)
                ->select(
                    'settings_workstations.WorkstationName',
                    'mnu_ws_plan_dtl.planStatus',
                    'mnu_ws_plan_dtl.plannedQty',
                    'mnu_ws_plan_dtl.completedQty',
                    'mnu_ws_plan_dtl.remainingQty',
                    'mnu_ws_plan_dtl.id',
                    'mnu_ws_plan_dtl.process as process_id',
                    'mnu_ws_plan_dtl.work_station as Workstation_id',
                    'mnu_ws_plan_dtl.expDate',
                    'mnu_ws_plan_dtl.mnfDate',
                )
                ->get();

            return $this->responseBody(true, "loadWorkSheetSToTheChangeRequest", "Found", $WorkSheets);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadWorkSheetSToTheChangeRequest", "Something went wrong", $exception->getMessage());
        }
    }
    public function updateWsChangeReq(Request $request)
    {

        try {
            $planSubId1 = $this->nameSeris('Planning Number');
            $planSubId2 = 0;
            $itemWeight = (int)Item::where('id', $request->hidden_Item)->select('avg_weight_per_unit')->first()->avg_weight_per_unit;

            //save worksheet details
            foreach ($request->workSheets as $workSheet) {
                $workSheet = json_decode($workSheet);
                if ($workSheet->isOriginal) {

                    $WorkSheetDetail = WorkSheetDetail::find($workSheet->id);
                } else {
                    $planId = $planSubId1 . $planSubId2;
                    $WorkSheetDetail = new WorkSheetDetail();
                    $WorkSheetDetail->plID = $planId;
                    $WorkSheetDetail->rqDtlID = $request->hidden_RequirementId;
                    $WorkSheetDetail->plDate = Carbon::today();
                    $WorkSheetDetail->planStatus = 0;
                    $WorkSheetDetail->prodStatus = 0;
                    $WorkSheetDetail->item = $request->hidden_Item;
                    $WorkSheetDetail->itemCode = $request->hidden_ItemCode;
                    $WorkSheetDetail->itemName = $request->hidden_ItemName;
                    $WorkSheetDetail->refType = 'CO';
                    $WorkSheetDetail->refNo = $request->hidden_RefNo;
                    $WorkSheetDetail->customer = $request->hidden_Customer;
                    $WorkSheetDetail->notify = $request->hidden_Notify;
                    $planSubId2++;
                }
                $WorkSheetDetail->plannedQty = $workSheet->PlanQty;
                $WorkSheetDetail->plannedWeight = (int)$workSheet->PlanQty * $itemWeight;
                $WorkSheetDetail->completedQty = $workSheet->CompleatedQty;
                $WorkSheetDetail->completedWeight = (int)$workSheet->CompleatedQty * $itemWeight;
                $WorkSheetDetail->remainingQty = $workSheet->Balance;
                $WorkSheetDetail->remainingWeight = (int)$workSheet->PlanQty * $itemWeight;
                $WorkSheetDetail->mnfDate =  $workSheet->mnfDate;
                $WorkSheetDetail->expDate = $workSheet->expDate;
                $WorkSheetDetail->process = $workSheet->process;
                $WorkSheetDetail->work_station = $workSheet->Workstation;

                $save = $WorkSheetDetail->save();
            }

            if ($save) {

                //update Requirement Details
                RequirementDetail::where('id', $request->hidden_RequirementId)
                    ->update([
                        'rqQty' => $request->newPlanQty,
                        'rqWeight' => (int)$itemWeight * (int)$request->newPlanQty,
                        'plannedQty' => $request->PlanedQty,
                        'plannedWeight' => (int)$itemWeight * (int)$request->PlanedQty,
                        'remainingQty' => $request->RemainingQty,
                        'remainingWeight' => (int)$itemWeight * (int)$request->RemainingQty,
                    ]);

                //update Worksheet change request
                WorksheetChangeRequest::where('id', $request->WsChangeReqId)
                    ->update([
                        'status' => 1
                    ]);

                return $this->responseBody(true, "updateWsChangeReq", "productionPlan saved", '');
            }
            // return $this->responseBody(true, "updateWsChangeReq", "productionPlan saved", '');
        } catch (Exception $exception) {
            return $this->responseBody(false, "updateWsChangeReq", "Something went wrong", $exception->getMessage());
        }
    }
}
