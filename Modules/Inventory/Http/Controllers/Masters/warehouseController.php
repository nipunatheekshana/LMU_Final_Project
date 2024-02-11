<?php

namespace Modules\Inventory\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\Warehouse;
use Modules\Inventory\Entities\WarehouseType;
use Modules\Settings\Entities\Country;

class warehouseController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'warehouse_name' => ['required'],
        ]);
        try {
            $Warehouse = new Warehouse();
            $Warehouse->company_id = Auth::user()->company_id;
            $Warehouse->warehouse_name = $request->warehouse_name;
            $Warehouse->warehouse_type = $request->warehouse_type;
            $Warehouse->is_group = $request->has('is_group');
            $Warehouse->parent_warehouse = $request->parent_warehouse;
            $Warehouse->warehouse_address_1 = $request->warehouse_address_1;
            $Warehouse->warehouse_address_2 = $request->warehouse_address_2;
            $Warehouse->warehouse_city = $request->warehouse_city;
            $Warehouse->warehouse_state = $request->warehouse_state;
            $Warehouse->warehouse_country = $request->warehouse_country;
            $Warehouse->warehouse_email = $request->warehouse_email;
            $Warehouse->warehouse_phone = $request->warehouse_phone;
            $Warehouse->default_intransit_warehouse = $request->default_intransit_warehouse;
            $Warehouse->default_account = $request->default_account;
            $Warehouse->enabled = $request->has('enabled');
            $Warehouse->created_by = Auth::user()->id;
            $save = $Warehouse->save();



            if ($save) {
                return $this->responseBody(true, "save", "Warehouse saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'warehouse_name' => ['required'],
        ]);
        try {
            $Warehouse = Warehouse::find($request->id);
            $Warehouse->warehouse_name = $request->warehouse_name;
            $Warehouse->warehouse_type = $request->warehouse_type;
            $Warehouse->is_group = $request->has('is_group');
            $Warehouse->parent_warehouse = $request->parent_warehouse;
            $Warehouse->warehouse_address_1 = $request->warehouse_address_1;
            $Warehouse->warehouse_address_2 = $request->warehouse_address_2;
            $Warehouse->warehouse_city = $request->warehouse_city;
            $Warehouse->warehouse_state = $request->warehouse_state;
            $Warehouse->warehouse_country = $request->warehouse_country;
            $Warehouse->warehouse_email = $request->warehouse_email;
            $Warehouse->warehouse_phone = $request->warehouse_phone;
            $Warehouse->default_intransit_warehouse = $request->default_intransit_warehouse;
            $Warehouse->default_account = $request->default_account;
            $Warehouse->modified_by = Auth::user()->id;
            $save = $Warehouse->save();

            if ($save) {
                return $this->responseBody(true, "save", "Warehouse saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadWarehouses()
    {
        try {
            $Warehouse = Warehouse::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadWarehouses", "found", $Warehouse);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadWarehouses", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Warehouse = Warehouse::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Warehouse Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadWarehouse($id)
    {
        try {
            $Warehouse = Warehouse::where('id', $id)->first();
            return $this->responseBody(true, "loadWarehouse", "found", $Warehouse);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadWarehouse", "error", $exception->getMessage());
        }
    }
    public function loadDropDownData()
    {
        try {

            $WarehouseType = WarehouseType::select('id','warehouse_type_name')->get();
            $Warehouse = Warehouse::select('id','warehouse_name')->get();
            $WarehouseGroup = Warehouse::select('id','warehouse_name')->where('is_group',true)->get();
            $Country = Country::select('id','country_name')->get();

            return $this->responseBody(
                true,
                "loadDeliveryNote",
                "found",
                [
                    'WarehouseType' => $WarehouseType,
                    'Warehouse'=>$Warehouse,
                    'WarehouseGroup'=>$WarehouseGroup,
                    'Country'=>$Country,
                ]
            );
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadDeliveryNote", "error", $exception->getMessage());
        }
    }
}
