<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\Activity;
use Modules\Settings\Entities\Company;

class ActivityController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'ActivityName' => ['required'],
            'CompanyID' => ['required'],
        ]);
        try {
            $Activity = new Activity();
            $Activity->CompanyID = $request->CompanyID;
            $Activity->ActivityName = $request->ActivityName;
            $Activity->ActivityDescription = $request->ActivityDescription;
            $Activity->enabled = $request->has('enabled');
            $Activity->created_by = Auth::user()->id;
            $save = $Activity->save();



            if ($save) {
                return $this->responseBody(true, "save", "Activity saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'ActivityName' => ['required'],
            'CompanyID' => ['required'],
        ]);
        try {
            $Activity = Activity::find($request->id);
            $Activity->CompanyID = $request->CompanyID;
            $Activity->ActivityName = $request->ActivityName;
            $Activity->ActivityDescription = $request->ActivityDescription;
            $Activity->enabled = $request->has('enabled');
            $Activity->modified_by = Auth::user()->id;
            $save = $Activity->save();

            if ($save) {
                return $this->responseBody(true, "save", "Activity saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadActivities()
    {
        try {
            $Activity = Activity::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadActivitys", "found", $Activity);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadActivitys", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Activity = Activity::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Activity Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Activity = Activity::where('id', $id)->first();
            return $this->responseBody(true, "User", "Activity ", $Activity);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadActivity($id)
    {
        try {
            $Activity = Activity::where('id', $id)->first();
            return $this->responseBody(true, "loadActivity", "found", $Activity);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadActivity", "error", $exception->getMessage());
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

}

