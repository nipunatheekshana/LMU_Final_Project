<?php

namespace Modules\Settings\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\ProcessWorkstation;

class workstationController extends Controller

{
    public function get_process_workstation(Request $request)
    {
        try {
            $result =  ProcessWorkstation::where('settings_workstations.CompanyID', $request->CompanyID)
                ->join('settings_workstations', 'settings_workstations.id', '=', 'settings_process_workstations.WorkstationID')
                ->where('settings_process_workstations.ProcessID', $request->ProcessID);
            if ($request->has('only_internal') && $request->only_internal == 1) {
                $result = $result->where('settings_workstations.isInternal', true);
            }
            if ($request->has('only_enabled') && $request->only_enabled) {
                $result = $result->where('settings_workstations.enabled', true);
            }
            $result =   $result->select([
                "settings_process_workstations.id",
                "settings_workstations.WorkstationName",
                "settings_workstations.WorkstationDescription",
                "settings_workstations.isInternal",
                "settings_workstations.list_index",
                "settings_workstations.enabled",
            ])->get();

            if ($result->isEmpty()) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No Workstations Found',
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'Workstations Found',
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
