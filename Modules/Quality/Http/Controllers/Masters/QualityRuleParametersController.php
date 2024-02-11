<?php

namespace Modules\Quality\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Quality\Entities\QualityCheckingRule;
use Modules\Quality\Entities\QualityCheckParamater;
use Modules\Quality\Entities\QualityRuleParameter;

class QualityRuleParametersController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'QualityRuleID' => ['required'],
            'QParameterId' => ['required'],
            'QParamName' => ['required'],
            'MinValue' => ['required'],
            'MaxValue' => ['required'],
            'DefaultValue' => ['required'],

        ]);
        $exists=QualityRuleParameter::where('QualityRuleID',$request->QualityRuleID)
                                ->where('QParameterId',$request->QParameterId)
                                ->exists();
        if($exists){
            $this->validationError('QParameterId', 'Quality parameter exists');
        }
        try {
            $QualityRuleParameter = new QualityRuleParameter();
            $QualityRuleParameter->QualityRuleID = $request->QualityRuleID;
            $QualityRuleParameter->QParameterId = $request->QParameterId;
            $QualityRuleParameter->QParamName = $request->QParamName;
            $QualityRuleParameter->QParamDescription = $request->QParamDescription;
            $QualityRuleParameter->MinValue = $request->MinValue;
            $QualityRuleParameter->MaxValue = $request->MaxValue;
            $QualityRuleParameter->DefaultValue = $request->DefaultValue;
            $QualityRuleParameter->status_value_comment = $request->status_value_comment;
            $QualityRuleParameter->list_index = $request->list_index;
            $QualityRuleParameter->is_status_value_required = $request->has('is_status_value_required');
            $QualityRuleParameter->is_status_value_number = $request->has('is_status_value_number');
            $QualityRuleParameter->enabled = $request->has('enabled');
            $QualityRuleParameter->created_by = Auth::user()->id;
            $save = $QualityRuleParameter->save();
            if ($save) {
                return $this->responseBody(true, "save", "QualityRuleParameter saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'QualityRuleID' => ['required'],
            'QParameterId' => ['required'],
            'QParamName' => ['required'],
            'MinValue' => ['required'],
            'MaxValue' => ['required'],
            'DefaultValue' => ['required'],

        ]);
        try {
            $QualityRuleParameter = QualityRuleParameter::find($request->id);
            $QualityRuleParameter->QualityRuleID = $request->QualityRuleID;
            $QualityRuleParameter->QParameterId = $request->QParameterId;
            $QualityRuleParameter->QParamName = $request->QParamName;
            $QualityRuleParameter->QParamDescription = $request->QParamDescription;
            $QualityRuleParameter->MinValue = $request->MinValue;
            $QualityRuleParameter->MaxValue = $request->MaxValue;
            $QualityRuleParameter->DefaultValue = $request->DefaultValue;
            $QualityRuleParameter->status_value_comment = $request->status_value_comment;
            $QualityRuleParameter->list_index = $request->list_index;
            $QualityRuleParameter->is_status_value_required = $request->has('is_status_value_required');
            $QualityRuleParameter->is_status_value_number = $request->has('is_status_value_number');
            $QualityRuleParameter->enabled = $request->has('enabled');
            $QualityRuleParameter->modified_by = Auth::user()->id;
            $save = $QualityRuleParameter->save();

            if ($save) {
                return $this->responseBody(true, "save", "QualityRuleParameter saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadQualityRuleParameters()
    {
        try {
            $QualityRuleParameter = QualityRuleParameter::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadQualityRuleParameters", "found", $QualityRuleParameter);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadQualityRuleParameters", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $QualityRuleParameter = QualityRuleParameter::where('id', $id)->delete();
            return $this->responseBody(true, "User", "QualityRuleParameter Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $QualityRuleParameter = QualityRuleParameter::where('id', $id)->first();
            return $this->responseBody(true, "User", "QualityRuleParameter ", $QualityRuleParameter);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadQualityRuleParameter($id)
    {
        try {
            $QualityRuleParameter = QualityRuleParameter::where('id', $id)->first();
            return $this->responseBody(true, "loadQualityRuleParameter", "found", $QualityRuleParameter);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadQualityRuleParameter", "error", $exception->getMessage());
        }
    }

    public function loadQParameterId()
    {
        try {
            $QualityCheckParamater = QualityCheckParamater::where('enabled', true)->get();

            return $this->responseBody(true, "loadQParameterId", '', $QualityCheckParamater);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadQParameterId", '', $ex->getMessage());
        }
    }
    public function loadQualityRuleID()
    {
        try {
            $QualityCheckingRule = QualityCheckingRule::where('enabled', true)->get();

            return $this->responseBody(true, "loadQualityRuleID", '', $QualityCheckingRule);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadQualityRuleID", '', $ex->getMessage());
        }
    }

    public function loadMinMaxValue($id)
    {
        try {
            $QualityCheckParamater = QualityCheckParamater::where('id', $id)->select('MinValue', 'MaxValue', 'QParamName')->first();

            return $this->responseBody(true, "loadMinMaxValue", '', $QualityCheckParamater);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadMinMaxValue", '', $ex->getMessage());
        }
    }
    public function loadRelatedParam(Request $request)
    {
        try {

            $QualityRuleParameter = DB::table('quality_qc_rule_parameters')
                ->join('quality_qualitycheck_paramaters', 'quality_qc_rule_parameters.QParameterId', '=', 'quality_qualitycheck_paramaters.id')
                ->Where('quality_qc_rule_parameters.QualityRuleID', $request->QualityRuleID)
                ->select('quality_qc_rule_parameters.*', 'quality_qualitycheck_paramaters.QParamName as qparameter')
                ->get();

            return $this->responseBody(true, "loadRelatedParam", "found", $QualityRuleParameter);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadRelatedParam", "Something went wrong", $ex->getMessage());
        }
    }
}
