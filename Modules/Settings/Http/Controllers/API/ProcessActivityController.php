<?php

namespace Modules\Settings\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\ProcessActivityEmployeeFilter;
use Modules\Settings\Entities\ProcessActivityEmployeeTemplate;

class ProcessActivityController extends Controller
{
    public function employee_combination(Request $request)
    {
        try {
            $msg = '';
            $data = $request->data;
            usort($data, function ($a, $b) {
                return $a['activity'] - $b['activity'];
            });
            foreach ($data as &$item) {
                sort($item['employees']);
            }
            unset($item);
            $ProcessActivityEmployeeTemplate = ProcessActivityEmployeeTemplate::where('company_id', Auth::user()->company_id)->where('process', $request->process)->where('activities_employees_array', json_encode($data));
            if ($ProcessActivityEmployeeTemplate->exists()) {
                $ProcessActivityEmployeeTemplate =  $ProcessActivityEmployeeTemplate->first('id');
                $msg = 'Existing Combination Found';
            } else {
                $ProcessActivityEmployeeTemplate = new ProcessActivityEmployeeTemplate();
                $ProcessActivityEmployeeTemplate->company_id = Auth::user()->company_id;
                $ProcessActivityEmployeeTemplate->process = $request->process;
                $ProcessActivityEmployeeTemplate->activities_employees_array = json_encode($data);
                if ($ProcessActivityEmployeeTemplate->save()) {
                    $msg = 'Created New Combination';
                }
            }
            return response([
                'status' => 'Success',
                'code' => 200,
                'message' => $msg,
                'combinationid' => $ProcessActivityEmployeeTemplate->id,
            ], 200);
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}
