<?php

// namespace Modules\Selling\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use App\Http\common\nameingSeries;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\CRM\Entities\Address;
use Modules\Inventory\Entities\Item;
use Modules\Mnu\Entities\RequirementDetail;
use Modules\Selling\Entities\Customer;
use Modules\Selling\Entities\CustomerOrder;
use Modules\Selling\Entities\CustomerOrderDetail;
use Modules\Selling\Entities\CustomerOrderInnerSummary;
use Modules\Selling\Entities\CustomerOrderOuterSummary;

class CustomerOrderController extends Controller
{
    use commonFeatures, nameingSeries;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'order_number' => ['required'],
            // 'company' => ['required'],
            'order_date' => ['required'],
            'customer' => ['required'],

            'target_date' => ['required'],
            'customer_po_no' => ['required'],
        ]);
        if (CustomerOrder::where('order_number', $request->order_number)->exists()) {
            $this->validationError('order_number', 'order number Exists');
        }
        try {
            $CustomerOrder = new CustomerOrder();
            $CustomerOrder->order_number = $request->order_number;
            $CustomerOrder->company = $request->company;
            $CustomerOrder->order_status = 0;
            $CustomerOrder->order_date = $request->order_date;
            $CustomerOrder->customer = $request->customer;
            $CustomerOrder->customer_billing_address = $request->customer_billing_address;
            $CustomerOrder->customer_shipping_address = $request->customer_shipping_address;
            $CustomerOrder->target_date = $request->target_date;
            $CustomerOrder->customer_po_no = $request->customer_po_no;
            $CustomerOrder->customer_ref_no = $request->customer_ref_no;
            $CustomerOrder->total_avg_net_weight = $request->total_avg_net_weight;
            $CustomerOrder->total_avg_gross_weight = $request->total_avg_gross_weight;
            $CustomerOrder->total_price = $request->total_price;
            // $CustomerOrder->order_comments = $request->order_comments;
            $CustomerOrder->enabled = $request->has('enabled');
            $CustomerOrder->created_by = Auth::user()->id;
            $save = $CustomerOrder->save();

            //saving orderDetails
            for ($t = 0; $t <= $request->notifyCount; $t++) {
                for ($i = 0; $i <= $request->get("notifyItemCount_$t"); $i++) {
                    if ($request->has("notifyID_" . $t)) {
                        $CustomerOrderDetail = new CustomerOrderDetail();
                        $CustomerOrderDetail->order_number = $CustomerOrder->id;
                        $CustomerOrderDetail->notify_party = $request->get("notifyID_" . $t);
                        $CustomerOrderDetail->item_code = $request->get("itemId_" . $t . "_" . $i);
                        $CustomerOrderDetail->item_name = $request->get("itemName_" . $t . "_" . $i);
                        $CustomerOrderDetail->avg_net_weight = $request->get("itemWeight_" . $t . "_" . $i);
                        $CustomerOrderDetail->avg_gross_weight = $request->get("itemGrossWeight_" . $t . "_" . $i);
                        $CustomerOrderDetail->unit_price = $request->get("itemPrice_" . $t . "_" . $i);
                        $CustomerOrderDetail->qty = $request->get("itemQty_" . $t . "_" . $i);
                        $CustomerOrderDetail->total_avg_net_weight = $request->get("itemTotWeight_" . $t . "_" . $i);
                        $CustomerOrderDetail->total_avg_gross_weight = $request->get("itemTotGrossWeight_" . $t . "_" . $i);
                        $CustomerOrderDetail->total_price = $request->get("itemTotPrice_" . $t . "_" . $i);
                        $CustomerOrderDetail->created_by = Auth::user()->id;
                        $CustomerOrderDetail->save();
                    }
                }
            }

            //saving Outter Summary
            for ($i = 0; $i <= $request->OuterSumCount; $i++) {
                if ($request->has("OuterSumProdId_" . $i)) {
                    $CustomerOrderOuterSummary = new CustomerOrderOuterSummary();
                    $CustomerOrderOuterSummary->order_number = $CustomerOrder->id;
                    $CustomerOrderOuterSummary->item = $request->get("OuterSumProdId_" . $i);
                    $CustomerOrderOuterSummary->item_name = $request->get("OuterSumProdName_" . $i);
                    $CustomerOrderOuterSummary->total_qty = $request->get("OuterSumQty_" . $i);
                    $CustomerOrderOuterSummary->total_avg_net_weight = $request->get("OuterSumWeight_" . $i);
                    // $CustomerOrderOuterSummary->total_avg_gross_weight = $request->get("notifyID_" . $t);
                    $CustomerOrderOuterSummary->total_price = $request->get("OuterSumPrice_" . $i);
                    $CustomerOrderOuterSummary->save();
                }
            }
            //saving inner Summary
            for ($i = 0; $i <= $request->innerSumCount; $i++) {
                if ($request->has("innerSumProdId_" . $i)) {
                    $CustomerOrderInnerSummary = new CustomerOrderInnerSummary();
                    $CustomerOrderInnerSummary->order_number = $CustomerOrder->id;
                    $CustomerOrderInnerSummary->item = $request->get("innerSumProdId_" . $i);
                    $CustomerOrderInnerSummary->item_name = $request->get("innerSumProdName_" . $i);
                    $CustomerOrderInnerSummary->total_qty = $request->get("innerSumQty_" . $i);
                    $CustomerOrderInnerSummary->total_avg_net_weight = $request->get("innerSumWeight_" . $i);
                    // $CustomerOrderInnerSummary->total_avg_gross_weight = $request->get("notifyID_" . $t);
                    $CustomerOrderInnerSummary->save();
                }
            }

            if ($save) {
                return $this->responseBody(true, "save", "CustomerOrder saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'order_number' => ['required'],
            // 'company' => ['required'],
            'order_date' => ['required'],
            'customer' => ['required'],

            'target_date' => ['required'],
            'customer_po_no' => ['required'],
        ]);
        try {
            $CustomerOrder = CustomerOrder::find($request->id);
            $CustomerOrder->order_number = $request->order_number;
            $CustomerOrder->company = $request->company;
            // $CustomerOrder->order_status = $request->order_status;
            $CustomerOrder->order_date = $request->order_date;
            $CustomerOrder->customer = $request->customer;
            $CustomerOrder->customer_billing_address = $request->customer_billing_address;
            $CustomerOrder->customer_shipping_address = $request->customer_shipping_address;
            $CustomerOrder->target_date = $request->target_date;
            $CustomerOrder->customer_po_no = $request->customer_po_no;
            $CustomerOrder->customer_ref_no = $request->customer_ref_no;
            $CustomerOrder->total_avg_net_weight = $request->total_avg_net_weight;
            $CustomerOrder->total_avg_gross_weight = $request->total_avg_gross_weight;
            $CustomerOrder->total_price = $request->total_price;
            // $CustomerOrder->order_comments = $request->order_comments;
            $CustomerOrder->enabled = $request->has('enabled');
            $CustomerOrder->modified_by = Auth::user()->id;
            $save = $CustomerOrder->save();

            //saving orderDetails
            CustomerOrderDetail::where('order_number', $request->id)->delete();

            for ($t = 0; $t <= $request->notifyCount; $t++) {
                for ($i = 0; $i <= $request->get("notifyItemCount_$t"); $i++) {
                    if ($request->has("notifyID_" . $t)) {
                        $CustomerOrderDetail = new CustomerOrderDetail();
                        $CustomerOrderDetail->order_number = $CustomerOrder->id;
                        $CustomerOrderDetail->notify_party = $request->get("notifyID_" . $t);
                        $CustomerOrderDetail->item_code = $request->get("itemId_" . $t . "_" . $i);
                        $CustomerOrderDetail->item_name = $request->get("itemName_" . $t . "_" . $i);
                        $CustomerOrderDetail->avg_net_weight = $request->get("itemWeight_" . $t . "_" . $i);
                        $CustomerOrderDetail->avg_gross_weight = $request->get("itemGrossWeight_" . $t . "_" . $i);
                        $CustomerOrderDetail->unit_price = $request->get("itemPrice_" . $t . "_" . $i);
                        $CustomerOrderDetail->qty = $request->get("itemQty_" . $t . "_" . $i);
                        $CustomerOrderDetail->total_avg_net_weight = $request->get("itemTotWeight_" . $t . "_" . $i);
                        $CustomerOrderDetail->total_avg_gross_weight = $request->get("itemTotGrossWeight_" . $t . "_" . $i);
                        $CustomerOrderDetail->total_price = $request->get("itemTotPrice_" . $t . "_" . $i);
                        $CustomerOrderDetail->created_by = Auth::user()->id;
                        $CustomerOrderDetail->save();
                    }
                }
            }

            //saving Outter Summary
            CustomerOrderOuterSummary::where('order_number', $request->id)->delete();
            for ($i = 0; $i <= $request->OuterSumCount; $i++) {
                if ($request->has("OuterSumProdId_" . $i)) {
                    $CustomerOrderOuterSummary = new CustomerOrderOuterSummary();
                    $CustomerOrderOuterSummary->order_number = $CustomerOrder->id;
                    $CustomerOrderOuterSummary->item = $request->get("OuterSumProdId_" . $i);
                    $CustomerOrderOuterSummary->item_name = $request->get("OuterSumProdName_" . $i);
                    $CustomerOrderOuterSummary->total_qty = $request->get("OuterSumQty_" . $i);
                    $CustomerOrderOuterSummary->total_avg_net_weight = $request->get("OuterSumWeight_" . $i);
                    // $CustomerOrderOuterSummary->total_avg_gross_weight = $request->get("notifyID_" . $t);
                    $CustomerOrderOuterSummary->total_price = $request->get("OuterSumPrice_" . $i);
                    $CustomerOrderOuterSummary->save();
                }
            }
            //saving inner Summary
            CustomerOrderInnerSummary::where('order_number', $request->id)->delete();
            for ($i = 0; $i <= $request->innerSumCount; $i++) {
                if ($request->has("innerSumProdId_" . $i)) {
                    $CustomerOrderInnerSummary = new CustomerOrderInnerSummary();
                    $CustomerOrderInnerSummary->order_number = $CustomerOrder->id;
                    $CustomerOrderInnerSummary->item = $request->get("innerSumProdId_" . $i);
                    $CustomerOrderInnerSummary->item_name = $request->get("innerSumProdName_" . $i);
                    $CustomerOrderInnerSummary->total_qty = $request->get("innerSumQty_" . $i);
                    $CustomerOrderInnerSummary->total_avg_net_weight = $request->get("innerSumWeight_" . $i);
                    // $CustomerOrderInnerSummary->total_avg_gross_weight = $request->get("notifyID_" . $t);
                    $CustomerOrderInnerSummary->save();
                }
            }
            if ($save) {
                return $this->responseBody(true, "save", "CustomerOrder saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadCustomerOrders()
    {
        try {
            $CustomerOrder = CustomerOrder::orderBy('id', 'ASC')
                ->get();
            $CustomerOrder = DB::table('selling_customer_order')
                ->leftJoin('selling_customers', 'selling_customers.id', '=', 'selling_customer_order.customer')
                ->select('selling_customer_order.*', 'selling_customers.CusName')
                ->get();

            return $this->responseBody(true, "loadCustomerOrders", "found", $CustomerOrder);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomerOrders", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $CustomerOrder = CustomerOrder::where('id', $id)->delete();
            return $this->responseBody(true, "User", "CustomerOrder Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadCustomerOrder($id)
    {
        try {
            $CustomerOrder = CustomerOrder::where('id', $id)->first();
            $CustomerOrderDetail = CustomerOrderDetail::where('order_number', $id)->get();
            $CustomerOrderOuterSummary = CustomerOrderOuterSummary::where('order_number', $id)->get();
            $CustomerOrderInnerSummary = CustomerOrderInnerSummary::where('order_number', $id)->get();
            $notify = CustomerOrderDetail::where('order_number', $id)->distinct()->get('notify_party');



            return $this->responseBody(
                true,
                "loadCustomerOrder",
                "found",
                [
                    'CustomerOrder' => $CustomerOrder,
                    'CustomerOrderDetail' => $CustomerOrderDetail,
                    'CustomerOrderOuterSummary' => $CustomerOrderOuterSummary,
                    'CustomerOrderInnerSummary' => $CustomerOrderInnerSummary,
                    'notify' => $notify
                ]
            );
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCustomerOrder", "error", $exception->getMessage());
        }
    }
    public function loadNotifyParties()
    {
        try {
            $Address = Address::where('is_notify', true)->orderBy('id', 'ASC')
                ->get();
            return $this->responseBody(true, "loadNotifyParties", '', $Address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadNotifyParties", '', $ex->getMessage());
        }
    }
    public function loadNotify($id)
    {
        try {
            $Address = Address::where('id', $id)->select('id', 'AddressTitle')->first();

            return $this->responseBody(true, "loadNotify", '', $Address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadNotify", '', $ex->getMessage());
        }
    }
    public function loadCustomers()
    {
        try {
            $Customer = Customer::where('enabled', true)->get();
            return $this->responseBody(true, "loadCustomers", "found", $Customer);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCustomers", "error", $exception->getMessage());
        }
    }
    public function loadItems($cusID)
    {
        try {
            // $Item = Item::where('is_bom_outer_item', true)->where('enabled', true)->select('id', 'item_name')->orderBy('id', 'ASC')
            //     ->get();
            $Item = DB::table('inventory_items')
                ->leftJoin('mnu_customer_items', 'inventory_items.id', '=', 'mnu_customer_items.item')
                ->where('mnu_customer_items.customer', $cusID)
                ->where('mnu_customer_items.is_sale_item', true)
                ->select('inventory_items.*')
                ->get();
            return $this->responseBody(true, "loadItems", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItems", '', $ex->getMessage());
        }
    }
    public function getItem($itemID)
    {
        try {
            $Item = Item::where('id', $itemID)->first();

            return $this->responseBody(true, "getItem", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "getItem", '', $ex->getMessage());
        }
    }
    public function loadCustomerBillingAddresses($CusId)
    {
        try {
            $Address = DB::table('crm_customeraddress')
                ->leftJoin('crm_addresses', 'crm_addresses.id', '=', 'crm_customeraddress.AddressID')
                ->where('crm_addresses.PreferedBillingAddress', true)
                ->where('crm_customeraddress.CusCode', $CusId)
                ->select('crm_addresses.id', 'crm_addresses.AddressTitle')
                ->get();


            return $this->responseBody(true, "loadCustomerBillingAddresses", '', $Address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomerBillingAddresses", '', $ex->getMessage());
        }
    }
    public function loadAddress($AddressId)
    {
        try {
            $Address = DB::table('crm_addresses')
                ->leftJoin('crm_address_types', 'crm_address_types.id', '=', 'crm_addresses.AddressType')
                ->leftJoin('settings_countries', 'settings_countries.id', '=', 'crm_addresses.Country')
                ->where('crm_addresses.id', $AddressId)
                ->select('crm_addresses.*', 'crm_address_types.AddressType as typeName', 'settings_countries.country_name')
                ->first();

            return $this->responseBody(true, "loadAddress", '', $Address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadAddress", '', $ex->getMessage());
        }
    }
    public function loadCustomerShippingAddresses($CusId)
    {
        try {
            $Address = DB::table('crm_customeraddress')
                ->leftJoin('crm_addresses', 'crm_addresses.id', '=', 'crm_customeraddress.AddressID')
                // ->leftJoin('crm_address_types', 'crm_address_types.id', '=', 'crm_addresses.AddressType')
                // ->where('crm_address_types.AddressType', 'Shipping')
                ->where('crm_addresses.PreferedShippingAddress', true)
                ->where('crm_customeraddress.CusCode', $CusId)
                ->select('crm_addresses.id', 'crm_addresses.AddressTitle')
                ->get();


            return $this->responseBody(true, "loadCustomerShippingAddresses", '', $Address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomerShippingAddresses", '', $ex->getMessage());
        }
    }
    public function getinnerItems($OuterBomId)
    {
        try {
            // $Item = DB::table('mnu_bom_item_details')
            //     ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_bom_item_details.item_id')
            //     ->where('mnu_bom_item_details.is_main_item', true)
            //     ->where('mnu_bom_item_details.item_id', $OuterBomId)
            //     ->select('inventory_items.*')
            //     ->get();
            $Item = DB::table('inventory_items')
                ->leftJoin('mnu_bom_item_details', 'inventory_items.id', '=', 'mnu_bom_item_details.item_id')
                ->where('mnu_bom_item_details.is_main_item', true)
                ->where('mnu_bom_item_details.bom_item_id', $OuterBomId)
                ->select('inventory_items.*')
                ->get();


            return $this->responseBody(true, "getItem", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "getItem", '', $ex->getMessage());
        }
    }
    public function loadCustomersPreviousOrders($cusID)
    {
        try {
            $CustomerOrder = CustomerOrder::where('customer', $cusID)->orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadCustomersPreviousOrders", "found", $CustomerOrder);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomersPreviousOrders", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadPreviousOrderDetails($orderId)
    {
        try {
            $CustomerOrder = CustomerOrder::where('id', $orderId)->first();
            $CustomerOrderDetail = CustomerOrderDetail::where('order_number', $orderId)->get();
            $CustomerOrderOuterSummary = CustomerOrderOuterSummary::where('order_number', $orderId)->get();
            $CustomerOrderInnerSummary = CustomerOrderInnerSummary::where('order_number', $orderId)->get();
            $notify = CustomerOrderDetail::where('order_number', $orderId)->distinct()->get('notify_party');

            return $this->responseBody(
                true,
                "loadPreviousOrderDetails",
                "found",
                [
                    'CustomerOrder' => $CustomerOrder,
                    'CustomerOrderDetail' => $CustomerOrderDetail,
                    'CustomerOrderOuterSummary' => $CustomerOrderOuterSummary,
                    'CustomerOrderInnerSummary' => $CustomerOrderInnerSummary,
                    'notify' => $notify
                ]
            );
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPreviousOrderDetails", "Something went wrong", $ex->getMessage());
        }
    }
    public function getOrderNumber()
    {
        try {
            $ordernumber = $this->nameSeris('Customer Order');

            return $this->responseBody(true, "getOrderNumber", "found", $ordernumber);
        } catch (Exception $ex) {
            return $this->responseBody(false, "getOrderNumber", "Something went wrong", $ex->getMessage());
        }
    }
    public function setOrderStatus($state, $id)
    {
        try {
            $success = true;

            $CustomerOrder = CustomerOrder::find($id);
            $msg = '';

            switch ($state) {
                case 0:
                    $CustomerOrder->order_status = 0;
                    $msg = 'Draft';
                    break;
                case 1:
                    $CustomerOrder->order_status = 1;
                    $msg = 'Submited';
                    break;
                case 2:
                    $result = $this->createRequirement($id);

                    if ($result['success']) {
                        $CustomerOrder->order_status = 2;
                        $msg = 'Approved | ' . $result['message'];
                    } else {
                        $msg = 'Not Approved | ' . $result['message'];
                        $success = false;
                    }
                    break;
                case 3:
                    $CustomerOrder->order_status = 3;
                    $msg = 'Denied';
                    $success = false;
                    break;

                default:
                    $success = true;
                    break;
            }
            $CustomerOrder->modified_by = Auth::user()->id;
            $CustomerOrder->save();

            return $this->responseBody($success, "setOrderStatus", "Order Status Changed to " . $msg, '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "setOrderStatus", "Something went wrong", $ex->getMessage());
        }
    }
    private function createRequirement($orderId)
    {
        try {
            $CustomerOrderDetails = DB::table('selling_customer_order_dtl')
                ->leftJoin('selling_customer_order', 'selling_customer_order.id', '=', 'selling_customer_order_dtl.order_number')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'selling_customer_order_dtl.item_code')
                ->where('selling_customer_order.id', $orderId)
                ->select(
                    'selling_customer_order_dtl.*',
                    'selling_customer_order_dtl.order_number as orderNumber',
                    'inventory_items.id as itemId',
                    'inventory_items.Item_Code as ItemCode',
                    'inventory_items.item_name as itemName',
                    'inventory_items.process',
                    'inventory_items.work_station',
                    'selling_customer_order.customer',
                    'selling_customer_order.target_date',
                    'selling_customer_order.order_number as orderNumber',
                )
                ->get();
            foreach ($CustomerOrderDetails as $CustomerOrderDetail) {
                $RequirementDetail = new RequirementDetail();
                $RequirementDetail->rqID = $this->nameSeris('Requirement ID');
                $RequirementDetail->item = $CustomerOrderDetail->itemId;
                $RequirementDetail->itemName = $CustomerOrderDetail->itemName;
                $RequirementDetail->itemCode = $CustomerOrderDetail->ItemCode;
                $RequirementDetail->rqQty = $CustomerOrderDetail->qty;
                $RequirementDetail->rqWeight = $CustomerOrderDetail->total_avg_net_weight;
                $RequirementDetail->remainingQty = $CustomerOrderDetail->qty;
                $RequirementDetail->remainingWeight = $CustomerOrderDetail->total_avg_net_weight;
                $RequirementDetail->customer = $CustomerOrderDetail->customer;
                $RequirementDetail->notify = $CustomerOrderDetail->notify_party;
                $RequirementDetail->refType = 'CO';
                $RequirementDetail->refNo = $CustomerOrderDetail->orderNumber;
                $RequirementDetail->rqDate = $CustomerOrderDetail->target_date;
                $RequirementDetail->planStatus = 0;
                $RequirementDetail->prodStatus = 0;
                $RequirementDetail->process = $CustomerOrderDetail->process;
                $RequirementDetail->work_station = $CustomerOrderDetail->work_station;
                $RequirementDetail->created_by = Auth::user()->id;
                $save = $RequirementDetail->save();
            }
            return $this->responseBody(true, "createRequirement", "Requirement generated", '');
        } catch (Exception $ex) {
            // return 'Requirement generation error';
            return $this->responseBody(false, "createRequirement", "Requirement generation error", $ex->getMessage());
        }
    }


}
