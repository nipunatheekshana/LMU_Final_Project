<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use Modules\Inventory\Entities\UOM;
use Modules\Sf\Entities\Fishspecies;
use Modules\Sf\Entities\PresentationType;

class FishspeciesMasterController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'FishCode' => ['required'],
            'FishName' => ['required'],
            'default_weight_unit' => ['required'],
            'average_weight' => ['required'],
            'currentFishSerialNo' => ['required'],
            'minFishSerialNo' => ['required'],
            'maxFishSerialNo' => ['required'],
            'QRiskLevel' => ['nullable', 'integer'],
        ]);
        if (Fishspecies::where('FishCode', $request->FishCode)->exists()) {
            $this->validationError('FishCode', 'Fish Code exists');
        }
        if (Fishspecies::where('FishName', $request->FishName)->exists()) {
            $this->validationError('FishName', 'Fish Name exists');
        }
        if (Fishspecies::where('ShortName', $request->ShortName)->exists()) {
            $this->validationError('ShortName', 'Short Name exists');
        }
        try {
            $Fishspecies = new Fishspecies();
            $Fishspecies->FishCode = $request->FishCode;
            $Fishspecies->FishName = $request->FishName;
            $Fishspecies->ScName = $request->ScName;
            $Fishspecies->ShortName = $request->ShortName;
            $Fishspecies->default_weight_unit = $request->default_weight_unit;
            $Fishspecies->average_weight = $request->average_weight;
            $Fishspecies->list_index = $request->list_index;
            $Fishspecies->QRiskLevel = $request->QRiskLevel;
            $Fishspecies->currentFishSerialNo = $request->currentFishSerialNo;
            $Fishspecies->minFishSerialNo = $request->minFishSerialNo;
            $Fishspecies->maxFishSerialNo = $request->maxFishSerialNo;
            $Fishspecies->BulkMode = $request->has('BulkMode');
            $Fishspecies->enabled = $request->has('enabled');
            $Fishspecies->is_reef_fish = $request->has('is_reef_fish');
            $Fishspecies->created_by = Auth::user()->id;
            $Fishspecies->companyId = Auth::user()->company_id;
            $save = $Fishspecies->save();

            if ($request->has('img') && $save) {
                $path = Storage::putFile('private/images', new File($request->file('img')));

                $image = Fishspecies::find($Fishspecies->id);
                $image->img =  explode('/', $path)[2];
                $image->save();
            }
            if ($save) {
                return $this->responseBody(true, "save", "Fishspecies saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'FishCode' => ['required'],
            'FishName' => ['required'],
            'default_weight_unit' => ['required'],
            'average_weight' => ['required'],

            'QRiskLevel' => ['nullable', 'integer'],
        ]);
        $data1 = Fishspecies::where('FishCode', $request->FishCode);
        $data2 = Fishspecies::where('FishName', $request->FishName);
        $data3 = Fishspecies::where('ShortName', $request->ShortName);

        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('FishCode', 'Fish Code exists');
            }
        }
        if ($data2->exists()) {
            if ($data2->first()->id != $request->id) {
                $this->validationError('FishName', 'Fish Name exists');
            }
        }
        if ($data3->exists()) {
            if ($data3->first()->id != $request->id) {
                $this->validationError('ShortName', 'Short Name exists');
            }
        }
        try {
            $Fishspecies = Fishspecies::find($request->id);
            $Fishspecies->FishCode = $request->FishCode;
            $Fishspecies->FishName = $request->FishName;
            $Fishspecies->ScName = $request->ScName;
            $Fishspecies->ShortName = $request->ShortName;
            $Fishspecies->default_weight_unit = $request->default_weight_unit;
            $Fishspecies->average_weight = $request->average_weight;
            $Fishspecies->list_index = $request->list_index;
            $Fishspecies->QRiskLevel = $request->QRiskLevel;
            $Fishspecies->currentFishSerialNo = $request->currentFishSerialNo;
            $Fishspecies->minFishSerialNo = $request->minFishSerialNo;
            $Fishspecies->maxFishSerialNo = $request->maxFishSerialNo;
            $Fishspecies->BulkMode = $request->has('BulkMode');
            $Fishspecies->enabled = $request->has('enabled');
            $Fishspecies->is_reef_fish = $request->has('is_reef_fish');
            $Fishspecies->modified_by = Auth::user()->id;
            $save = $Fishspecies->save();

            if ($request->has('img') && $save) {
                $path = Storage::putFile('private/images', new File($request->file('img')));

                $image = Fishspecies::find($Fishspecies->id);
                $image->img =  explode('/', $path)[2];
                $image->save();
            }
            if ($save) {
                return $this->responseBody(true, "save", "Fishspecies saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadFishSpecies()
    {
        try {
            $Fishspecies = Fishspecies::orderBy('id', 'ASC')
                ->where('companyId', Auth::user()->company_id)
                ->get();

            return $this->responseBody(true, "loadFishspeciess", "found", $Fishspecies);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishspeciess", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $this->deleteImage($id);
            Fishspecies::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Fishspecies Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadfishSpeciesMaster($id)
    {
        try {
            $Fishspecies = Fishspecies::where('id', $id)->first();
            return $this->responseBody(true, "User", "Fishspecies ", $Fishspecies);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadUOM()
    {
        try {
            $UOM = UOM::where('enabled', true)->get();

            return $this->responseBody(true, "loadUOM", '', $UOM);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadUOM", '', $ex->getMessage());
        }
    }
    public function deleteImage($id)
    {
        try {
            $image = Fishspecies::where('id', $id)->first()->img;
            $path = 'app/private/images/' . $image;

            if (file_exists(storage_path($path))) {
                unlink(storage_path($path));
                Fishspecies::where('id', $id)->update(['img' => null]);
            }
            return $this->responseBody(true, "deleteImage", "image Deleted", $path);
        } catch (Exception $exception) {
            return $this->responseBody(false, "deleteImage", "Something went wrong", $exception->getMessage());
        }
    }
}
