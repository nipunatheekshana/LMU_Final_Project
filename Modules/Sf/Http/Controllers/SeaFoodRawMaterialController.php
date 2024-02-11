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
use Illuminate\Validation\ValidationException;
use Modules\Inventory\Entities\CompanyItem;
use Modules\Inventory\Entities\Item;
use Modules\Inventory\Entities\ItemGroup;
use Modules\Inventory\Entities\UOM;
use Modules\Settings\Entities\Company;
use Modules\Sf\Entities\FishGrade;
use Modules\Sf\Entities\FishSize;
use Modules\Sf\Entities\Fishspecies;
use Modules\Sf\Entities\PresentationType;

class SeaFoodRawMaterialController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'item_name' => ['required'],
            'rm_species' => ['required'],
            'ReceivePresentation' => ['required'],
            'ReceiveGrade' => ['required'],
            'item_group' => ['required'],
            'uom' => ['required'],
            'weight_uom' => ['required'],
            'weight_uom' => ['required'],
            'avg_weight_per_unit' => ['required'],
            'image' => ['nullable', 'image', 'max:1024'],
        ]);

        if (Item::where('CompanyID', $request->CompanyID)->where('Item_Code', $request->Item_Code)->exists()) {
            $this->validationError('Item_Code', 'Item Code exists');
        }
        if (Item::where('CompanyID', $request->CompanyID)->where('item_name', $request->item_name)->exists()) {
            $this->validationError('item_name', 'item name exists');
        }

        $sizeCode = FishSize::where('minValue', '<=', $request->avg_weight_per_unit)
            ->where('maxValue', '>=', $request->avg_weight_per_unit)
            ->where('FishSpeciesId', '=', $request->rm_species)
            ->where('CompanyId', '=', $request->CompanyID)
            ->where('enabled', true)
            ->select('SizeCode', 'id')
            ->first();
        if (!$sizeCode) {
            $this->validationError('avg_weight_per_unit', 'Weight is not acceptble');
        }

        try {

            $data = DB::table('sf_fish_species')
                ->leftJoin('sf_presentation_type', 'sf_fish_species.id', '=', 'sf_presentation_type.fish_species')
                ->leftJoin('sf_fish_grades', 'sf_fish_species.id', '=', 'sf_fish_grades.fish_species')
                ->where('sf_fish_species.id',  $request->rm_species)
                ->where('sf_presentation_type.id',  $request->ReceivePresentation)
                ->where('sf_fish_grades.id',  $request->ReceiveGrade)
                ->select('sf_fish_species.FishCode', 'sf_presentation_type.PrsntCode', 'sf_fish_grades.QFishGrade')
                ->first();

            $inventory_code = $data->FishCode . '_' . $data->PrsntCode . '_' . $data->QFishGrade . '_' . $sizeCode->SizeCode;

            if (!item::where('Inventory_code', $inventory_code)->exists()) {
                $Item = new Item();
                $Item->Item_Code = $request->Item_Code;
                $Item->item_name = $request->item_name;
                $Item->CompanyID = $request->CompanyID;
                $Item->Inventory_code = $inventory_code;
                $Item->Item_description = $request->Item_description;
                $Item->rm_species = $request->rm_species;
                $Item->ReceivePresentation = $request->ReceivePresentation;
                $Item->ReceiveGrade = $request->ReceiveGrade;
                $Item->ReceiveSizeVarient = $sizeCode->id;
                $Item->item_group = $request->item_group;
                $Item->stock_uom = $request->uom;
                $Item->purchase_uom = $request->uom;
                $Item->weight_uom = $request->weight_uom;
                $Item->avg_weight_per_unit = $request->avg_weight_per_unit;
                $Item->is_inspection_required_before_receive = $request->has('is_inspection_required_before_receive');
                $Item->is_inspection_required_before_delivery = $request->has('is_inspection_required_before_delivery');
                $Item->is_stock_item = true;
                $Item->is_seafood_item = true;
                $Item->is_purchase_item = true;
                $Item->create_unit_batch = true;
                $Item->is_sf_raw_material = true;
                $Item->list_index = $request->list_index;
                $Item->enabled = $request->has('enabled');
                $Item->created_by = Auth::user()->id;
                $save = $Item->save();

                if ($request->has('image') && $save) {
                    $path = Storage::putFile('private/images', new File($request->file('image')));

                    $image = Item::find($Item->id);
                    $image->image = explode('/', $path)[2];
                    $image->save();
                }
            }

            return $this->responseBody(true, "save", "Item saved", 'data saved');
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'item_name' => ['required'],
            'rm_species' => ['required'],
            'ReceivePresentation' => ['required'],
            'ReceiveGrade' => ['required'],
            'item_group' => ['required'],
            'uom' => ['required'],
            'weight_uom' => ['required'],
            'weight_uom' => ['required'],
            'avg_weight_per_unit' => ['required'],
            'image' => ['nullable', 'image', 'max:1024'],

        ]);
        $data1 = Item::where('CompanyID', $request->CompanyID)->where('Item_Code', $request->Item_Code);
        $data2 = Item::where('CompanyID', $request->CompanyID)->where('item_name', $request->item_name);

        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('Item_Code', 'Item Code exists');
            }
        }
        if ($data2->exists()) {
            if ($data2->first()->id != $request->id) {
                $this->validationError('item_name', 'item name exists');
            }
        }
        $sizeCode = FishSize::where('minValue', '<=', $request->avg_weight_per_unit)
            ->where('maxValue', '>=', $request->avg_weight_per_unit)
            ->where('FishSpeciesId', '=', $request->rm_species)
            ->where('CompanyId', '=', $request->CompanyID)
            ->where('enabled', true)
            ->select('SizeCode', 'id')
            ->first();
        if (!$sizeCode) {
            $this->validationError('avg_weight_per_unit', 'Weight is not acceptble');
        }
        try {

            $data = DB::table('sf_fish_species')
                ->leftJoin('sf_presentation_type', 'sf_fish_species.id', '=', 'sf_presentation_type.fish_species')
                ->leftJoin('sf_fish_grades', 'sf_fish_species.id', '=', 'sf_fish_grades.fish_species')
                ->where('sf_fish_species.id',  $request->rm_species)
                ->where('sf_presentation_type.id',  $request->ReceivePresentation)
                ->where('sf_fish_grades.id',  $request->ReceiveGrade)
                ->select('sf_fish_species.FishCode', 'sf_presentation_type.PrsntCode', 'sf_fish_grades.QFishGrade')
                ->first();

            $inventory_code = $data->FishCode . '_' . $data->PrsntCode . '_' . $data->QFishGrade . '_' . $sizeCode->SizeCode;

            $save = Item::updateOrCreate(
                [
                    'rm_species' => $request->rm_species,
                    'ReceivePresentation' => $request->ReceivePresentation,
                    'ReceiveGrade' => $request->ReceiveGrade,
                    'ReceiveSizeVarient' => $sizeCode->id,
                    'CompanyID' => $request->CompanyID,
                ],
                [
                    'Item_Code' => $request->Item_Code,
                    'item_name' => $request->item_name,
                    'CompanyID' => $request->CompanyID,
                    'Inventory_code' => $inventory_code,
                    'Item_description' => $request->Item_description,
                    'rm_species' => $request->rm_species,
                    'ReceivePresentation' => $request->ReceivePresentation,
                    'ReceiveGrade' => $request->ReceiveGrade,
                    'ReceiveSizeVarient' => $sizeCode->id,
                    'item_group' => $request->item_group,
                    'stock_uom' => $request->uom,
                    'purchase_uom' => $request->uom,
                    'weight_uom' => $request->weight_uom,
                    'avg_weight_per_unit' => $request->avg_weight_per_unit,
                    'is_inspection_required_before_receive' => $request->has('is_inspection_required_before_receive'),
                    'is_inspection_required_before_delivery' => $request->has('is_inspection_required_before_delivery'),
                    'is_stock_item' => true,
                    'is_seafood_item' => true,
                    'is_purchase_item' => true,
                    'create_unit_batch' => true,
                    'is_sf_raw_material' => true,
                    'list_index' => $request->list_index,
                    'enabled' => $request->has('enabled'),
                ]
            );

            if ($request->has('image') && $save) {
                $path = Storage::putFile('private/images', new File($request->file('image')));

                $image = Item::find($request->id);
                $image->image = explode('/', $path)[2];
                $image->save();
            }

            if ($save) {
                return $this->responseBody(true, "save", "Item saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadseaFoodRawMaterials()
    {
        try {
            $Item = Item::where('is_sf_raw_material', true)
                ->orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadseaFoodRawMaterials", "found", $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadseaFoodRawMaterials", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {

            $image = Item::where('id', $id)->first()->image;
            $path = 'app/private/images/' . $image;

            if (file_exists(storage_path($path))) {
                unlink(storage_path($path));
                Item::where('id', $id)->update(['image' => null]);
            }
            Item::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Item Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Item = Item::where('id', $id)->first();
            return $this->responseBody(true, "User", "Item ", $Item);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadseaFoodRawMaterial($id)
    {
        try {
            $Item = Item::where('id', $id)->first();
            return $this->responseBody(true, "loadItem", "found", $Item);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadItem", "error", $exception->getMessage());
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
    public function loaditemGoup()
    {
        try {
            $ItemGroup = ItemGroup::where('enabled', true)->get();

            return $this->responseBody(true, "loaditemGoup", '', $ItemGroup);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loaditemGoup", '', $ex->getMessage());
        }
    }
    public function loaduom()
    {
        try {
            $UOM = UOM::where('enabled', true)->get();

            return $this->responseBody(true, "loaduom", '', $UOM);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loaduom", '', $ex->getMessage());
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
    public function loaCompanies()
    {
        try {
            $Company = Company::where('enabled', true)->get();

            return $this->responseBody(true, "loaCompanies", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loaCompanies", '', $ex->getMessage());
        }
    }
}
