<?php

namespace Modules\Selling\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Mnu\Entities\WorksheetChangeRequest;
use Modules\Selling\Entities\CustomerOrderChangeRequest;
use Modules\Selling\Entities\CustomerOrderDetail;

class SellingdashboardController extends Controller
{
    use commonFeatures;
    public function loadChangeRequests()
    {
        try {
            // $changeRequests = CustomerOrderChangeRequest::where('status', 0)->get();
            $changeRequests = DB::table('selling_customer_order_change_requests')
                ->leftJoin('selling_customers', 'selling_customers.id', '=', 'selling_customer_order_change_requests.customer_id')
                ->leftJoin('crm_addresses', 'crm_addresses.id', '=', 'selling_customer_order_change_requests.notify_party')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'selling_customer_order_change_requests.item_id')
                ->leftJoin('selling_customer_order', 'selling_customer_order.id', '=', 'selling_customer_order_change_requests.order_id')
                ->where('selling_customer_order_change_requests.status', 0)
                ->select(
                    'selling_customer_order_change_requests.id',
                    'selling_customer_order_change_requests.created_at',
                    'selling_customer_order.order_number',
                    'selling_customers.CusName',
                    'crm_addresses.AddressTitle',
                    'inventory_items.item_name',
                    'selling_customer_order_change_requests.old_qty',
                    'selling_customer_order_change_requests.new_qty',
                    'selling_customer_order_change_requests.old_price',
                    'selling_customer_order_change_requests.new_price',
                )
                ->get();


            return $this->responseBody(true, "loadChangeRequests", '', $changeRequests);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadChangeRequests", '', $ex->getMessage());
        }
    }
    public function loadApproveModel($reqId)
    {
        try {
            $changeRequest = DB::table('selling_customer_order_change_requests')
                ->leftJoin('selling_customers', 'selling_customers.id', '=', 'selling_customer_order_change_requests.customer_id')
                ->leftJoin('crm_addresses', 'crm_addresses.id', '=', 'selling_customer_order_change_requests.notify_party')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'selling_customer_order_change_requests.item_id')
                ->leftJoin('selling_customer_order', 'selling_customer_order.id', '=', 'selling_customer_order_change_requests.order_id')
                ->where('selling_customer_order_change_requests.id', $reqId)
                ->select(
                    'selling_customer_order_change_requests.id',
                    'selling_customer_order_change_requests.created_at',
                    'selling_customer_order.order_number',
                    'selling_customers.CusName',
                    'crm_addresses.AddressTitle',
                    'crm_addresses.id as notifyId',
                    'inventory_items.item_name',
                    'inventory_items.id as ItemId',
                    'selling_customer_order_change_requests.old_qty',
                    'selling_customer_order_change_requests.new_qty',
                    'selling_customer_order_change_requests.old_price',
                    'selling_customer_order_change_requests.new_price',
                )
                ->first();


            return $this->responseBody(true, "loadApproveModel", '', $changeRequest);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadApproveModel", '', $ex->getMessage());
        }
    }
    public function changeRequestAction(Request $request)
    {
        try {

            $changeRequest = CustomerOrderChangeRequest::find($request->id);
            $changeRequest->approver_comment = $request->comment;
            if ($request->has('accept')) {
                $changeRequest->status = 1;
            } else {
                $changeRequest->status = 2;
            }
            $save = $changeRequest->save();

            if ($save && $request->has('accept')) {
                $CustomerOrderChangeRequest = DB::table('selling_customer_order_change_requests')
                    ->leftJoin('selling_customer_order', 'selling_customer_order.id', '=', 'selling_customer_order_change_requests.order_id')
                    ->leftJoin(
                        'mnu_requirements_dtl',
                        function ($join) {
                            $join->on('selling_customer_order.order_number', '=', 'mnu_requirements_dtl.refNo');
                            $join->on('selling_customer_order_change_requests.notify_party', '=', 'mnu_requirements_dtl.notify');
                            $join->on('selling_customer_order_change_requests.item_id', '=', 'mnu_requirements_dtl.item');
                        }
                    )
                    ->where('selling_customer_order_change_requests.id', '=', $request->id)
                    ->select(
                        [
                            'selling_customer_order.id as CustomerOrderId',
                            'selling_customer_order.company',
                            'selling_customer_order_change_requests.id',
                            'mnu_requirements_dtl.id as rq_id',
                            'selling_customer_order_change_requests.customer_id',
                            'selling_customer_order_change_requests.notify_party',
                            'selling_customer_order_change_requests.item_id',
                            'selling_customer_order_change_requests.old_qty',
                            'selling_customer_order_change_requests.new_qty',
                            'selling_customer_order_change_requests.approver_comment',
                        ]
                    )
                    ->first();

                $WorksheetChangeRequest = new WorksheetChangeRequest();
                $WorksheetChangeRequest->company_id = $CustomerOrderChangeRequest->company;
                $WorksheetChangeRequest->order_change_rq_id = $CustomerOrderChangeRequest->id;
                $WorksheetChangeRequest->rq_id = $CustomerOrderChangeRequest->rq_id;
                $WorksheetChangeRequest->customer_id = $CustomerOrderChangeRequest->customer_id;
                $WorksheetChangeRequest->notify_party = $CustomerOrderChangeRequest->notify_party;
                $WorksheetChangeRequest->item_id = $CustomerOrderChangeRequest->item_id;
                $WorksheetChangeRequest->old_qty = $CustomerOrderChangeRequest->old_qty;
                $WorksheetChangeRequest->new_qty = $CustomerOrderChangeRequest->new_qty;
                $WorksheetChangeRequest->status = 0;
                $WorksheetChangeRequest->order_change_approver_comment = $CustomerOrderChangeRequest->approver_comment;
                $WorksheetChangeRequest->save();

                //update Customer Order details
                $CustomerOrderDetail = CustomerOrderDetail::where('order_number', $CustomerOrderChangeRequest->CustomerOrderId)
                    ->where('notify_party', $CustomerOrderChangeRequest->notify_party)
                    ->where('item_code', $CustomerOrderChangeRequest->item_id)
                    ->select('avg_gross_weight', 'avg_net_weight', 'unit_price')
                    ->first();
                $avgGrossWeight = $CustomerOrderDetail->avg_gross_weight;
                $avg_net_weight = $CustomerOrderDetail->avg_net_weight;
                $unit_price = $CustomerOrderDetail->unit_price;


                CustomerOrderDetail::where('order_number', $CustomerOrderChangeRequest->CustomerOrderId)
                    ->where('notify_party', $CustomerOrderChangeRequest->notify_party)
                    ->where('item_code', $CustomerOrderChangeRequest->item_id)
                    ->update([
                        'qty' => (int)$CustomerOrderChangeRequest->new_qty,
                        'total_avg_net_weight' => (int)$avg_net_weight * (int)$CustomerOrderChangeRequest->new_qty,
                        'total_avg_gross_weight' => (int)$avgGrossWeight * (int)$CustomerOrderChangeRequest->new_qty,
                        'total_price' =>  (int)$unit_price * (int)$CustomerOrderChangeRequest->new_qty,
                    ]);
            }
            if ($save) {
                if ($request->has('accept')) {
                    return $this->responseBody(true, "changeRequestAction", 'Change Accepted', $changeRequest);
                } else {
                    return $this->responseBody(false, "changeRequestAction", 'Change Rejected', $changeRequest);
                }
            }


            return $this->responseBody(true, "changeRequestAction", '', $changeRequest);
        } catch (Exception $ex) {
            return $this->responseBody(false, "changeRequestAction", '', $ex->getMessage());
        }
    }
    public function loadChangeRequestRequirements($orderNum, $itemId, $notify)
    {
        try {
            // $Requirement=RequirementDetail::where('item',(int)$itemId)->where('notify',(int)$notify)->where('refNo',$orderNum)->first();
            // $Requirement = RequirementDetail::where('item', (int)$itemId)
            //     ->where('notify', (int)$notify)
            //     ->where('refNo', $orderNum)
            //     ->first();
            $Requirement = DB::table('mnu_requirements_dtl')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_requirements_dtl.item')
                ->where('mnu_requirements_dtl.notify', (int)$notify)
                ->where('mnu_requirements_dtl.refNo', $orderNum)
                ->where('mnu_requirements_dtl.item', (int)$itemId)
                ->select([
                    'inventory_items.item_name',
                    'mnu_requirements_dtl.plannedQty',
                    'mnu_requirements_dtl.completedQty',
                    'mnu_requirements_dtl.completedWeight',
                ])
                ->first();



            return $this->responseBody(true, "loadChangeRequestRequirements", '', $Requirement);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadChangeRequestRequirements", '', $ex->getMessage());
        }
    }
}
