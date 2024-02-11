<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\HRM\Entities\Employee;
use Modules\Settings\Entities\Activity;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\ProcessActivityEmployeeFilter;

class ProcessActEmpFiltersController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'ActivityID' => ['required'],
            'EmpID' => ['required'],
            'CompanyID' => ['required'],

        ]);
        try {
            $ProcessActivityEmployeeFilter = new ProcessActivityEmployeeFilter();
            $ProcessActivityEmployeeFilter->ActivityID = $request->ActivityID;
            $ProcessActivityEmployeeFilter->EmpID = $request->EmpID;
            $ProcessActivityEmployeeFilter->CompanyID = $request->CompanyID;
            $ProcessActivityEmployeeFilter->list_index = $request->list_index;
            $ProcessActivityEmployeeFilter->enabled = $request->has('enabled');
            $ProcessActivityEmployeeFilter->created_by = Auth::user()->id;
            $save = $ProcessActivityEmployeeFilter->save();



            if ($save) {
                return $this->responseBody(true, "save", "ProcessActivityEmployeeFilter saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'ActivityID' => ['required'],
            'EmpID' => ['required'],
            'CompanyID' => ['required'],
        ]);
        try {
            $ProcessActivityEmployeeFilter = ProcessActivityEmployeeFilter::find($request->id);
            $ProcessActivityEmployeeFilter->ActivityID = $request->ActivityID;
            $ProcessActivityEmployeeFilter->EmpID = $request->EmpID;
            $ProcessActivityEmployeeFilter->CompanyID = $request->CompanyID;
            $ProcessActivityEmployeeFilter->list_index = $request->list_index;
            $ProcessActivityEmployeeFilter->enabled = $request->has('enabled');
            $ProcessActivityEmployeeFilter->modified_by = Auth::user()->id;
            $save = $ProcessActivityEmployeeFilter->save();

            if ($save) {
                return $this->responseBody(true, "save", "ProcessActivityEmployeeFilter saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadProcessActivityEmployeeFilters()
    {
        try {
            // $ProcessActivityEmployeeFilter = ProcessActivityEmployeeFilter::orderBy('id','ASC')
            // ->get();
            $ProcessActivityEmployeeFilter = DB::table('settings_process_activity_employee_filters')
                                            ->join('settings_activities','settings_activities.id','=','settings_process_activity_employee_filters.ActivityID')
                                            ->join('hrm_employees','hrm_employees.id','=','settings_process_activity_employee_filters.EmpID')
                                            ->select('settings_process_activity_employee_filters.id','settings_activities.ActivityName','hrm_employees.employee_name')
                                            ->orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadProcessActivityEmployeeFilters", "found", $ProcessActivityEmployeeFilter);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadProcessActivityEmployeeFilters", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $ProcessActivityEmployeeFilter = ProcessActivityEmployeeFilter::where('id', $id)->delete();
            return $this->responseBody(true, "User", "ProcessActivityEmployeeFilter Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $ProcessActivityEmployeeFilter = ProcessActivityEmployeeFilter::where('id', $id)->first();
            return $this->responseBody(true, "User", "ProcessActivityEmployeeFilter ", $ProcessActivityEmployeeFilter);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadProcessActivityEmployeeFilter($id)
    {
        try {

            $ProcessActivityEmployeeFilter = ProcessActivityEmployeeFilter::where('id', $id)->first();
            return $this->responseBody(true, "loadProcessActivityEmployeeFilter", "found", $ProcessActivityEmployeeFilter);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadProcessActivityEmployeeFilter", "error", $exception->getMessage());
        }
    }
    public function loadActivities()
    {
        try {
            $Activity = Activity::where('enabled',true)->get();

            return $this->responseBody(true, "loadActivities", '', $Activity);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadActivities", '', $ex->getMessage());
        }
    }
    public function loadEmployees()
    {
        try {
            $Employee = Employee::where('enabled',true)->get();

            return $this->responseBody(true, "loadEmployees", '', $Employee);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadEmployees", '', $ex->getMessage());
        }
    }
    public function loadCompanies()
    {
        try {
            $Company = Company::where('enabled',true)->get();

            return $this->responseBody(true, "loadCompanies", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCompanies", '', $ex->getMessage());
        }
    }
}
