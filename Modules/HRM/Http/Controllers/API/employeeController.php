<?php

namespace Modules\HRM\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HRM\Entities\Employee;

class employeeController extends Controller
{
    public function get_employees(Request $request)
    {
        try {
            $query =  Employee::where('company_id', $request->company_id );



            if ($request->has('designation')) {
                $query->where('designation', $request->designation);
            }
            if ($request->has('name_like')) {
                $query->where('employee_name', 'like', '%' . $request->name_like . '%');
            }
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            if ($request->has('id')) {
                $query->where('id', $request->id);
            }

            $result = $query->get();
            $count = $result->count();

            if ($count == 0) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No employees Found',
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'employee(s) Found',
                    'data' => $result,
                ], 200);
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
}
