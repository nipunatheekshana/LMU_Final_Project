<?php

namespace Modules\Quality\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Quality\Entities\QualityCheckingRule;
use Modules\Settings\Entities\Company;

class QualityCheckingRulesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'QualityRuleName' => ['required'],
        ]);
        try {
            $QualityCheckingRule = new QualityCheckingRule();
            $QualityCheckingRule->CompanyID = $request->CompanyID;
            $QualityCheckingRule->QualityRuleName = $request->QualityRuleName;
            $QualityCheckingRule->QualityRuleDescription = $request->QualityRuleDescription;
            $QualityCheckingRule->enabled = $request->has('enabled');
            $QualityCheckingRule->created_by = Auth::user()->id;
            $save = $QualityCheckingRule->save();



            if ($save) {
                return $this->responseBody(true, "save", "QualityCheckingRule saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'QualityRuleName' => ['required'],
        ]);
        try {
            $QualityCheckingRule = QualityCheckingRule::find($request->id);
            $QualityCheckingRule->CompanyID = $request->CompanyID;
            $QualityCheckingRule->QualityRuleName = $request->QualityRuleName;
            $QualityCheckingRule->QualityRuleDescription = $request->QualityRuleDescription;
            $QualityCheckingRule->enabled = $request->has('enabled');
            $QualityCheckingRule->modified_by = Auth::user()->id;
            $save = $QualityCheckingRule->save();

            if ($save) {
                return $this->responseBody(true, "save", "QualityCheckingRule saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadQualityCheckingRules()
    {
        try {
            $QualityCheckingRule = QualityCheckingRule::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadQualityCheckingRules", "found", $QualityCheckingRule);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadQualityCheckingRules", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $QualityCheckingRule = QualityCheckingRule::where('id', $id)->delete();
            return $this->responseBody(true, "User", "QualityCheckingRule Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $QualityCheckingRule = QualityCheckingRule::where('id', $id)->first();
            return $this->responseBody(true, "User", "QualityCheckingRule ", $QualityCheckingRule);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadQualityCheckingRule($id)
    {
        try {
            $QualityCheckingRule = QualityCheckingRule::where('id', $id)->first();
            return $this->responseBody(true, "loadQualityCheckingRule", "found", $QualityCheckingRule);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadQualityCheckingRule", "error", $exception->getMessage());
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
}
