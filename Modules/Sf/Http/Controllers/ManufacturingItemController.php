<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Inventory\Entities\Item;
use Modules\Inventory\Entities\ItemGroup;
use Modules\Inventory\Entities\UOM;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\Process;
use Modules\Sf\Entities\CuttingType;
use Modules\Sf\Entities\FishGrade;
use Modules\Sf\Entities\Fishspecies;
use Modules\Sf\Entities\PresentationType;

class ManufacturingItemController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'Item_Code'     => ['required'],
            'item_name'     => ['required'],
            'process'       => ['required'],
            'work_station'  => ['required'],
        ]);
        if(Item::where('CompanyID',$request->CompanyID)->where('Item_Code',$request->Item_Code)->exists()){
            $this->validationError('Item_Code','Item Code exists');
        }
        if(Item::where('CompanyID',$request->CompanyID)->where('item_name',$request->item_name)->exists()){
            $this->validationError('item_name','item name exists');
        }

        try {
            $Item = new Item();
            $Item->CompanyID = $request->CompanyID;
            $Item->Inventory_code = $request->Item_Code;
            $Item->Item_Code = $request->Item_Code;
            $Item->item_name = $request->item_name;
            $Item->Item_description = $request->Item_description;
            $Item->rm_species = $request->rm_species;
            $Item->ProductPresentation = $request->ProductPresentation;
            $Item->ProductCutType = $request->ProductCutType;
            $Item->ProductQuality = $request->ProductQuality;
            $Item->ProductSpec = $request->ProductSpec;
            $Item->ReceiveGrade = $request->ReceiveGrade;
            $Item->stock_uom = $request->stock_uom;
            $Item->avg_weight_per_unit = $request->avg_weight_per_unit;
            $Item->weight_uom = $request->weight_uom;
            $Item->item_group = $request->item_group;
            $Item->is_stock_item =true;
            $Item->is_manufacturing_item = true;
            $Item->is_seafood_item = true;
            $Item->process = $request->process;
            $Item->work_station = $request->work_station;
            $Item->list_index = $request->list_index;
            $Item->enabled = $request->has('enabled');
            $Item->created_by = Auth::user()->id;
            $save = $Item->save();

            if ($request->has('image') && $save) {
                $path = Storage::putFile('private/images', new File($request->file('image')));

                $image = Item::find($Item->id);
                $image->image =  explode('/', $path)[2];
                $image->save();
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
            'Item_Code'     => ['required'],
            'item_name'     => ['required'],
            'process'       => ['required'],
            'work_station'  => ['required'],
        ]);

        $data1=Item::where('CompanyID',$request->CompanyID)->where('Item_Code',$request->Item_Code);
        $data2=Item::where('CompanyID',$request->CompanyID)->where('item_name',$request->item_name);

        if($data1->exists()){
            if($data1->first()->id!=$request->id){
                $this->validationError('Item_Code','Item Code exists');
            }
        }
        if($data2->exists()){
            if($data2->first()->id!=$request->id){
                $this->validationError('item_name','item name exists');
            }
        }
        try {
            $Item = Item::find($request->id);
            $Item->CompanyID = $request->CompanyID;
            $Item->Inventory_code = $request->Item_Code;
            $Item->Item_Code = $request->Item_Code;
            $Item->item_name = $request->item_name;
            $Item->Item_description = $request->Item_description;
            $Item->rm_species = $request->rm_species;
            $Item->ProductPresentation = $request->ProductPresentation;
            $Item->ProductCutType = $request->ProductCutType;
            $Item->ProductQuality = $request->ProductQuality;
            $Item->ProductSpec = $request->ProductSpec;
            $Item->ReceiveGrade = $request->ReceiveGrade;
            $Item->stock_uom = $request->stock_uom;
            $Item->avg_weight_per_unit = $request->avg_weight_per_unit;
            $Item->weight_uom = $request->weight_uom;
            $Item->item_group = $request->item_group;
            $Item->process = $request->process;
            $Item->work_station = $request->work_station;
            $Item->list_index = $request->list_index;
            $Item->enabled = $request->has('enabled');
            $Item->modified_by = Auth::user()->id;
            $save = $Item->save();


            if ($request->has('image') && $save) {
                $path = Storage::putFile('private/images', new File($request->file('image')));

                $image = Item::find($Item->id);
                $image->image =  explode('/', $path)[2];
                $image->save();
            }

            if ($save) {
                return $this->responseBody(true, "save", "Item saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadmanufacturingItems()
    {
        try {
            $Item = DB::table('inventory_items')
                        ->join('inventory_uom','inventory_uom.id','=','inventory_items.weight_uom')
                        ->select('inventory_items.id','inventory_items.Item_Code','inventory_items.item_name','inventory_items.avg_weight_per_unit', 'inventory_uom.UomName')
                        ->where('is_stock_item',true)
                        ->where('is_manufacturing_item',true)
                        ->where('is_seafood_item',true)
                        ->orderBy('inventory_items.id','ASC')
                        ->get();

            return $this->responseBody(true, "loadmanufacturingItems", "found", $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadmanufacturingItems", "Something went wrong", $ex->getMessage());
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

    public function loadmanufacturingItem($id)
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
            $Company = Company::where('enabled',true)->get();

            return $this->responseBody(true, "loadcompanies", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadcompanies", '', $ex->getMessage());
        }
    }
    public function loadFishSpecis()
    {
        try {
            $Fishspecies = Fishspecies::where('enabled',true)->get();

            return $this->responseBody(true, "loadFishSpecis", '', $Fishspecies);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishSpecis", '', $ex->getMessage());
        }
    }
    public function loadCuttingType()
    {
        try {
            $CuttingType = CuttingType::where('enabled',true)->get();

            return $this->responseBody(true, "loadCuttingType", '', $CuttingType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCuttingType", '', $ex->getMessage());
        }
    }
    public function loadUom()
    {
        try {
            $UOM = UOM::where('enabled',true)->get();

            return $this->responseBody(true, "loadUom", '', $UOM);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadUom", '', $ex->getMessage());
        }
    }
    public function loadItemGroup()
    {
        try {
            $ItemGroup = ItemGroup::where('enabled',true)->get();

            return $this->responseBody(true, "loadItemGroup", '', $ItemGroup);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItemGroup", '', $ex->getMessage());
        }
    }
    public function loadReceivePresentation($id)
    {
        try {
            $PresentationType = PresentationType::where('enabled', true)->where('fish_species', $id)->get();

            return $this->responseBody(true, "loadReceivePresentation", '', $PresentationType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadReceivePresentation", '', $ex->getMessage());
        }
    }
    public function loadReceiveGrade($id)
    {
        try {
            $FishGrade = FishGrade::where('fish_species', $id)->where('enabled', true)->get();

            return $this->responseBody(true, "loadReceiveGrade", '', $FishGrade);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadReceiveGrade", '', $ex->getMessage());
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
            $Process= DB::table('settings_workstations')
            ->leftJoin('settings_process_workstations','settings_process_workstations.WorkstationID','=','settings_workstations.id')
            ->where('settings_process_workstations.ProcessID',$ProcessId)
            ->where('settings_workstations.enabled',true)
            ->select('settings_workstations.*')
            ->get();

            return $this->responseBody(true, "loadProcess", '', $Process);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadProcess", '', $ex->getMessage());
        }
    }
    public function deleteImage($id)
    {
        try {
            $image = Item::where('id', $id)->first()->image;
            $path = 'app/private/images/' . $image;

            if (file_exists(storage_path($path))) {
                unlink(storage_path($path));
                Item::where('id', $id)->update(['image' => null]);
            }
            return $this->responseBody(true, "deleteImage", "image Deleted", $path);
        } catch (Exception $exception) {
            return $this->responseBody(false, "deleteImage", "Something went wrong", $exception->getMessage());
        }
    }
}
