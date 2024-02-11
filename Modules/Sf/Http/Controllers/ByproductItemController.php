<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\ItemPrice;
use Modules\Accounting\Entities\PriceList;
use Modules\Inventory\Entities\Item;
use Modules\Inventory\Entities\ItemGroup;
use Modules\Inventory\Entities\ItemProcessWorkstation;
use Modules\Inventory\Entities\UOM;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\ProcessWorkstation;
use Modules\Sf\Entities\CuttingType;
use Modules\Sf\Entities\FishGrade;
use Modules\Sf\Entities\Fishspecies;
use Modules\Sf\Entities\PresentationType;

class ByproductItemController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'Item_Code' => ['required'],
            'item_name' => ['required'],
        ]);
        if (Item::where('CompanyID', $request->CompanyID)->where('Item_Code', $request->Item_Code)->exists()) {
            $this->validationError('Item_Code', 'Item Code Exists!');
        }
        if (Item::where('CompanyID', $request->CompanyID)->where('item_name', $request->item_name)->exists()) {
            $this->validationError('item_name', 'Item Name Exists!');
        }

        try {
            $Item = new Item();
            $Item->CompanyID = $request->CompanyID;
            $Item->Item_Code = $request->Item_Code;
            $Item->item_name = $request->item_name;
            $Item->Inventory_code = $request->Item_Code;
            $Item->Item_description = $request->Item_description;
            $Item->rm_species = $request->rm_species;
            $Item->stock_uom = $request->stock_uom;
            $Item->avg_weight_per_unit = $request->avg_weight_per_unit;
            $Item->weight_uom = $request->weight_uom;
            $Item->item_group = $request->item_group;
            $Item->is_stock_item = true;
            $Item->is_by_product = true;
            $Item->is_seafood_item = true;
            $Item->list_index = $request->list_index;
            $Item->is_sales_item = $request->has('is_sales_item');
            $Item->enabled = $request->has('enabled');
            $Item->created_by = Auth::user()->id;
            $save = $Item->save();



            if ($save) {
                return $this->responseBody(true, "save", "Item Saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something Went Wrong!", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'Item_Code' => ['required'],
            'item_name' => ['required'],
        ]);

        $data1 = Item::where('CompanyID', $request->CompanyID)->where('Item_Code', $request->Item_Code);
        $data2 = Item::where('CompanyID', $request->CompanyID)->where('item_name', $request->item_name);

        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('Item_Code', 'Item Code Exists');
            }
        }
        if ($data2->exists()) {
            if ($data2->first()->id != $request->id) {
                $this->validationError('item_name', 'Item Name Exists');
            }
        }
        try {
            $Item = Item::find($request->id);
            $Item->CompanyID = $request->CompanyID;
            $Item->Item_Code = $request->Item_Code;
            $Item->item_name = $request->item_name;
            $Item->Inventory_code = $request->Item_Code;
            $Item->Item_description = $request->Item_description;
            $Item->rm_species = $request->rm_species;
            $Item->stock_uom = $request->stock_uom;
            $Item->avg_weight_per_unit = $request->avg_weight_per_unit;
            $Item->weight_uom = $request->weight_uom;
            $Item->item_group = $request->item_group;
            $Item->list_index = $request->list_index;
            $Item->is_sales_item = $request->has('is_sales_item');
            $Item->enabled = $request->has('enabled');
            $Item->modified_by = Auth::user()->id;
            $save = $Item->save();

            if ($save) {
                return $this->responseBody(true, "save", "Item Updated", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something Went Wrong", $exception->getMessage());
        }
    }

    public function loadbyproductItems()
    {
        try {

            $Item = DB::table('inventory_items')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'inventory_items.rm_species')
                ->where('inventory_items.is_stock_item', true)
                ->where('inventory_items.is_by_product', true)
                ->where('inventory_items.is_seafood_item', true)
                ->select('inventory_items.id', 'inventory_items.item_name', 'inventory_items.Item_Code', 'sf_fish_species.FishName')
                ->orderBy('inventory_items.id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadbyproductItems", "found", $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadbyproductItems", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Item = Item::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Item Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something Went Wrong", $exception->getMessage());
        }
    }

    public function loadbyproductItem($id)
    {
        try {
            $Item = Item::where('id', $id)->first();
            return $this->responseBody(true, "loadItem", "found", $Item);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadItem", "error", $exception->getMessage());
        }
    }
    public function loadcompanies()
    {
        try {
            $Company = Company::where('enabled', true)->get();

            return $this->responseBody(true, "loadcompanies", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadcompanies", '', $ex->getMessage());
        }
    }
    public function loadFishSpecis()
    {
        try {
            $Fishspecies = Fishspecies::where('enabled', true)->get();

            return $this->responseBody(true, "loadFishSpecis", '', $Fishspecies);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishSpecis", '', $ex->getMessage());
        }
    }

    public function loadUom()
    {
        try {
            $UOM = UOM::where('enabled', true)->get();

            return $this->responseBody(true, "loadUom", '', $UOM);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadUom", '', $ex->getMessage());
        }
    }
    public function loadItemGroup()
    {
        try {
            $ItemGroup = ItemGroup::where('enabled', true)->get();

            return $this->responseBody(true, "loadItemGroup", '', $ItemGroup);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItemGroup", '', $ex->getMessage());
        }
    }
    public function loadDefaultWeightAndUom($id)
    {
        try {
            $Fishspecies = Fishspecies::where('id', $id)->select('default_weight_unit', 'average_weight')->first();

            return $this->responseBody(true, "loadDefaultWeightAndUom", '', $Fishspecies);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDefaultWeightAndUom", '', $ex->getMessage());
        }
    }
    public function loadProcessWorkstations()
    {
        try {
            $result = DB::table('settings_process_workstations')
                ->join('settings_processes', 'settings_processes.id', '=', 'settings_process_workstations.ProcessID')
                ->join('settings_workstations', 'settings_workstations.id', '=', 'settings_process_workstations.WorkstationID')
                ->select('settings_process_workstations.id', DB::raw("CONCAT(settings_processes.ProcessName, ' | ', settings_workstations.WorkstationName) AS concatenated_names"))
                ->get();

            // $ProcessWorkstation = ProcessWorkstation::where('enabled', true)->select('id','')->get();

            return $this->responseBody(true, "loadProcessWorkstations", '', $result);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadProcessWorkstations", '', $ex->getMessage());
        }
    }
    public function saveItemProcessWorkstation(Request $request)
    {
        try {
            $ItemProcessWorkstation = new ItemProcessWorkstation();
            $ItemProcessWorkstation->item_id = $request->itemId;
            $ItemProcessWorkstation->process_workstation_id = $request->ProcessWorkStation;
            $ItemProcessWorkstation->created_by = Auth::id();
            $ItemProcessWorkstation->save();

            return $this->responseBody(true, "saveItemProcessWorkstation", '', '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "saveItemProcessWorkstation", '', $ex->getMessage());
        }
    }
    public function loadItemProcessWorkstation($itemId)
    {
        try {
            $result =DB::table('inventory_item_process_workstations')
            ->join('settings_process_workstations', 'settings_process_workstations.id', '=', 'inventory_item_process_workstations.process_workstation_id')
            ->join('settings_processes', 'settings_processes.id', '=', 'settings_process_workstations.ProcessID')
            ->join('settings_workstations', 'settings_workstations.id', '=', 'settings_process_workstations.WorkstationID')
            ->select('inventory_item_process_workstations.id', 'settings_processes.ProcessName', 'settings_workstations.WorkstationName')
            ->where('inventory_item_process_workstations.item_id',$itemId)
            ->get();

            return $this->responseBody(true, "loadItemProcessWorkstation", '', $result);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItemProcessWorkstation", '', $ex->getMessage());
        }
    }
    public function deleteItemProcessWorkstation($id)
    {
        try {
            $Item = ItemProcessWorkstation::where('id', $id)->delete();
            return $this->responseBody(true, "deleteItemProcessWorkstation", "Item Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "deleteItemProcessWorkstation", "Something Went Wrong", $exception->getMessage());
        }
    }
    public function loadPriceListModleData()
    {

        try {
            $PriceList = PriceList::where('enabled', true)->select('id', 'price_list_name')->get();
            $UOM = UOM::where('enabled', true)->select('UomName','id')->get();


            return $this->responseBody(true, "save", "loadWastageModleData", ['PriceList' => $PriceList, 'UOM' => $UOM]);
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "loadWastageModleData", $exception->getMessage());
        }
    }
    public function savePriceList(Request $request)
    {

        if(ItemPrice::where('item',$request->item)->where('price_list',$request->price_list)->where('uom',$request->uom)->exists()){
            $this->validationError('price_list','This item exists in the price list');
        }
        try {
            $ItemPrice = new ItemPrice();
            $ItemPrice->item = $request->itemId;
            $ItemPrice->price_list = $request->pricelist;
            $ItemPrice->uom = $request->uom;
            $ItemPrice->price = $request->price;
            $ItemPrice->enabled = $request->has('enabled');
            $ItemPrice->created_by = Auth::id();
            $save = $ItemPrice->save();

            if ($save) {
                return $this->responseBody(true, "savePriceList", "ItemPrice saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "savePriceList", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadItemPrice($itemId)
    {
        try {

            $ItemPrice =DB::table('accounting_item_price')
                            // ->leftJoin('inventory_uom','inventory_uom.id','=','accounting_item_price.uom')
                            ->leftJoin('accounting_price_list','accounting_price_list.id','=','accounting_item_price.price_list')
                            ->leftJoin('inventory_uom','inventory_uom.id','=','accounting_item_price.uom')
                            ->where('accounting_item_price.item',$itemId)
                            ->select('accounting_item_price.id','accounting_item_price.price','accounting_price_list.price_list_name','inventory_uom.UomName')
                            ->orderBy('id','ASC')
                            ->get();

            return $this->responseBody(true, "loadItemPrice", "found", $ItemPrice);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItemPrice", "Something went wrong", $ex->getMessage());
        }
    }
    public function deleteItemPriceList($id)
    {
        try {
            $Item = ItemPrice::where('id', $id)->delete();
            return $this->responseBody(true, "deleteItemPriceList", "Item Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "deleteItemPriceList", "Something Went Wrong", $exception->getMessage());
        }
    }
}
