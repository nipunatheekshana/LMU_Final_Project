<?php

namespace Modules\Selling\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use App\Http\common\nameingSeries;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\Item;
use Modules\Mnu\Entities\RequirementDetail;
use Modules\Selling\Entities\Customer;
use Modules\Selling\Entities\CustomerOrder;
use Modules\Selling\Entities\CustomerOrderChangeRequest;
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
            $CustomerOrder->companyID  =Auth::user()->company_id;
            $CustomerOrder->order_number = $request->order_number;
            // $CustomerOrder->company = $request->company;
            $CustomerOrder->order_status = 0;
            $CustomerOrder->prod_status = 0;
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
            $CustomerOrder->is_internal_order = $request->has('isInternalOrder');
            // $CustomerOrder->order_comments = $request->order_comments;
            // $CustomerOrder->enabled = $request->has('enabled');
            $CustomerOrder->created_by = Auth::user()->id;
            $save = $CustomerOrder->save();


            if ($save) {
                //saving orderDetails
                if (!empty($request->itemArr)) {
                    foreach ($request->itemArr as $item) {
                        $item = json_decode($item);
                        $CustomerOrderDetail = new CustomerOrderDetail();
                        $CustomerOrderDetail->order_number = $CustomerOrder->id;
                        $CustomerOrderDetail->notify_party = $item->notifyID;
                        $CustomerOrderDetail->item_code = $item->ProdId;
                        $CustomerOrderDetail->item_name = $item->productName;
                        $CustomerOrderDetail->avg_net_weight = $item->AvgWeight;
                        $CustomerOrderDetail->avg_gross_weight = $item->avgGrossWeight;
                        $CustomerOrderDetail->unit_price = $item->UnitPrice;
                        $CustomerOrderDetail->qty = $item->Qty;
                        $CustomerOrderDetail->total_avg_net_weight = $item->TotNetWeight;
                        $CustomerOrderDetail->total_avg_gross_weight = $item->totalGrossWeight;
                        $CustomerOrderDetail->total_price = $item->TotalPrice;
                        $CustomerOrderDetail->created_by = Auth::user()->id;
                        $CustomerOrderDetail->save();
                    }
                }
                //saving Outter Summary
                if (!empty($request->outterSummaryArr)) {
                    foreach ($request->outterSummaryArr as $OuterItem) {
                        $OuterItem = json_decode($OuterItem);
                        $CustomerOrderOuterSummary = new CustomerOrderOuterSummary();
                        $CustomerOrderOuterSummary->order_number = $CustomerOrder->id;
                        $CustomerOrderOuterSummary->item = $OuterItem->ProdId;
                        $CustomerOrderOuterSummary->item_name = $OuterItem->productName;
                        $CustomerOrderOuterSummary->total_qty = $OuterItem->TotQty;
                        $CustomerOrderOuterSummary->total_avg_net_weight = $OuterItem->TotNetWeight;
                        // $CustomerOrderOuterSummary->total_avg_gross_weight = '';
                        $CustomerOrderOuterSummary->total_price = $OuterItem->TotalPrice;
                        $CustomerOrderOuterSummary->save();
                    }
                }
                //saving inner Summary
                if (!empty($request->innerSummaryArr)) {
                    foreach ($request->innerSummaryArr as $innerItem) {
                        $innerItem = json_decode($innerItem);
                        $CustomerOrderInnerSummary = new CustomerOrderInnerSummary();
                        $CustomerOrderInnerSummary->order_number = $CustomerOrder->id;
                        $CustomerOrderInnerSummary->item = $innerItem->id;
                        $CustomerOrderInnerSummary->item_name = $innerItem->item_name;
                        $CustomerOrderInnerSummary->total_qty = $innerItem->qty;
                        $CustomerOrderInnerSummary->total_avg_net_weight = $innerItem->total_net_weight;
                        // $CustomerOrderInnerSummary->total_avg_gross_weight = $request->get("notifyID_" . $t);
                        $CustomerOrderInnerSummary->save();
                    }
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
            'order_date' => ['required'],
            // 'customer' => ['required'],
            'target_date' => ['required'],
            'customer_po_no' => ['required'],
        ]);
        try {
            $CustomerOrder = CustomerOrder::find($request->id);
            $CustomerOrder->order_number = $request->order_number;
            $CustomerOrder->company = $request->company;
            $CustomerOrder->order_date = $request->order_date;
            // $CustomerOrder->customer = $request->customer;
            $CustomerOrder->customer_billing_address = $request->customer_billing_address;
            $CustomerOrder->customer_shipping_address = $request->customer_shipping_address;
            $CustomerOrder->target_date = $request->target_date;
            $CustomerOrder->customer_po_no = $request->customer_po_no;
            $CustomerOrder->customer_ref_no = $request->customer_ref_no;
            $CustomerOrder->total_avg_net_weight = $request->total_avg_net_weight;
            $CustomerOrder->total_avg_gross_weight = $request->total_avg_gross_weight;
            $CustomerOrder->total_price = $request->total_price;
            $CustomerOrder->is_internal_order = $request->has('isInternalOrder');
            // $CustomerOrder->order_comments = $request->order_comments;
            // $CustomerOrder->enabled = $request->has('enabled');
            $CustomerOrder->modified_by = Auth::user()->id;
            $save = $CustomerOrder->save();

            if ($save) {
                //saving orderDetails
                CustomerOrderDetail::where('order_number', $request->id)->delete();
                if (!empty($request->itemArr)) {
                    foreach ($request->itemArr as $item) {
                        $item = json_decode($item);
                        $CustomerOrderDetail = new CustomerOrderDetail();
                        $CustomerOrderDetail->order_number = $CustomerOrder->id;
                        $CustomerOrderDetail->notify_party = $item->notifyID;
                        $CustomerOrderDetail->item_code = $item->ProdId;
                        $CustomerOrderDetail->item_name = $item->productName;
                        $CustomerOrderDetail->avg_net_weight = $item->AvgWeight;
                        $CustomerOrderDetail->avg_gross_weight = $item->avgGrossWeight;
                        $CustomerOrderDetail->unit_price = $item->UnitPrice;
                        $CustomerOrderDetail->qty = $item->Qty;
                        $CustomerOrderDetail->total_avg_net_weight = $item->TotNetWeight;
                        $CustomerOrderDetail->total_avg_gross_weight = $item->totalGrossWeight;
                        $CustomerOrderDetail->total_price = $item->TotalPrice;
                        $CustomerOrderDetail->created_by = Auth::user()->id;
                        $CustomerOrderDetail->save();
                    }
                }

                //saving Outter Summary
                CustomerOrderOuterSummary::where('order_number', $request->id)->delete();
                if (!empty($request->outterSummaryArr)) {
                    foreach ($request->outterSummaryArr as $OuterItem) {
                        $OuterItem = json_decode($OuterItem);
                        $CustomerOrderOuterSummary = new CustomerOrderOuterSummary();
                        $CustomerOrderOuterSummary->order_number = $CustomerOrder->id;
                        $CustomerOrderOuterSummary->item = $OuterItem->ProdId;
                        $CustomerOrderOuterSummary->item_name = $OuterItem->productName;
                        $CustomerOrderOuterSummary->total_qty = $OuterItem->TotQty;
                        $CustomerOrderOuterSummary->total_avg_net_weight = $OuterItem->TotNetWeight;
                        // $CustomerOrderOuterSummary->total_avg_gross_weight = '';
                        $CustomerOrderOuterSummary->total_price = $OuterItem->TotalPrice;
                        $CustomerOrderOuterSummary->save();
                    }
                }
                //saving inner Summary
                CustomerOrderInnerSummary::where('order_number', $request->id)->delete();
                if (!empty($request->innerSummaryArr)) {
                    foreach ($request->innerSummaryArr as $innerItem) {
                        $innerItem = json_decode($innerItem);
                        $CustomerOrderInnerSummary = new CustomerOrderInnerSummary();
                        $CustomerOrderInnerSummary->order_number = $CustomerOrder->id;
                        $CustomerOrderInnerSummary->item = $innerItem->id;
                        $CustomerOrderInnerSummary->item_name = $innerItem->item_name;
                        $CustomerOrderInnerSummary->total_qty = $innerItem->qty;
                        $CustomerOrderInnerSummary->total_avg_net_weight = $innerItem->total_net_weight;
                        // $CustomerOrderInnerSummary->total_avg_gross_weight = $request->get("notifyID_" . $t);
                        $CustomerOrderInnerSummary->save();
                    }
                }
            }

            if ($save) {
                return $this->responseBody(true, "save", "CustomerOrder Updated", 'data Updated');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadCustomerOrders()
    {
        try {

            $CustomerOrder = DB::table('selling_customer_order')
                ->leftJoin('selling_customers', 'selling_customers.id', '=', 'selling_customer_order.customer')
                ->select('selling_customer_order.id', 'selling_customer_order.order_number', 'selling_customer_order.order_status', 'selling_customers.CusName')
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
            $CustomerOrder = CustomerOrder::where('id', $id)
                ->select(
                    'is_internal_order',
                    'id',
                    'order_number',
                    'order_date',
                    'target_date',
                    'customer_po_no',
                    'customer_ref_no',
                    'customer',
                    'total_avg_gross_weight',
                    'total_avg_net_weight',
                    'total_price',
                    'customer_shipping_address',
                    'customer_billing_address',
                    'order_status',
                    'prod_status',
                )
                ->first();
            $CustomerOrderOuterSummary = CustomerOrderOuterSummary::where('order_number', $id)
                ->select('item', 'item_name', 'total_qty', 'total_avg_net_weight', 'total_price')
                ->get();
            $CustomerOrderInnerSummary = CustomerOrderInnerSummary::where('order_number', $id)
                ->select('item', 'item_name', 'total_qty', 'total_avg_net_weight')
                ->get();
            // $CustomerOrderDetail = CustomerOrderDetail::where('order_number', $id)->get();
            $CustomerOrderDetail = DB::table('selling_customer_order_dtl')
                ->leftJoin('crm_addresses', 'crm_addresses.id', '=', 'selling_customer_order_dtl.notify_party')
                ->select(
                    'selling_customer_order_dtl.item_code',
                    'selling_customer_order_dtl.item_name',
                    'selling_customer_order_dtl.avg_net_weight',
                    'selling_customer_order_dtl.qty',
                    'selling_customer_order_dtl.total_avg_net_weight',
                    'selling_customer_order_dtl.unit_price',
                    'selling_customer_order_dtl.total_price',
                    'selling_customer_order_dtl.notify_party',
                    'selling_customer_order_dtl.avg_gross_weight',
                    'selling_customer_order_dtl.total_avg_gross_weight',
                    'crm_addresses.AddressTitle'
                )
                ->where('selling_customer_order_dtl.order_number', $id)->get();


            return $this->responseBody(
                true,
                "loadCustomerOrder",
                "found",
                [
                    'CustomerOrder' => $CustomerOrder,
                    'CustomerOrderDetail' => $CustomerOrderDetail,
                    'CustomerOrderOuterSummary' => $CustomerOrderOuterSummary,
                    'CustomerOrderInnerSummary' => $CustomerOrderInnerSummary,
                ]
            );
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCustomerOrder", "error", $exception->getMessage());
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
    public function loadNotifyParties($cusID)
    {
        try {
            // $Address = Address::where('is_notify', true)->select('id', 'AddressTitle')->orderBy('id', 'ASC')
            //     ->get();
            $Address = DB::table('selling_customernotifyparty')
                ->join('crm_addresses', 'crm_addresses.id', '=', 'selling_customernotifyparty.notifypartyID')
                ->select('crm_addresses.id', 'crm_addresses.AddressTitle')
                ->where('crm_addresses.is_notify', true)
                ->where('selling_customernotifyparty.CusCode', $cusID)
                ->orderBy('crm_addresses.id', 'ASC')
                ->get();
            return $this->responseBody(true, "loadNotifyParties", '', $Address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadNotifyParties", '', $ex->getMessage());
        }
    }
    public function loadCustomers()
    {
        try {
            $Customer = Customer::where('enabled', true)->select('id', 'CusName')->get();
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
                ->select('inventory_items.id', 'inventory_items.item_name')
                ->get();
            return $this->responseBody(true, "loadItems", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItems", '', $ex->getMessage());
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
                ->select(
                    'crm_addresses.AddressTitle',
                    'crm_addresses.Addressline1',
                    'crm_addresses.Addressline2',
                    'crm_addresses.CityTown',
                    'crm_address_types.AddressType as typeName',
                    'settings_countries.country_name'
                )
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
    public function getItemDetails($itemId)
    {
        try {
            $selectArray = [
                'Item_Code',
                'avg_weight_per_unit',
                'avg_gross_weight_per_unit',

            ];
            $Item = Item::where('id', $itemId)->select($selectArray)->first();

            return $this->responseBody(true, "getItemDetails", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "getItemDetails", '', $ex->getMessage());
        }
    }
    public function getInnerSummary(Request $request)
    {
        try {
            $innerSummaryArr = [];
            foreach ($request->outerSumArry as $outerItem) {
                $Items = DB::table('inventory_items')
                    ->leftJoin('mnu_bom_item_details', 'inventory_items.id', '=', 'mnu_bom_item_details.item_id')
                    ->where('mnu_bom_item_details.is_main_item', true)
                    ->where('mnu_bom_item_details.bom_item_id', $outerItem['ProdId'])
                    ->select(
                        'inventory_items.id',
                        'inventory_items.item_name',
                        'mnu_bom_item_details.qty',
                        'mnu_bom_item_details.total_net_weight',
                    )
                    ->get();
                foreach ($Items as $Item) {

                    $id = $Item->id;
                    $item_name = $Item->item_name;
                    $qty = (int)$Item->qty * (int)$outerItem['TotQty'];
                    $total_net_weight = $Item->total_net_weight * (int)$outerItem['TotQty'];

                    if (!empty($innerSummaryArr)) {

                        for ($i = 0; $i < count($innerSummaryArr); $i++) {
                            if ((int)$innerSummaryArr[$i]['id'] == (int)$Item->id) {

                                $qty = (int)$qty + (int)$innerSummaryArr[$i]['qty'];
                                $total_net_weight = (int)$total_net_weight + (int)$innerSummaryArr[$i]['total_net_weight'];

                                array_splice($innerSummaryArr, $i, 1); //This removes 1 item from the array starting at indexValueOfArray
                                //because this item is alredy added above line remove the previously added item

                            }
                        }
                    }

                    array_push($innerSummaryArr, [
                        'id' => $id,
                        'item_name' => $item_name,
                        'qty' => $qty,
                        'total_net_weight' => $total_net_weight,
                    ]);
                }
            }

            return $this->responseBody(true, "getInnerSummary", '', $innerSummaryArr);
        } catch (Exception $ex) {
            return $this->responseBody(false, "getInnerSummary", '', $ex->getMessage());
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
                    'selling_customer_order_dtl.notify_party',
                    'selling_customer_order_dtl.total_avg_net_weight',
                    'selling_customer_order_dtl.qty',
                    'selling_customer_order_dtl.order_number as orderNumber',
                    'inventory_items.id as itemId',
                    'inventory_items.Item_Code as ItemCode',
                    'inventory_items.item_name as itemName',
                    'inventory_items.process',
                    'inventory_items.work_station',
                    'selling_customer_order.customer',
                    'selling_customer_order.target_date',
                    'selling_customer_order.is_internal_order',

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
                if ($CustomerOrderDetail->is_internal_order) {
                    $RequirementDetail->refType = 'IO';
                } else {
                    $RequirementDetail->refType = 'CO';
                }
                $RequirementDetail->refNo = $CustomerOrderDetail->orderNumber;
                $RequirementDetail->rqDate = $CustomerOrderDetail->target_date;
                $RequirementDetail->planStatus = 0;
                $RequirementDetail->prodStatus = 0;
                $RequirementDetail->process = $CustomerOrderDetail->process;
                $RequirementDetail->work_station = $CustomerOrderDetail->work_station;
                $RequirementDetail->created_by = Auth::user()->id;
                $save = $RequirementDetail->save();
            }
            if ($save) {
                return $this->responseBody(true, "createRequirement", "Requirement generated", '');
            }
        } catch (Exception $ex) {
            // return 'Requirement generation error';
            return $this->responseBody(false, "createRequirement", "Requirement generation error", $ex->getMessage());
        }
    }
    public function CheckCustomerType($CusId)
    {
        try {
            $is_internal_customer = Customer::where('id', $CusId)->select('is_internal_customer')->first()->is_internal_customer;

            return $this->responseBody(true, "CheckCustomerType", "Internal Order", $is_internal_customer);
        } catch (Exception $ex) {
            // return 'Requirement generation error';
            return $this->responseBody(false, "CheckCustomerType", "error", $ex->getMessage());
        }
    }

    //#################################################################//
    //###############load From Previous Orders########################//
    //###############################################################//

    public function loadCustomersPreviousOrders($cusID)
    {
        try {

            $CustomerOrder = DB::table('selling_customer_order')
                ->leftJoin('selling_customers', 'selling_customers.id', '=', 'selling_customer_order.customer')
                ->where('selling_customer_order.customer', $cusID)
                ->select(
                    'selling_customer_order.id',
                    'selling_customer_order.order_number',
                    'selling_customer_order.order_status',
                    'selling_customers.CusName'
                )
                ->skip(0)->take(10)
                ->get();

            return $this->responseBody(true, "loadCustomersPreviousOrders", "found", $CustomerOrder);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomersPreviousOrders", "Something went wrong", $ex->getMessage());
        }
    }

    public function loadPreviousOrderDetails($orderId)
    {
        try {

            $CustomerOrderDetail = DB::table('selling_customer_order_dtl')
                ->leftJoin('crm_addresses', 'crm_addresses.id', '=', 'selling_customer_order_dtl.notify_party')
                ->select(
                    'selling_customer_order_dtl.item_code',
                    'selling_customer_order_dtl.item_name',
                    'selling_customer_order_dtl.avg_net_weight',
                    'selling_customer_order_dtl.qty',
                    'selling_customer_order_dtl.total_avg_net_weight',
                    'selling_customer_order_dtl.unit_price',
                    'selling_customer_order_dtl.total_price',
                    'selling_customer_order_dtl.notify_party',
                    'selling_customer_order_dtl.avg_gross_weight',
                    'selling_customer_order_dtl.total_avg_gross_weight',
                    'crm_addresses.AddressTitle'
                )
                ->where('selling_customer_order_dtl.order_number', $orderId)->get();

            return $this->responseBody(
                true,
                "loadPreviousOrderDetails",
                "found",
                $CustomerOrderDetail

            );
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPreviousOrderDetails", "Something went wrong", $ex->getMessage());
        }
    }

    //#################################################################//
    //############################Change Request#######################//
    //###############################################################//

    public function CreateChangeRequest(Request $request)
    {
        try {
            $old_qty = 0;
            $old_price = 0;
            $priceChange = false;
            $change_request_type = 2; //add item

            $CustomerOrder = CustomerOrder::where('id', (int)$request->oderId)->first();
            $CustomerOrderDetail = CustomerOrderDetail::where('order_number', (int)$request->oderId)
                ->where('notify_party', $request->notifyID)
                ->where('item_code', $request->ProdId);

            if (!CustomerOrderChangeRequest::where('order_id', $request->oderId)
                ->where('notify_party', $request->notifyID)
                ->where('item_id', $request->ProdId)
                ->where('status', 0)
                ->exists()) {
                if ($CustomerOrderDetail->exists()) {

                    $CustomerOrderDetail = $CustomerOrderDetail->first();
                    $old_qty = (int)$CustomerOrderDetail->qty;
                    $old_price = (int)$CustomerOrderDetail->unit_price;
                    if ($old_price != (int)$request->unitPrice) {
                        $priceChange = true;
                    }
                    if ((int)$request->quantity != $old_qty) {
                        if ((int)$request->quantity == 0) {
                            $change_request_type = 3; //remove item
                        } elseif ((int)$request->quantity > $old_qty) {
                            $change_request_type = 0; //additin to the item
                        } elseif ((int)$request->quantity < $old_qty) {
                            $change_request_type = 1; //minus the item quantity
                        }
                    } else {
                        $change_request_type = 4; //No QuantityChange
                    }
                }

                $changeRequest = new CustomerOrderChangeRequest();
                $changeRequest->order_id = $request->oderId;
                $changeRequest->customer_id = $CustomerOrder->customer;
                $changeRequest->notify_party = $request->notifyID;
                $changeRequest->item_id = $request->ProdId;
                $changeRequest->old_qty = $old_qty;
                $changeRequest->new_qty = $request->quantity;
                $changeRequest->old_price = $old_price;
                $changeRequest->new_price = $request->unitPrice;
                $changeRequest->status = 0;
                $changeRequest->change_request_type = $change_request_type;
                $changeRequest->customer_comment = $request->comment;
                $changeRequest->price_changed = $priceChange;
                // $changeRequest->approver_comment = $request->oderId;
                $changeRequest->created_by = Auth::user()->id;
                $save = $changeRequest->save();

                if ($save) {
                    return $this->responseBody(true, "CreateChangeRequest", "Change Request Saved", ['order_id' => $changeRequest->order_id, 'notify_party' => $changeRequest->notify_party, 'item_id' => $changeRequest->item_id]);
                }
            } else {
                return $this->responseBody(false, "CreateChangeRequest", "pending Requests Excists", '');
            }
        } catch (Exception $ex) {
            return $this->responseBody(false, "CreateChangeRequest", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadChangeRequestsToItem(Request $request)
    {
        try {
            $changeRequests = CustomerOrderChangeRequest::where('order_id', $request->orderId)
                ->where('notify_party', $request->notifyID)
                ->where('item_id', $request->itemID)
                ->select('created_at', 'old_qty', 'new_qty', 'status', 'old_price', 'new_price')
                ->get();


            return $this->responseBody(true, "loadChangeRequestsToItem", "", $changeRequests);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadChangeRequestsToItem", "Something went wrong", $ex->getMessage());
        }
    }
}
