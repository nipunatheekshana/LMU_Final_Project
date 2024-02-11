<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\Report;

class ReportsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'report_name' => ['required'],
            'report_description' => ['required'],
            'module' => ['required'],
            'referance' => ['required'],
        ]);
        if (Report::where('report_name', $request->report_name)->exists()) {
            $this->validationError('report_name', 'report name Exists');
        }
        if (Report::where('report_description', $request->report_description)->exists()) {
            $this->validationError('report_description', 'report id Exists');
        }
        if (Report::where('module', $request->module)->exists()) {
            $this->validationError('module', 'report port in use');
        }
        try {
            $Report = new Report();
            $Report->company_id = $request->Company;
            $Report->report_name = $request->report_name;
            $Report->report_description = $request->report_description;
            $Report->module = $request->module;
            $Report->referance = $request->referance;
            $Report->report_file_location = $request->report_file_location;
            $Report->report_type = $request->report_type;
            $Report->report_level = $request->report_level;
            $Report->enabled = $request->has('enabled');
            $Report->is_financial_report = $request->has('is_financial_report');
            $Report->created_by = Auth::user()->id;
            $save = $Report->save();



            if ($save) {
                return $this->responseBody(true, "save", "Report saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'report_name' => ['required'],
            'report_port' => ['required'],
            'model' => ['required'],
            'location' => ['required'],
        ]);
        $data = Report::where('report_name', $request->report_name);
        $data1 = Report::where('report_description', $request->report_description);
        $data2 = Report::where('module', $request->module);

        if ($data->exists()) {
            if ($data->first()->id != $request->id) {
                $this->validationError('report_name', 'report name Exists');

            }
        }
        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('report_description', 'report id Exists');

            }
        }
        if ($data2->exists()) {
            if ($data2->first()->id != $request->id) {
                $this->validationError('module', 'report port in use');

            }
        }
        try {
            $Report = Report::find($request->id);
            $Report->company_id = $request->Company;
            $Report->report_name = $request->report_name;
            $Report->report_description = $request->report_description;
            $Report->module = $request->module;
            $Report->referance = $request->referance;
            $Report->report_file_location = $request->report_file_location;
            $Report->report_type = $request->report_type;
            $Report->report_level = $request->report_level;
            $Report->enabled = $request->has('enabled');
            $Report->is_financial_report = $request->has('is_financial_report');
            $Report->modified_by = Auth::user()->id;
            $save = $Report->save();

            if ($save) {
                return $this->responseBody(true, "save", "Report saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadReports()
    {
        try {
            $Report = Report::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadReports", "found", $Report);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadReports", "Something went wrong", $ex->getMessage());
        }
    }

    public function loadReport($id)
    {
        try {
            $arr=[
                'company_id',
                'report_name',
                'report_description',
                'module',
                'referance',
                'report_file_location',
                'report_type',
                'is_financial_report',
                'report_level',
                'enabled',
            ];
            // $Report = DB::table('settings_reports')
            // // ->leftJoin('settings_companies','settings_companies.id','=','settings_reports.company_id')
            // ->select($arr)
            // ->where('settings_reports.id',$id)
            // ->first();
            $Report=Report::where('id',$id)->select($arr)->first();
            return $this->responseBody(true, "loadReport", "found", $Report);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadReport", "error", $exception->getMessage());
        }
    }
    public function loadCompany()
    {
        try {
            $Report=Company::where('enabled',true)->get();
            return $this->responseBody(true, "loadReport", "found", $Report);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadReport", "error", $exception->getMessage());
        }
    }
}
