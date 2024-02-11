<?php

namespace Modules\Quality\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Quality\Entities\LabTestType;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\Currency;

class LabTestTypesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'LabTestTypeCode' => ['required'],
            'LabTestTypeName' => ['required'],
            'testCostCurrencyID' => ['required'],
        ]);
        try {
            $LabTestType = new LabTestType();
            $LabTestType->companyID = $request->CompanyID;
            $LabTestType->testTypeCode = $request->LabTestTypeCode;
            $LabTestType->testTypeName = $request->LabTestTypeName;
            $LabTestType->testTypeDescription = $request->LabTestTypeDescription;
            $LabTestType->commonRangeLow = $request->commonRangeLow;
            $LabTestType->commonRangeHigh = $request->commonRangeHigh;
            $LabTestType->testCost = $request->testCost;
            $LabTestType->testCostCurrency = $request->testCostCurrencyID;
            $LabTestType->enabled = $request->has('enabled');
            $LabTestType->created_by = Auth::user()->id;
            $save = $LabTestType->save();



            if ($save) {
                return $this->responseBody(true, "save", "LabTestType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'LabTestTypeName' => ['required'],
        ]);
        try {
            $LabTestType = LabTestType::find($request->id);
            $LabTestType->companyID = $request->CompanyID;
            $LabTestType->testTypeCode = $request->LabTestTypeCode;
            $LabTestType->testTypeName = $request->LabTestTypeName;
            $LabTestType->testTypeDescription = $request->LabTestTypeDescription;
            $LabTestType->commonRangeLow = $request->commonRangeLow;
            $LabTestType->commonRangeHigh = $request->commonRangeHigh;
            $LabTestType->testCost = $request->testCost;
            $LabTestType->testCostCurrency = $request->testCostCurrencyID;
            $LabTestType->enabled = $request->has('enabled');
            $LabTestType->modified_by = Auth::user()->id;
            $save = $LabTestType->save();

            if ($save) {
                return $this->responseBody(true, "save", "LabTestType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadLabTestTypes()
    {
        try {
            $LabTestType = LabTestType::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadLabTestTypes", "found", $LabTestType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadLabTestTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $LabTestType = LabTestType::where('id', $id)->delete();
            return $this->responseBody(true, "User", "LabTestType Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $LabTestType = LabTestType::where('id', $id)->first();
            return $this->responseBody(true, "User", "LabTestType ", $LabTestType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadLabTestType($id)
    {
        try {
            $LabTestType = LabTestType::where('id', $id)->first();
            return $this->responseBody(true, "loadLabTestType", "found", $LabTestType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadLabTestType", "error", $exception->getMessage());
        }
    }
    public function loadCompanies()
    {
        try {
            $Company = Company::where('enabled', true)->get();
            return $this->responseBody(true, "loadCompanies", "found", $Company);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCompanies", "error", $exception->getMessage());
        }
    }
    public function loadCurrencies()
    {
        try {
            $Currency = Currency::where('enabled', true)->get();
            return $this->responseBody(true, "loadCurrencies", "found", $Currency);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCurrencies", "error", $exception->getMessage());
        }
    }
}
