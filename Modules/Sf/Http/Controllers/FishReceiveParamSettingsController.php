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
use Modules\Quality\Entities\QualityCheckParamater;
use Modules\Settings\Entities\Company;
use Modules\Sf\Entities\FishReceiveParamSettings;
use Modules\Sf\Entities\Fishspecies;
use Modules\Sf\Entities\PresentationType;

class FishReceiveParamSettingsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'FishSpeciesID' => ['required'],
            'MinValue' => ['required'],
            'MaxVal' => ['required'],
            'DefaultVal' => ['required'],
            'FishPrasentationID' => ['required'],
            'QParamID' => ['required'],
            'paramName' => ['required'],
        ]);
        $exists=FishReceiveParamSettings::where('CompanyID',$request->CompanyID)
                                ->where('FishSpeciesID',$request->FishSpeciesID)
                                ->where('FishPrasentationID',$request->FishPrasentationID)
                                ->where('QParamID',$request->QParamID)
                                ->exists();
        if($exists){
            $this->validationError('QParameterId', 'Quality parameter exists');
        }
        try {
            $FishReceiveParamSettings = new FishReceiveParamSettings();
            $FishReceiveParamSettings->CompanyID = $request->CompanyID;
            $FishReceiveParamSettings->paramName = $request->paramName;
            $FishReceiveParamSettings->FishSpeciesID = $request->FishSpeciesID;
            $FishReceiveParamSettings->QParamID = $request->QParamID;
            $FishReceiveParamSettings->MinValue = $request->MinValue;
            $FishReceiveParamSettings->MaxVal = $request->MaxVal;
            $FishReceiveParamSettings->DefaultVal = $request->DefaultVal;
            $FishReceiveParamSettings->list_index = $request->list_index;
            $FishReceiveParamSettings->FishPrasentationID = $request->FishPrasentationID;
            $FishReceiveParamSettings->enabled = $request->has('enabled');
            $FishReceiveParamSettings->created_by = Auth::user()->id;
            $save = $FishReceiveParamSettings->save();
            if ($save) {
                return $this->responseBody(true, "save", "FishReceiveParamSettings saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'FishSpeciesID' => ['required'],
            'MinValue' => ['required'],
            'MaxVal' => ['required'],
            'DefaultVal' => ['required'],
            'FishPrasentationID' => ['required'],
            'QParamID' => ['required'],
            'paramName' => ['required'],

        ]);
        try {
            $FishReceiveParamSettings = FishReceiveParamSettings::find($request->id);
            $FishReceiveParamSettings->CompanyID = $request->CompanyID;
            $FishReceiveParamSettings->paramName = $request->paramName;
            $FishReceiveParamSettings->FishSpeciesID = $request->FishSpeciesID;
            $FishReceiveParamSettings->QParamID = $request->QParamID;
            $FishReceiveParamSettings->MinValue = $request->MinValue;
            $FishReceiveParamSettings->MaxVal = $request->MaxVal;
            $FishReceiveParamSettings->DefaultVal = $request->DefaultVal;
            $FishReceiveParamSettings->list_index = $request->list_index;
            $FishReceiveParamSettings->FishPrasentationID = $request->FishPrasentationID;
            $FishReceiveParamSettings->enabled = $request->has('enabled');
            $FishReceiveParamSettings->modified_by = Auth::user()->id;
            $save = $FishReceiveParamSettings->save();

            if ($save) {
                return $this->responseBody(true, "save", "FishReceiveParamSettings saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadfishReceiveParamSettings()
    {
        try {
            $FishReceiveParamSettings = FishReceiveParamSettings::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadFishReceiveParamSettingss", "found", $FishReceiveParamSettings);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishReceiveParamSettingss", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $FishReceiveParamSettings = FishReceiveParamSettings::where('id', $id)->delete();
            return $this->responseBody(true, "User", "FishReceiveParamSettings Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $FishReceiveParamSettings = FishReceiveParamSettings::where('id', $id)->first();
            return $this->responseBody(true, "User", "FishReceiveParamSettings ", $FishReceiveParamSettings);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadfishReceiveParamSetting($id)
    {
        try {
            $FishReceiveParamSettings = FishReceiveParamSettings::where('id', $id)->first();
            return $this->responseBody(true, "loadFishReceiveParamSettings", "found", $FishReceiveParamSettings);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadFishReceiveParamSettings", "error", $exception->getMessage());
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
    public function loadCompanies()
    {
        try {
            $Company = Company::where('enabled', true)->get();

            return $this->responseBody(true, "loadCompanies", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCompanies", '', $ex->getMessage());
        }
    }
    public function loadQParamID()
    {
        try {
            $QualityCheckParamater = QualityCheckParamater::where('enabled', true)->get();

            return $this->responseBody(true, "loadQParamID", '', $QualityCheckParamater);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadQParamID", '', $ex->getMessage());
        }
    }
    public function loadFishPrasentation()
    {
        try {
            $PresentationType = PresentationType::where('enabled', true)->get();

            return $this->responseBody(true, "loadFishPrasentation", '', $PresentationType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishPrasentation", '', $ex->getMessage());
        }
    }
    public function loadMinMaxValue($id)
    {
        try {
            $QualityCheckParamater = QualityCheckParamater::where('id', $id)->select('MinValue','MaxValue')->first();

            return $this->responseBody(true, "loadMinMaxValue", '', $QualityCheckParamater);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadMinMaxValue", '', $ex->getMessage());
        }
    }
    public function loadRelatedParam(Request $request)
    {
        try {
            // $FishReceiveParamSettings = FishReceiveParamSettings::Where('CompanyID',$request->CompanyID)
            // ->where('FishSpeciesID',$request->FishSpeciesID)
            // ->where('FishPrasentationID',$request->FishPrasentationID)
            // ->orderBy('id','ASC')
            // ->get()
            $FishReceiveParamSettings = DB::table('sf_fish_receive_param_settings')
                                        ->join('quality_qualitycheck_paramaters','sf_fish_receive_param_settings.QParamID','=','quality_qualitycheck_paramaters.id')
                                        ->Where('sf_fish_receive_param_settings.CompanyID',$request->CompanyID)
                                        ->where('sf_fish_receive_param_settings.FishSpeciesID',$request->FishSpeciesID)
                                        ->where('sf_fish_receive_param_settings.FishPrasentationID',$request->FishPrasentationID)
                                        ->select('sf_fish_receive_param_settings.*','quality_qualitycheck_paramaters.QParamName')
                                        ->get();

            return $this->responseBody(true, "loadRelatedParam", "found", $FishReceiveParamSettings);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadRelatedParam", "Something went wrong", $ex->getMessage());
        }
    }

}

