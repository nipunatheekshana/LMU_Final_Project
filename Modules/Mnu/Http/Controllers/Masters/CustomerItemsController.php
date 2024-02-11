<?php

namespace Modules\Mnu\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\Item;
use Modules\Mnu\Entities\CustomerItem;
use Modules\Mnu\Entities\CustomerItemParameter;
use Modules\Mnu\Entities\MasterLabelsParameter;
use Modules\Selling\Entities\Customer;
use Modules\Settings\Entities\DataTypeFormat;
use Modules\Settings\Entities\Printer;

class CustomerItemsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'customer' => ['required'],
            'item' => ['required'],
            'lbl_prodname1' => ['required'],
            'gtin_no' => ['nullable', 'max:14'],
            'ean13_no' => ['nullable', 'max:13'],

        ]);
        if (CustomerItem::where('customer', $request->customer)->where('item', $request->item)->exists()) {
            $this->validationError('item', 'This combination Exsist');
        }
        try {

            $CustomerItem = new CustomerItem();
            $CustomerItem->customer = $request->customer;
            $CustomerItem->item = $request->item;
            $CustomerItem->lbl_prodname1 = $request->lbl_prodname1;
            $CustomerItem->lbl_prodname2 = $request->lbl_prodname2;
            $CustomerItem->lbl_prodname3 = $request->lbl_prodname3;
            $CustomerItem->pl_prodname1 = $request->pl_prodname1;
            $CustomerItem->pl_prodname2 = $request->pl_prodname2;
            $CustomerItem->pl_summary_name = $request->pl_summary_name;
            $CustomerItem->pl_short_name = $request->pl_short_name;
            $CustomerItem->in_prodname1 = $request->in_prodname1;
            $CustomerItem->in_prodname2 = $request->in_prodname2;
            $CustomerItem->in_short_name = $request->in_short_name;
            $CustomerItem->ot_prodname1 = $request->ot_prodname1;
            $CustomerItem->ot_prodname2 = $request->ot_prodname2;
            $CustomerItem->ot_short_name = $request->ot_short_name;
            $CustomerItem->gtin_no = $request->gtin_no;
            $CustomerItem->ean13_no = $request->ean13_no;
            $CustomerItem->cus_prod_code_1 = $request->cus_prod_code_1;
            $CustomerItem->cus_prod_code_2 = $request->cus_prod_code_2;
            $CustomerItem->numOfLables = $request->numOfLables;
            $CustomerItem->default_printer = $request->default_printer;
            $CustomerItem->is_sale_item = $request->has('is_sale_item');
            $CustomerItem->enabled = $request->has('enabled');
            $CustomerItem->created_by = Auth::user()->id;
            $save = $CustomerItem->save();

            if ($save) {
                foreach ($request->arr as $parameter) {
                    $parameter = json_decode($parameter);
                    $CustomerItemParameter = new CustomerItemParameter();
                    $CustomerItemParameter->customer_item_id = $CustomerItem->id;
                    $CustomerItemParameter->label_format_id = $parameter->label_format_id;
                    $CustomerItemParameter->parameter = $parameter->parameter;
                    $CustomerItemParameter->parameter_description = $parameter->parameter_description;
                    $CustomerItemParameter->data_type = $parameter->data_type;
                    $CustomerItemParameter->format = $parameter->format;
                    $CustomerItemParameter->sample_data = $parameter->sample_data;
                    $CustomerItemParameter->script_field = $parameter->script_field;
                    $CustomerItemParameter->script_tabel = $parameter->script_tabel;
                    $CustomerItemParameter->script_conditions = $parameter->script_conditions;
                    $CustomerItemParameter->created_by = Auth::user()->id;
                    $CustomerItemParameter->save();
                }
            }




            if ($save) {
                return $this->responseBody(true, "save", "CustomerItem saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'customer' => ['required'],
            'item' => ['required'],
            'lbl_prodname1' => ['required'],
            'gtin_no' => ['nullable', 'max:14'],
            'ean13_no' => ['nullable', 'max:13'],
        ]);
        $data = CustomerItem::where('customer', $request->customer)->where('item', $request->item);
        if ($data->exists()) {
            if ($data->first()->id != $request->id) {
                $this->validationError('item', 'This combination Exsist');
            }
        }
        try {
            $CustomerItem = CustomerItem::find($request->id);
            $CustomerItem->customer = $request->customer;
            $CustomerItem->item = $request->item;
            $CustomerItem->lbl_prodname1 = $request->lbl_prodname1;
            $CustomerItem->lbl_prodname2 = $request->lbl_prodname2;
            $CustomerItem->lbl_prodname3 = $request->lbl_prodname3;
            $CustomerItem->pl_prodname1 = $request->pl_prodname1;
            $CustomerItem->pl_prodname2 = $request->pl_prodname2;
            $CustomerItem->pl_summary_name = $request->pl_summary_name;
            $CustomerItem->pl_short_name = $request->pl_short_name;
            $CustomerItem->in_prodname1 = $request->in_prodname1;
            $CustomerItem->in_prodname2 = $request->in_prodname2;
            $CustomerItem->in_short_name = $request->in_short_name;
            $CustomerItem->ot_prodname1 = $request->ot_prodname1;
            $CustomerItem->ot_prodname2 = $request->ot_prodname2;
            $CustomerItem->ot_short_name = $request->ot_short_name;
            $CustomerItem->gtin_no = $request->gtin_no;
            $CustomerItem->ean13_no = $request->ean13_no;
            $CustomerItem->cus_prod_code_1 = $request->cus_prod_code_1;
            $CustomerItem->cus_prod_code_2 = $request->cus_prod_code_2;
            $CustomerItem->numOfLables = $request->numOfLables;
            $CustomerItem->default_printer = $request->default_printer;
            $CustomerItem->is_sale_item = $request->has('is_sale_item');
            $CustomerItem->enabled = $request->has('enabled');
            $CustomerItem->modified_by = Auth::user()->id;
            $save = $CustomerItem->save();

            if ($save) {
                CustomerItemParameter::where('customer_item_id', $request->id)->delete();

                foreach ($request->arr as $parameter) {
                    $parameter = json_decode($parameter);
                    $CustomerItemParameter = new CustomerItemParameter();
                    $CustomerItemParameter->customer_item_id = $CustomerItem->id;
                    $CustomerItemParameter->label_format_id = $parameter->label_format_id;
                    $CustomerItemParameter->parameter = $parameter->parameter;
                    $CustomerItemParameter->parameter_description = $parameter->parameter_description;
                    $CustomerItemParameter->data_type = $parameter->data_type;
                    $CustomerItemParameter->format = $parameter->format;
                    $CustomerItemParameter->sample_data = $parameter->sample_data;
                    $CustomerItemParameter->script_field = $parameter->script_field;
                    $CustomerItemParameter->script_tabel = $parameter->script_tabel;
                    $CustomerItemParameter->script_conditions = $parameter->script_conditions;
                    $CustomerItemParameter->created_by = Auth::user()->id;
                    $CustomerItemParameter->save();
                }
            }
            if ($save) {
                return $this->responseBody(true, "save", "CustomerItem saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadCustomerItems()
    {
        try {

            $CustomerItem = DB::table('mnu_customer_items')
                ->leftJoin('selling_customers', 'selling_customers.id', '=', 'mnu_customer_items.customer')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_customer_items.item')
                ->select('mnu_customer_items.id', 'selling_customers.CusName', 'inventory_items.item_name')
                ->get();

            return $this->responseBody(true, "loadCustomerItems", "found", $CustomerItem);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomerItems", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $CustomerItem = CustomerItem::where('id', $id)->delete();
            return $this->responseBody(true, "User", "CustomerItem Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadCustomerItem($id)
    {
        try {
            $CustomerItem = CustomerItem::where('id', $id)->first();
            $CustomerItemParameter=DB::table('mnu_customer_item_parameters')
                                    ->leftJoin('settings_data_types','settings_data_types.id','=','mnu_customer_item_parameters.data_type')
                                    ->where('mnu_customer_item_parameters.customer_item_id',$id)
                                    ->select('mnu_customer_item_parameters.*', 'settings_data_types.data_type as DataTypeName')
                                    ->get();

            return $this->responseBody(true, "loadCustomerItem", "found",[
                'CustomerItem'=>$CustomerItem,
                'CustomerItemParameter'=>$CustomerItemParameter
            ]);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCustomerItem", "error", $exception->getMessage());
        }
    }
    public function loadCustomers()
    {
        try {
            $Customer = Customer::where('enabled', true)->get();

            return $this->responseBody(true, "loadCustomers", '', $Customer);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomers", '', $ex->getMessage());
        }
    }
    public function loadItems($type)
    {
        try {
            if ($type == 'inner') {
                $Item = Item::where('enabled', true)->where('is_bom_inner_item', true)->get();
            } elseif ($type == 'outter') {
                $Item = Item::where('enabled', true)->where('is_bom_outer_item', true)->get();
            } else {
                $Item = Item::where('enabled', true)->where('is_bom_inner_item', true)->orWhere('is_bom_outer_item', true)->get();
            }

            return $this->responseBody(true, "loadItems", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItems", '', $ex->getMessage());
        }
    }
    public function FilterCustomerItems($customer, $itemType)
    {
        try {

            $CustomerItem = DB::table('mnu_customer_items')
                ->leftJoin('selling_customers', 'selling_customers.id', '=', 'mnu_customer_items.customer')
                ->leftJoin('inventory_items', 'inventory_items.id', '=', 'mnu_customer_items.item');

            if ($customer != 'null') {
                $CustomerItem->where('selling_customers.id', $customer);
            }
            if ($itemType != 'null') {
                if ($itemType == 'Inner_Bom') {
                    $CustomerItem->where('inventory_items.is_bom_inner_item', true);
                }
                if ($itemType == 'Outer_Bom') {
                    $CustomerItem->where('inventory_items.is_bom_outer_item', true);
                }
            }

            $CustomerItem = $CustomerItem->select('mnu_customer_items.id', 'selling_customers.CusName', 'inventory_items.item_name')
                ->get();


            return $this->responseBody(true, "FilterCustomerItems", "found", $CustomerItem);
        } catch (Exception $ex) {
            return $this->responseBody(false, "FilterCustomerItems", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadMasterLableParameters($itemType)
    {
        try {
            $MasterLabelsParameter = DB::table('mnu_master_labels_parameters')
                ->leftJoin('settings_data_types', 'settings_data_types.id', '=', 'mnu_master_labels_parameters.data_type');

            if ($itemType == 'inner') {
                $MasterLabelsParameter->where('mnu_master_labels_parameters.label_format_id', 1);
            } else {
                $MasterLabelsParameter->where('mnu_master_labels_parameters.label_format_id', 2);
            }
            $MasterLabelsParameter->select('mnu_master_labels_parameters.*', 'settings_data_types.data_type as DataTypeName');

            $MasterLabelsParameter = $MasterLabelsParameter->get();

            return $this->responseBody(true, "loadMasterLableParameters", "found", $MasterLabelsParameter);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadMasterLableParameters", "error", $exception->getMessage());
        }
    }
    public function loadDataTypeFormats($dataType)
    {
        try {
            $DataTypeFormat = DataTypeFormat::where('data_type_id', $dataType)->where('enabled', true)->get();

            return $this->responseBody(true, "loadDataTypeFormats", '', $DataTypeFormat);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDataTypeFormats", '', $ex->getMessage());
        }
    }
    public function loadNumberOfLables($ItemId)
    {
        try {
            $item = DB::table('inventory_items')
                ->leftJoin('mnu_bom_item_details', 'mnu_bom_item_details.bom_item_id', '=', 'inventory_items.id')
                ->where('inventory_items.id', $ItemId)
                ->where('mnu_bom_item_details.is_label_item', true)
                ->select('mnu_bom_item_details.qty')
                ->first()->qty;

            return $this->responseBody(true, "loadNumberOfLables", '', $item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadNumberOfLables", '', $ex->getMessage());
        }
    }
    public function loadPrinters()
    {
        try {
            $Workstation = Printer::where('enabled',true)->select('id','printer_name')->get();

            return $this->responseBody(true, "loadPrinters", '', $Workstation);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPrinters", '', $ex->getMessage());
        }
    }
}
