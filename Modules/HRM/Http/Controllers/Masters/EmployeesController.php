<?php

namespace Modules\HRM\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\HRM\Entities\Department;
use Modules\HRM\Entities\Designation;
use Modules\HRM\Entities\Employee;
use Modules\HRM\Entities\Gender;
use Modules\HRM\Entities\Salutation;
use Modules\HRM\Entities\Status;
use Modules\Settings\Entities\Company;

class EmployeesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'salutation' => ['required'],
            'company' => ['required'],
            'national_id_card_number' => ['required'],
            'date_of_birth' => ['required'],
            'last_name' => ['required'],
            'first_name' => ['required'],
            'designation' => ['required'],

        ]);
        $employeeName = '';

        if (!$request->employee_name == null) {
            $employeeName = $request->employee_name;
        } elseif (!$request->middle_name == null) {
            $employeeName = $request->first_name . $request->middle_name . $request->last_name;
        } else {
            $employeeName = $request->first_name . $request->last_name;
        }
        if (Employee::where('employee_name', $employeeName)->where('company', $request->company)->exists()) {
            $this->validationError('employee_name', 'employee name exists');
        }

        try {


            $Employee = new Employee();
            $Employee->salutation = $request->salutation;
            $Employee->middle_name = $request->middle_name;
            $Employee->last_name = $request->last_name;
            $Employee->first_name = $request->first_name;
            $Employee->employee_name = $employeeName;
            $Employee->gender = $request->gender;
            $Employee->company = $request->company;
            $Employee->department = $request->department;
            $Employee->designation = $request->designation;
            $Employee->national_id_card_number = $request->national_id_card_number;
            $Employee->date_of_birth = $request->date_of_birth;
            $Employee->image = $request->image;
            $Employee->status = $request->status;

            $Employee->list_index = $request->list_index;
            $Employee->enabled = $request->has('enabled');
            $Employee->created_by = Auth::user()->id;
            $save = $Employee->save();

            if ($request->has('image') && $save) {

                $const = '-Employee_image';
                $imagename = $Employee->id . $const; //new image name
                $guessExtension = $request->file('image')->guessExtension(); //file extention
                $file = $request->file('image')->storeAs('Employee_images/' . $Employee->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/Employee_images/' . $Employee->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Employee::find($Employee->id);
                $image->image = $url;
                $image->save();
            }

            if ($save) {
                return $this->responseBody(true, "save", "Employee saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'salutation' => ['required'],
            'company' => ['required'],
            'national_id_card_number' => ['required'],
            'date_of_birth' => ['required'],
            'last_name' => ['required'],
            'first_name' => ['required'],
            'designation' => ['required'],
        ]);
        $employeeName = '';

        if (!$request->employee_name == null) {
            $employeeName = $request->employee_name;
        } elseif (!$request->middle_name == null) {
            $employeeName = $request->first_name . $request->middle_name . $request->last_name;
        } else {
            $employeeName = $request->first_name . $request->last_name;
        }
        if (Employee::where('employee_name', $employeeName)->where('company', $request->company)->exists()) {

            if (Employee::where('employee_name', $employeeName)->where('company', $request->company)->first()->id != $request->id) {
                $this->validationError('employee_name', 'employee name exists');
            }
        }
        try {
            $Employee = Employee::find($request->id);
            $Employee->salutation = $request->salutation;
            $Employee->middle_name = $request->middle_name;
            $Employee->last_name = $request->last_name;
            $Employee->first_name = $request->first_name;
            $Employee->employee_name = $employeeName;
            $Employee->gender = $request->gender;
            $Employee->company = $request->company;
            $Employee->department = $request->department;
            $Employee->designation = $request->designation;
            $Employee->national_id_card_number = $request->national_id_card_number;
            $Employee->date_of_birth = $request->date_of_birth;
            $Employee->image = $request->image;
            $Employee->status = $request->status;

            $Employee->list_index = $request->list_index;
            $Employee->enabled = $request->has('enabled');
            $Employee->modified_by = Auth::user()->id;
            $save = $Employee->save();

            if ($request->has('image') && $save) {

                $const = '-Employee_image';
                $imagename = $Employee->id . $const; //new image name
                $guessExtension = $request->file('image')->guessExtension(); //file extention
                $file = $request->file('image')->storeAs('Employee_images/' . $Employee->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/Employee_images/' . $Employee->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Employee::find($Employee->id);
                $image->image = $url;
                $image->save();
            }

            if ($save) {
                return $this->responseBody(true, "save", "Employee saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadEmployees()
    {
        try {
            // $Employee = Employee::orderBy('id', 'ASC')
            //     ->get();
            $Employee = DB::table('hrm_employees')
                ->leftJoin('hrm_designations', 'hrm_designations.id', '=', 'hrm_employees.designation')
                ->select('hrm_employees.id', 'hrm_employees.employee_name', 'hrm_designations.DesignationName')
                ->orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadEmployees", "found", $Employee);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadEmployees", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $image = Employee::where('id', $id)->first()->image;
            if (file_exists($image)) {
                unlink($image);
            }
            $Employee = Employee::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Employee Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Employee = Employee::where('id', $id)->first();
            return $this->responseBody(true, "User", "Employee ", $Employee);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadEmployee($id)
    {
        try {
            $Employee = Employee::where('id', $id)->first();
            return $this->responseBody(true, "loadEmployee", "found", $Employee);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadEmployee", "error", $exception->getMessage());
        }
    }
    public function loadSalutaions()
    {
        try {
            $Salutation = Salutation::where('enabled', true)->get();

            return $this->responseBody(true, "loadSalutaions", '', $Salutation);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSalutaions", '', $ex->getMessage());
        }
    }
    public function loadGenders()
    {
        try {
            $Gender = Gender::where('enabled', true)->get();

            return $this->responseBody(true, "loadGenders", '', $Gender);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadGenders", '', $ex->getMessage());
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
    public function loadDesignations()
    {
        try {
            $Designation = Designation::where('enabled', true)->get();

            return $this->responseBody(true, "loadDesignations", '', $Designation);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDesignations", '', $ex->getMessage());
        }
    }
    public function loadDepartments()
    {
        try {
            $Department = Department::where('enabled', true)->get();

            return $this->responseBody(true, "loadDepartments", '', $Department);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDepartments", '', $ex->getMessage());
        }
    }
    public function loadStatus()
    {
        try {
            $Status = Status::where('enabled', true)->get();

            return $this->responseBody(true, "loadStatus", '', $Status);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadStatus", '', $ex->getMessage());
        }
    }
}
