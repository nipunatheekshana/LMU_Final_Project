<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\Company;
use Modules\Sf\Entities\Fishspecies;
use Modules\Sf\Entities\ProductQuality;

class ProductQualitiesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {

        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'FishSpecies' => ['required'],
            'QualityID' => ['required'],
            'QualityName' => ['required'],
        ]);
        if (ProductQuality::where('CompanyID', $request->CompanyID)->where('FishSpecies', $request->FishSpecies)->where('QualityID', $request->QualityID)->exists()) {
            $this->validationError('QualityID', 'QualityID Exists');
        }
        if (ProductQuality::where('CompanyID', $request->CompanyID)->where('FishSpecies', $request->FishSpecies)->where('QualityID', $request->QualityName)->exists()) {
            $this->validationError('QualityName', 'QualityName Exists');
        }
        try {
            $ProductQuality = new ProductQuality();
            $ProductQuality->CompanyID = $request->CompanyID;
            $ProductQuality->FishSpecies = $request->FishSpecies;
            $ProductQuality->QualityID = $request->QualityID;
            $ProductQuality->QualityName = $request->QualityName;
            $ProductQuality->QualityDescription = $request->QualityDescription;
            $ProductQuality->list_index = $request->list_index;
            $ProductQuality->enabled = $request->has('enabled');
            $ProductQuality->created_by = Auth::user()->id;
            $save = $ProductQuality->save();



            if ($save) {
                return $this->responseBody(true, "save", "ProductQuality saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'FishSpecies' => ['required'],
            'QualityID' => ['required'],
            'QualityName' => ['required'],
        ]);
        
        $data1 = ProductQuality::where('CompanyID', $request->CompanyID)->where('FishSpecies', $request->FishSpecies)->where('QualityID', $request->QualityID);
        $data2 = ProductQuality::where('CompanyID', $request->CompanyID)->where('FishSpecies', $request->FishSpecies)->where('QualityID', $request->QualityName);

        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('QualityID', 'QualityID Exists');
            }
        }
        if ($data2->exists()) {
            if ($data2->first()->id != $request->id) {
                $this->validationError('QualityName', 'QualityName Exists');
            }
        }
        try {
            $ProductQuality = ProductQuality::find($request->id);
            $ProductQuality->CompanyID = $request->CompanyID;
            $ProductQuality->FishSpecies = $request->FishSpecies;
            $ProductQuality->QualityID = $request->QualityID;
            $ProductQuality->QualityName = $request->QualityName;
            $ProductQuality->QualityDescription = $request->QualityDescription;
            $ProductQuality->list_index = $request->list_index;
            $ProductQuality->enabled = $request->has('enabled');
            $ProductQuality->modified_by = Auth::user()->id;
            $save = $ProductQuality->save();

            if ($save) {
                return $this->responseBody(true, "save", "ProductQuality saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadProductQualities()
    {
        try {
            $ProductQuality = ProductQuality::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadProductQualities", "found", $ProductQuality);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadProductQualities", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $ProductQuality = ProductQuality::where('id', $id)->delete();
            return $this->responseBody(true, "User", "ProductQuality Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $ProductQuality = ProductQuality::where('id', $id)->first();
            return $this->responseBody(true, "User", "ProductQuality ", $ProductQuality);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadProductQuality($id)
    {
        try {
            $ProductQuality = ProductQuality::where('id', $id)->first();
            return $this->responseBody(true, "loadProductQuality", "found", $ProductQuality);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadProductQuality", "error", $exception->getMessage());
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
    public function loadFishSpecies()
    {
        try {
            $Fishspecies = Fishspecies::where('enabled', true)->get();

            return $this->responseBody(true, "loadFishSpecies", '', $Fishspecies);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishSpecies", '', $ex->getMessage());
        }
    }
}
