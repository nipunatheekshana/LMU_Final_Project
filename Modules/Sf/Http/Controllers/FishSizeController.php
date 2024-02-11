<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Settings\Entities\Company;
use Modules\Sf\Entities\FishSize;
use Modules\Sf\Entities\Fishspecies;

class FishSizeController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyId' => ['required'],
            'FishSpeciesId' => ['required'],
            'minValue' => ['required'],
            'maxValue' => ['required'],
            'SizeCode' => ['required'],
        ]);
        if (FishSize::where('enabled', true)->where('CompanyId',  $request->CompanyId)->where('FishSpeciesId', $request->FishSpeciesId)->where('SizeCode', $request->SizeCode)->exists()) {
            $this->validationError('SizeCode', 'Size Code exists');
        }
        try {
            $oldRecord = FishSize::where('CompanyId', $request->CompanyId)
                ->where('FishSpeciesId', $request->FishSpeciesId)
                ->where('SizeCode', $request->SizeCode)
                ->first();
            if ($oldRecord) {
                $FishSize = FishSize::find($oldRecord->id);
                $FishSize->enabled = true;
                $FishSize->modified_by = Auth::user()->id;
                $save = $FishSize->save();
            } else {

                $FishSize = new FishSize();
                $FishSize->CompanyId = $request->CompanyId;
                $FishSize->FishSpeciesId = $request->FishSpeciesId;
                $FishSize->minValue = $request->minValue;
                $FishSize->maxValue = $request->maxValue;
                $FishSize->SizeCode = $request->SizeCode;
                $FishSize->SizeDescription = $request->SizeDescription;
                $FishSize->list_index = $request->list_index;
                $FishSize->enabled = $request->has('enabled');
                $FishSize->created_by = Auth::user()->id;
                $save = $FishSize->save();
            }




            if ($save) {
                return $this->responseBody(true, "save", "FishSize saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyId' => ['required'],
            'FishSpeciesId' => ['required'],
            'minValue' => ['required'],
            'maxValue' => ['required'],
            'SizeCode' => ['required'],
        ]);
        try {
            $FishSize = FishSize::find($request->id);
            $FishSize->CompanyId = $request->CompanyId;
            $FishSize->FishSpeciesId = $request->FishSpeciesId;
            $FishSize->minValue = $request->minValue;
            $FishSize->maxValue = $request->maxValue;
            $FishSize->SizeCode = $request->SizeCode;
            $FishSize->SizeDescription = $request->SizeDescription;
            $FishSize->list_index = $request->list_index;
            $FishSize->enabled = $request->has('enabled');
            $FishSize->modified_by = Auth::user()->id;
            $save = $FishSize->save();

            if ($save) {
                return $this->responseBody(true, "save", "FishSize saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadFishSizes()
    {
        try {
            // $FishSize = FishSize::orderBy('id','ASC')->get();
            $FishSize = DB::table('sf_fish_size_matrix')
                ->join('sf_fish_species', 'sf_fish_species.id', '=', 'sf_fish_size_matrix.FishSpeciesId')
                ->where('sf_fish_size_matrix.enabled', true)
                ->select('sf_fish_size_matrix.*', 'sf_fish_species.FishName')
                ->orderBy('minValue', 'ASC')
                ->get();

            return $this->responseBody(true, "loadFishSizes", "found", $FishSize);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishSizes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $maxValue = FishSize::where('id', $id)->select('CompanyId', 'FishSpeciesId')->first();
            $compid = $maxValue->CompanyId;
            $fishSPid = $maxValue->FishSpeciesId;

            $maxID = FishSize::where('enabled', true)
                ->where('CompanyId', $compid)
                ->where('FishSpeciesId', $fishSPid)
                ->orderBy('id', 'desc')
                ->first()->id;

            if ($maxID == $id) {
                $FishSize = FishSize::find($id);
                $FishSize->enabled = false;
                $FishSize->save();

                return $this->responseBody(true, "User", "FishSize Deleted", null);
            } else {
                return $this->responseBody(false, "User", "Delete Last item first", '');
            }

            return $this->responseBody(true, "User", "FishSize Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $FishSize = FishSize::where('id', $id)->first();
            return $this->responseBody(true, "User", "FishSize ", $FishSize);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadFishSize($id)
    {
        try {
            $FishSize = FishSize::where('id', $id)->first();
            return $this->responseBody(true, "loadFishSize", "found", $FishSize);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadFishSize", "error", $exception->getMessage());
        }
    }
    public function loadCompanies()
    {
        try {
            $Company = Company::where('enabled', true)->get();

            return $this->responseBody(true, "loadCompanies", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCompanies", '', $ex->getMessage());
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
    public function getNewMinValue($compid, $fishSPid)
    {
        try {
            $maxValue = FishSize::where('CompanyId', $compid)
                ->where('FishSpeciesId', $fishSPid)
                ->where('enabled', true)
                ->orderBy('id', 'desc')
                ->first();
            if (!$maxValue) {
                $maxValue = 0.01;
            } else {
                $maxValue = $maxValue->maxValue;
            }
            return $this->responseBody(true, "getNewMinValue", '', $maxValue);
        } catch (Exception $ex) {
            return $this->responseBody(false, "getNewMinValue", '', $ex->getMessage());
        }
    }
    public function loadRelatedFishSizes($compid, $fishSPid)
    {
        try {
            $FishSize = FishSize::where('enabled', true)
                ->where('CompanyId', $compid)
                ->where('FishSpeciesId', $fishSPid)
                ->orderBy('minValue', 'ASC')
                ->get();



            return $this->responseBody(true, "loadFishSizes", "found", $FishSize);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishSizes", "Something went wrong", $ex->getMessage());
        }
    }
}
