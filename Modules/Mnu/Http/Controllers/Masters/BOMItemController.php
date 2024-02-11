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
use Modules\Mnu\Entities\BOMItemDetail;
use Modules\Settings\Entities\Process;
use Modules\Settings\Entities\Workstation;

class BOMItemController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'Item_Code' => ['required'],
            'item_name' => ['required'],
            'BOM_itemType'  => ['required'],
            'process'       => ['required'],
            'work_station'  => ['required'],

        ]);
        //validate outter Main item Duplicate Items
        $mainItemsArr = [];
        if ($request->BOM_itemType == 'Outer_Bom') {
            for ($i = 0; $i <= $request->MainItemCount; $i++) {
                if ($request->has("mainItem_name_$i")) {
                    array_push($mainItemsArr, ['index' => $i, 'item' => $request->get("mainItem_name_$i")]);
                }
            }
        }
        if (!empty($mainItemsArr)) {
            for ($i = 0; $i < count($mainItemsArr); $i++) {
                for ($j = 0; $j < count($mainItemsArr); $j++) {
                    if ($mainItemsArr[$i]['index'] != $mainItemsArr[$j]['index']) {
                        if ($mainItemsArr[$i]['item'] == $mainItemsArr[$j]['item']) {
                            $this->validationError("mainItem_name_$j", 'Duplicated Main Item');
                        }
                    }
                }
            }
        }
        //validate other item Duplicate Items
        $OtherItemsArr = [];
        if ($request->otherItemCount != null) {
            for ($i = 0; $i <= $request->otherItemCount; $i++) {
                if ($request->has("Otheritem_name_$i")) {
                    array_push($OtherItemsArr, ['index' => $i, 'item' => $request->get("Otheritem_name_$i")]);
                }
            }
        }
        if (!empty($OtherItemsArr)) {
            for ($i = 0; $i < count($OtherItemsArr); $i++) {
                for ($j = 0; $j < count($OtherItemsArr); $j++) {
                    if ($OtherItemsArr[$i]['index'] != $OtherItemsArr[$j]['index']) {
                        if ($OtherItemsArr[$i]['item'] == $OtherItemsArr[$j]['item']) {
                            $this->validationError("Otheritem_name_$j", 'Duplicated Other Item');
                        }
                    }
                }
            }
        }


        try {
            //saving BomItem
            $Item = new Item();
            $Item->Item_Code = $request->Item_Code;
            $Item->item_name = $request->item_name;
            $Item->Item_description = $request->Item_description;
            $Item->is_bom_inner_item = $this->BOMtype('is_bom_inner_item', $request->BOM_itemType);
            $Item->is_bom_outer_item = $this->BOMtype('is_bom_outer_item', $request->BOM_itemType);
            $Item->is_seafood_item = true;
            $Item->Inventory_code = $request->Item_Code;
            $Item->avg_weight_per_unit = $request->averageNet_weight;
            $Item->avg_gross_weight_per_unit = $request->averageGross_weight;
            $Item->process = $request->process;
            $Item->work_station = $request->work_station;


            $Item->enabled = $request->has('enabled');
            $Item->created_by = Auth::user()->id;
            $save = $Item->save();

            //saving MainItem
            if ($request->BOM_itemType == 'Inner_Bom') {
                if ($save && $request->mainItem_name != null) {
                    $mainItem = new BOMItemDetail();
                    $mainItem->bom_item_id = $Item->id;
                    $mainItem->item_id = $request->mainItem_name;
                    $mainItem->qty = 1;
                    $mainItem->unit_net_weight = $request->mainItem_weight;
                    $mainItem->total_net_weight = $request->mainItem_weight;
                    $mainItem->include_in_reprocessing = $request->has('mainItem_reprocess');
                    $mainItem->is_main_item = true;
                    $mainItem->enabled = true;
                    $mainItem->created_by = Auth::user()->id;
                    $mainItem->save();
                }
            } else {
                for ($i = 0; $i <= $request->MainItemCount; $i++) {
                    if ($request->has("mainItem_name_$i")) {
                        $mainItem = new BOMItemDetail();
                        $mainItem->bom_item_id = $Item->id;
                        $mainItem->item_id = $request->get("mainItem_name_$i");
                        $mainItem->qty = $request->get("mainItem_qty_$i");
                        $mainItem->unit_net_weight = (int) $request->get("mainItem_netWeight_$i") / (int)$request->get("mainItem_qty_$i");
                        $mainItem->unit_gross_weight = (int)$request->get("mainItem_GrossWeight_$i") / (int)$request->get("mainItem_qty_$i");
                        $mainItem->total_net_weight = $request->get("mainItem_netWeight_$i");
                        $mainItem->total_gross_weight = $request->get("mainItem_GrossWeight_$i");
                        $mainItem->include_in_reprocessing = $request->get("mainItem_reprocess_$i");
                        $mainItem->is_main_item = true;
                        $mainItem->enabled = true;
                        $mainItem->created_by = Auth::user()->id;
                        $mainItem->save();
                    }
                }
            }

            //saving ContainerItem
            if ($save && $request->ContainerItem_name != null) {
                $ContainerItem = new BOMItemDetail();
                $ContainerItem->bom_item_id = $Item->id;
                $ContainerItem->item_id = $request->ContainerItem_name;
                $ContainerItem->qty = 1;
                $ContainerItem->unit_net_weight = $request->conteinerItem_weight;
                $ContainerItem->include_in_reprocessing = $request->has('conteinerItem_reprocess');
                $ContainerItem->is_container_item = true;
                $ContainerItem->enabled = true;
                $ContainerItem->created_by = Auth::user()->id;
                $ContainerItem->save();
            }

            //saving LableItem
            if ($save && $request->lableItemName != null) {
                $LableItem = new BOMItemDetail();
                $LableItem->bom_item_id = $Item->id;
                $LableItem->item_id = $request->lableItemName;
                $LableItem->unit_net_weight = $request->lableItemWeight;
                $LableItem->qty = $request->lableItem_Qty;
                $LableItem->include_in_reprocessing = $request->has('lableItem_reprocess');
                $LableItem->is_label_item = true;
                $LableItem->enabled = true;
                $LableItem->created_by = Auth::user()->id;
                $LableItem->save();
            }

            //saving otherItems
            if ($save && $request->otherItemCount != null) {
                for ($i = 0; $i <= $request->otherItemCount; $i++) {
                    if ($request->has("Otheritem_name_$i")) {
                        $BOMItemDetail = new BOMItemDetail();
                        $BOMItemDetail->bom_item_id = $Item->id;
                        $BOMItemDetail->item_id = $request->get("Otheritem_name_$i");
                        $BOMItemDetail->qty = $request->get("Otheritem_qty_$i");
                        $BOMItemDetail->unit_net_weight = $request->get("Otheritem_weight_$i");
                        $BOMItemDetail->include_in_reprocessing = $request->get("Otheritem_reprocess_$i");
                        $BOMItemDetail->is_other_pm_item = true;
                        $BOMItemDetail->enabled = true;
                        $BOMItemDetail->created_by = Auth::user()->id;
                        $BOMItemDetail->save();
                    }
                }
            }

            if ($save) {
                return $this->responseBody(true, "save", "Item saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'Item_Code' => ['required'],
            'item_name' => ['required'],
            'process'       => ['required'],
            'work_station'  => ['required'],
        ]);
        //validate outter Main item Duplicate Items
        $mainItemsArr = [];
        if ($request->BOM_itemType == 'Outer_Bom') {
            for ($i = 0; $i <= $request->MainItemCount; $i++) {
                if ($request->has("mainItem_name_$i")) {
                    array_push($mainItemsArr, ['index' => $i, 'item' => $request->get("mainItem_name_$i")]);
                }
            }
        }
        if (!empty($mainItemsArr)) {
            for ($i = 0; $i < count($mainItemsArr); $i++) {
                for ($j = 0; $j < count($mainItemsArr); $j++) {
                    if ($mainItemsArr[$i]['index'] != $mainItemsArr[$j]['index']) {
                        if ($mainItemsArr[$i]['item'] == $mainItemsArr[$j]['item']) {
                            $this->validationError("mainItem_name_$j", 'Duplicated Main Item');
                        }
                    }
                }
            }
        }
        //validate other item Duplicate Items
        $OtherItemsArr = [];
        if ($request->otherItemCount != null) {
            for ($i = 0; $i <= $request->otherItemCount; $i++) {
                if ($request->has("Otheritem_name_$i")) {
                    array_push($OtherItemsArr, ['index' => $i, 'item' => $request->get("Otheritem_name_$i")]);
                }
            }
        }
        if (!empty($OtherItemsArr)) {
            for ($i = 0; $i < count($OtherItemsArr); $i++) {
                for ($j = 0; $j < count($OtherItemsArr); $j++) {
                    if ($OtherItemsArr[$i]['index'] != $OtherItemsArr[$j]['index']) {
                        if ($OtherItemsArr[$i]['item'] == $OtherItemsArr[$j]['item']) {
                            $this->validationError("Otheritem_name_$j", 'Duplicated Other Item');
                        }
                    }
                }
            }
        }

        try {
            $Item = Item::find($request->id);
            $Item->Item_Code = $request->Item_Code;
            $Item->item_name = $request->item_name;
            $Item->Item_description = $request->Item_description;
            $Item->is_bom_inner_item = $this->BOMtype('is_bom_inner_item', $request->BOM_itemType);
            $Item->is_bom_outer_item = $this->BOMtype('is_bom_outer_item', $request->BOM_itemType);
            $Item->is_seafood_item = true;
            $Item->Inventory_code = $request->Item_Code;
            $Item->avg_weight_per_unit = $request->averageNet_weight;
            $Item->avg_gross_weight_per_unit = $request->averageGross_weight;
            $Item->process = $request->process;
            $Item->work_station = $request->work_station;
            $Item->enabled = $request->has('enabled');
            $Item->modified_by = Auth::user()->id;
            $save = $Item->save();

            //delete previous items
            BOMItemDetail::where('bom_item_id', $request->id)->delete();

            //saving MainItem
            if ($request->BOM_itemType == 'Inner_Bom') {
                if ($save && $request->mainItem_name != null) {
                    $mainItem = new BOMItemDetail();
                    $mainItem->bom_item_id = $Item->id;
                    $mainItem->item_id = $request->mainItem_name;
                    $mainItem->qty = 1;
                    $mainItem->unit_net_weight = $request->mainItem_weight;
                    $mainItem->total_net_weight = $request->mainItem_weight;
                    $mainItem->include_in_reprocessing = $request->has('mainItem_reprocess');
                    $mainItem->is_main_item = true;
                    $mainItem->enabled = true;
                    $mainItem->modified_by = Auth::user()->id;
                    $mainItem->save();
                }
            } else {
                for ($i = 0; $i <= $request->MainItemCount; $i++) {
                    if ($request->has("mainItem_name_$i")) {
                        $mainItem = new BOMItemDetail();
                        $mainItem->bom_item_id = $Item->id;
                        $mainItem->item_id = $request->get("mainItem_name_$i");
                        $mainItem->qty = $request->get("mainItem_qty_$i");
                        $mainItem->unit_net_weight = (int) $request->get("mainItem_netWeight_$i") / (int)$request->get("mainItem_qty_$i");
                        $mainItem->unit_gross_weight = (int)$request->get("mainItem_GrossWeight_$i") / (int)$request->get("mainItem_qty_$i");
                        $mainItem->total_net_weight = $request->get("mainItem_netWeight_$i");
                        $mainItem->total_gross_weight = $request->get("mainItem_GrossWeight_$i");
                        $mainItem->include_in_reprocessing = $request->get("mainItem_reprocess_$i");
                        $mainItem->is_main_item = true;
                        $mainItem->enabled = true;
                        $mainItem->modified_by = Auth::user()->id;
                        $mainItem->save();
                    }
                }
            }

            //saving ContainerItem
            if ($save && $request->ContainerItem_name != null) {
                $ContainerItem = new BOMItemDetail();
                $ContainerItem->bom_item_id = $Item->id;
                $ContainerItem->item_id = $request->ContainerItem_name;
                $ContainerItem->qty = 1;
                $ContainerItem->unit_net_weight = $request->conteinerItem_weight;
                $ContainerItem->include_in_reprocessing = $request->has('conteinerItem_reprocess');
                $ContainerItem->is_container_item = true;
                $ContainerItem->enabled = true;
                $ContainerItem->modified_by = Auth::user()->id;
                $ContainerItem->save();
            }

            //saving LableItem
            if ($save && $request->lableItemName != null) {
                $LableItem = new BOMItemDetail();
                $LableItem->bom_item_id = $Item->id;
                $LableItem->item_id = $request->lableItemName;
                $LableItem->unit_net_weight = $request->lableItemWeight;
                $LableItem->qty = $request->lableItem_Qty;
                $LableItem->include_in_reprocessing = $request->has('lableItem_reprocess');
                $LableItem->is_label_item = true;
                $LableItem->enabled = true;
                $LableItem->modified_by = Auth::user()->id;
                $LableItem->save();
            }

            //saving otherItems
            if ($save && $request->otherItemCount != null) {
                for ($i = 0; $i <= $request->otherItemCount; $i++) {
                    if ($request->has("Otheritem_name_$i")) {
                        $BOMItemDetail = new BOMItemDetail();
                        $BOMItemDetail->bom_item_id = $Item->id;
                        $BOMItemDetail->item_id = $request->get("Otheritem_name_$i");
                        $BOMItemDetail->qty = $request->get("Otheritem_qty_$i");
                        $BOMItemDetail->unit_net_weight = $request->get("Otheritem_weight_$i");
                        $BOMItemDetail->include_in_reprocessing = $request->get("Otheritem_reprocess_$i");
                        $BOMItemDetail->is_other_pm_item = true;
                        $BOMItemDetail->enabled = true;
                        $BOMItemDetail->modified_by = Auth::user()->id;
                        $BOMItemDetail->save();
                    }
                }
            }


            if ($save) {
                return $this->responseBody(true, "Update", "Item saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "Update", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadBOMItems()
    {
        try {
            $Item = Item::where('is_bom_inner_item', true)
                ->orWhere('is_bom_outer_item', true)
                ->orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadBOMItems", "found", $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBOMItems", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Item = Item::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Item Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadBOMItem($id)
    {
        try {
            $innerBom = false;
            $outerBom = false;
            $mainItem = '';
            $lableItem = '';
            $containerItem = '';
            $otherItem = '';



            $Item = Item::where('id', $id)->first();

            if (Item::where('id', $id)->first()->is_bom_inner_item) {
                $innerBom = true;
                $mainItem = BOMItemDetail::where('bom_item_id', $id)->where('is_main_item', true)->where('enabled', true)->first();
            } elseif (Item::where('id', $id)->first()->is_bom_outer_item) {
                $outerBom = true;
                $mainItem = BOMItemDetail::where('bom_item_id', $id)->where('is_main_item', true)->where('enabled', true)->get();
            }
            $lableItem = BOMItemDetail::where('bom_item_id', $id)->where('is_label_item', true)->where('enabled', true)->first();
            $containerItem = BOMItemDetail::where('bom_item_id', $id)->where('is_container_item', true)->where('enabled', true)->first();
            $otherItem = BOMItemDetail::where('bom_item_id', $id)->where('is_other_pm_item', true)->where('enabled', true)->get();


            return $this->responseBody(true, "loadBOMItem", "found", [
                'BOM_Item' => $Item,
                'inner_bom' => $innerBom,
                'outer_bom' => $outerBom,
                'mainItem' => $mainItem,
                'lableItem' => $lableItem,
                'containerItem' => $containerItem,
                'otherItem' => $otherItem,
            ]);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadBOMItem", "error", $exception->getMessage());
        }
    }
    public function loadOtherItems()
    {
        try {
            $Item = Item::where('is_fixed_asset', false)->where('enabled', true)->get();

            return $this->responseBody(true, "loadOtherItems", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadOtherItems", '', $ex->getMessage());
        }
    }
    public function loadOtherItemUnitWeight($itemId)
    {
        try {
            $Item = Item::where('id', $itemId)->select('avg_weight_per_unit')->first()->avg_weight_per_unit;

            return $this->responseBody(true, "loadOtherItemUnitWeight", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadOtherItemUnitWeight", '', $ex->getMessage());
        }
    }
    public function loadMainItem()
    {
        try {
            $Item = Item::where('is_manufacturing_item', true)->where('enabled', true)->get();

            return $this->responseBody(true, "loadMainItem", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadMainItem", '', $ex->getMessage());
        }
    }
    public function loadContainerItem()
    {
        try {
            $Item = Item::where('is_fixed_asset', false)->where('enabled', true)->get();

            return $this->responseBody(true, "loadContainerItem", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadContainerItem", '', $ex->getMessage());
        }
    }
    public function loadLableItem()
    {
        try {
            $Item = Item::where('is_fixed_asset', false)->where('enabled', true)->get();

            return $this->responseBody(true, "loadLableItem", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadLableItem", '', $ex->getMessage());
        }
    }
    public function loadUnitWeight($itemId)
    {
        try {
            $Item = Item::where('id', $itemId)->select('avg_weight_per_unit')->first()->avg_weight_per_unit;

            return $this->responseBody(true, "loadUnitWeight", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadUnitWeight", '', $ex->getMessage());
        }
    }
    public function loadMainItems()
    {
        try {
            $Item = Item::where('is_bom_inner_item', true)->orwhere('is_bom_outer_item', true)->orwhere('is_manufacturing_item', true)->where('enabled', true)->get();

            return $this->responseBody(true, "loadMainItems", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadMainItems", '', $ex->getMessage());
        }
    }
    public function loadMainItemUnitWeight($itemId)
    {
        try {
            $Item = Item::where('id', $itemId)->select('avg_weight_per_unit', 'avg_gross_weight_per_unit')->first();

            return $this->responseBody(true, "loadMainItemUnitWeight", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadMainItemUnitWeight", '', $ex->getMessage());
        }
    }
    private function BOMtype($saveType, $getType)
    {
        if ($saveType == 'is_bom_inner_item' && $getType == 'Inner_Bom') {
            return true;
        } elseif ($saveType == 'is_bom_outer_item' && $getType == 'Outer_Bom') {
            return true;
        } else {
            return false;
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

            return $this->responseBody(true, "loadProcess", '', $Process);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadProcess", '', $ex->getMessage());
        }
    }
}
