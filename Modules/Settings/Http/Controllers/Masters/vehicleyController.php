<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HRM\Entities\Employee;
use Modules\Settings\Entities\Vehicle;
use Modules\Settings\Entities\VehicleType;

class vehicleyController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        // $validatedData = $request->validate([
        //     'VehicleName' => ['required'],
        //     'CompanyID' => ['required'],
        // ]);
        try {
            $Vehicle = new Vehicle();
            $Vehicle->company_id = Auth::user()->company_id;
            $Vehicle->license_plate = $request->license_plate;
            $Vehicle->make = $request->make;
            $Vehicle->model = $request->model;
            $Vehicle->engine_no = $request->engine_no;
            $Vehicle->chassis_no = $request->chassis_no;
            $Vehicle->fuel_type = $request->fuel_type;
            $Vehicle->acquisition_date = $request->acquisition_date;
            $Vehicle->acquisition_value = $request->acquisition_value;
            $Vehicle->ownership = $request->ownership;
            $Vehicle->type = $request->type;
            $Vehicle->last_odometer_value = $request->last_odometer_value;
            $Vehicle->last_odometer_date_time = $request->last_odometer_date_time;
            $Vehicle->location = $request->location;
            $Vehicle->default_driver = $request->default_driver;
            $Vehicle->insuarance_policy_no = $request->insuarance_policy_no;
            $Vehicle->insuarance_company = $request->insuarance_company;
            $Vehicle->insuarance_valid_till = $request->insuarance_valid_till;
            $Vehicle->revenue_licence_no = $request->revenue_licence_no;
            $Vehicle->revenue_licence_valid_till = $request->revenue_licence_valid_till;
            $Vehicle->emission_test_no = $request->emission_test_no;
            $Vehicle->emission_test_company = $request->emission_test_company;
            $Vehicle->emission_test_valid_till = $request->emission_test_valid_till;
            $Vehicle->enabled = $request->has('enabled');
            $Vehicle->created_by = Auth::user()->id;
            $save = $Vehicle->save();



            if ($save) {
                return $this->responseBody(true, "save", "Vehicle saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        // $validatedData = $request->validate([
        //     'VehicleName' => ['required'],
        //     'CompanyID' => ['required'],
        // ]);
        try {
            $Vehicle = Vehicle::find($request->id);
            $Vehicle->license_plate = $request->license_plate;
            $Vehicle->make = $request->make;
            $Vehicle->model = $request->model;
            $Vehicle->engine_no = $request->engine_no;
            $Vehicle->chassis_no = $request->chassis_no;
            $Vehicle->fuel_type = $request->fuel_type;
            $Vehicle->acquisition_date = $request->acquisition_date;
            $Vehicle->acquisition_value = $request->acquisition_value;
            $Vehicle->ownership = $request->ownership;
            $Vehicle->type = $request->type;
            $Vehicle->last_odometer_value = $request->last_odometer_value;
            $Vehicle->last_odometer_date_time = $request->last_odometer_date_time;
            $Vehicle->location = $request->location;
            $Vehicle->default_driver = $request->default_driver;
            $Vehicle->insuarance_policy_no = $request->insuarance_policy_no;
            $Vehicle->insuarance_company = $request->insuarance_company;
            $Vehicle->insuarance_valid_till = $request->insuarance_valid_till;
            $Vehicle->revenue_licence_no = $request->revenue_licence_no;
            $Vehicle->revenue_licence_valid_till = $request->revenue_licence_valid_till;
            $Vehicle->emission_test_no = $request->emission_test_no;
            $Vehicle->emission_test_company = $request->emission_test_company;
            $Vehicle->emission_test_valid_till = $request->emission_test_valid_till;
            $Vehicle->enabled = $request->has('enabled');
            $Vehicle->modified_by = Auth::user()->id;
            $save = $Vehicle->save();

            if ($save) {
                return $this->responseBody(true, "save", "Vehicle saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadVehicles()
    {
        try {
            $Vehicle = Vehicle::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadVehicles", "found", $Vehicle);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadVehicles", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Vehicle = Vehicle::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Vehicle Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Vehicle = Vehicle::where('id', $id)->first();
            return $this->responseBody(true, "User", "Vehicle ", $Vehicle);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadVehicle($id)
    {
        try {
            $Vehicle = Vehicle::where('id', $id)->first();
            return $this->responseBody(true, "loadVehicle", "found", $Vehicle);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadVehicle", "error", $exception->getMessage());
        }
    }
    public function loadDropdownData()
    {
        try {
            $VehicleType = VehicleType::where('enabled', true)->select('id','VehicleTypeName')->get();
            $Employee = Employee::where('enabled', true)->select('id','employee_name')->get();

            return $this->responseBody(
                true,
                "loadVehicle",
                "found",
                [
                   'VehicleType'=>$VehicleType,
                   'Employee'=>$Employee,

                ]
            );
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadVehicle", "error", $exception->getMessage());
        }
    }
}
