<?php

namespace Modules\HRM\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HRM\Entities\Department;

class DepartmentController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'departmentCode' => ['required'],
            'depratmentName' => ['required'],
        ]);
        if (Department::where('departmentCode', $request->departmentCode)->exists()) {
            $this->validationError('departmentCode', 'departmentCode Exists');
        }
        if (Department::where('depratmentName', $request->depratmentName)->exists()) {
            $this->validationError('depratmentName', 'depratmentName Exists');
        }
        try {
            $Department = new Department();
            $Department->departmentCode = $request->departmentCode;
            $Department->depratmentName = $request->depratmentName;
            $Department->parent_department = $request->parent_department;
            $Department->is_parent = $request->has('is_parent');
            $Department->enabled = $request->has('enabled');
            $Department->created_by = Auth::user()->id;
            $save = $Department->save();



            if ($save) {
                return $this->responseBody(true, "save", "Department saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'departmentCode' => ['required'],
            'depratmentName' => ['required'],
        ]);
        $data1 = Department::where('departmentCode', $request->departmentCode);
        $data2 = Department::where('depratmentName', $request->depratmentName);

        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('departmentCode', 'departmentCode Exists');
            }
        }
        if ($data2->exists()) {
            if ($data2->first()->id != $request->id) {
                $this->validationError('depratmentName', 'depratmentName Exists');
            }
        }
        if($request->id == $request->parent_department){
            $this->validationError('parent_department', 'Department Cant be Its own Parent');
        }
        try {
            $Department = Department::find($request->id);
            $Department->departmentCode = $request->departmentCode;
            $Department->depratmentName = $request->depratmentName;
            $Department->parent_department = $request->parent_department;
            $Department->is_parent = $request->has('is_parent');
            $Department->enabled = $request->has('enabled');
            $Department->modified_by = Auth::user()->id;
            $save = $Department->save();

            if ($save) {
                return $this->responseBody(true, "save", "Department saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadDepartments()
    {
        try {
            $Department = Department::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadDepartments", "found", $Department);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDepartments", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Department = Department::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Department Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadDepartment($id)
    {
        try {
            $Department = Department::where('id', $id)->first();
            return $this->responseBody(true, "loadDepartment", "found", $Department);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadDepartment", "error", $exception->getMessage());
        }
    }
    public function loadParentDepartments()
    {
        try {
            $Department = Department::where('is_parent', true)->get();

            return $this->responseBody(true, "loadParentDepartments", '', $Department);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadParentDepartments", '', $ex->getMessage());
        }
    }
}
