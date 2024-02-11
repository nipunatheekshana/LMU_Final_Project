<?php

namespace Modules\Mnu\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Mnu\Entities\WorkSheetDetail;

class WsController extends Controller
{
    public function get_ws_plans(Request $request)
    {
        try {
            $WorkSheetDetail =  WorkSheetDetail::where('company_id', $request->company_id);

            if ($request->has('is_mob_active_list')) {
                $WorkSheetDetail = $WorkSheetDetail->where('is_mob_active_list', $request->is_mob_active_list);
            }
            if ($request->has('wsfromdate') && $request->has('wstilldate')) {
                $WorkSheetDetail = $WorkSheetDetail->whereBetween('plDate', [$request->wsfromdate, $request->wstilldate]);
            }
            if ($request->has('process')) {
                $WorkSheetDetail = $WorkSheetDetail->where('process', $request->process);
            }
            if ($request->has('work_station')) {
                $WorkSheetDetail = $WorkSheetDetail->where('work_station', $request->work_station);
            }
            if ($request->has('planStatus')) {
                $WorkSheetDetail = $WorkSheetDetail->where('planStatus', $request->planStatus);
            }
            if ($request->has('id')) {
                $WorkSheetDetail = $WorkSheetDetail->where('id', $request->id);
            }
            $WorkSheetDetail = $WorkSheetDetail->get();

            if ($WorkSheetDetail->isEmpty()) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No WorkSheets found'
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'WorkSheets found',
                    'data' => $WorkSheetDetail
                ], 200);
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
    public function update_mobile_active_list(Request $request)
    {
        try {
            $update = WorkSheetDetail::where('id', $request->id)->update(['is_mob_active_list' => $request->is_mob_active_list]);
            if ($update) {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => "WS Plan Mobile Active List updated"
                ], 200);
            } else {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => "No workSheet Found"
                ], 204);
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}
