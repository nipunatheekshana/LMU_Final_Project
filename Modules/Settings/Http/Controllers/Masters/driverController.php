<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HRM\Entities\Employee;
use Modules\Settings\Entities\Driver;

class driverController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => ['required'],
        ]);
        try {
            $Driver = new Driver();
            $Driver->company_id = Auth::user()->company_id;
            $Driver->employee = $request->employee;
            $Driver->full_name = $request->full_name;
            $Driver->address = $request->address;
            $Driver->company = $request->company;
            $Driver->contact_no = $request->contact_no;
            $Driver->licence_no = $request->licence_no;
            $Driver->issued_date = $request->issued_date;
            $Driver->expire_date = $request->expire_date;
            $Driver->enabled = $request->has('enabled');
            $Driver->created_by = Auth::user()->id;
            $save = $Driver->save();



            if ($save) {
                return $this->responseBody(true, "save", "Driver saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => ['required'],

        ]);
        try {
            $Driver = Driver::find($request->id);
            $Driver->company_id = Auth::user()->company_id;
            $Driver->employee = $request->employee;
            $Driver->full_name = $request->full_name;
            $Driver->address = $request->address;
            $Driver->company = $request->company;
            $Driver->contact_no = $request->contact_no;
            $Driver->licence_no = $request->licence_no;
            $Driver->issued_date = $request->issued_date;
            $Driver->expire_date = $request->expire_date;
            $Driver->enabled = $request->has('enabled');
            $Driver->modified_by = Auth::user()->id;
            $save = $Driver->save();

            if ($save) {
                return $this->responseBody(true, "save", "Driver saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadDrivers()
    {
        try {
            $Driver = Driver::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadDrivers", "found", $Driver);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDrivers", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Driver = Driver::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Driver Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Driver = Driver::where('id', $id)->first();
            return $this->responseBody(true, "User", "Driver ", $Driver);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadDriver($id)
    {
        try {
            $Driver = Driver::where('id', $id)->first();
            return $this->responseBody(true, "loadDriver", "found", $Driver);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadDriver", "error", $exception->getMessage());
        }
    }
    public function loadDropdownData()
    {
        try {
            $Company = Employee::where('enabled',true)->select('employee_name','id')->get();

            return $this->responseBody(true, "loadDropdownData", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDropdownData", '', $ex->getMessage());
        }
    }

}
