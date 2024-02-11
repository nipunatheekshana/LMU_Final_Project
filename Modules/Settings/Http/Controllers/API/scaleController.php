<?php

namespace Modules\Settings\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\Scale;

class scaleController extends Controller
{
    public function get_scales(Request $request)
    {
        try {
            $result = Scale::where('company_id', $request->company_id)
                ->where('location', $request->location);
            if ($request->has('only_enabled') && $request->only_enabled) {
                $result = $result->where('enabled', true);
            }
            $result = $result->select([
                "id",
                "scale_name",
                "location",
                "scale_port",
                "scale_id",
                "enabled",
            ])->get();
            if ($result->isEmpty()) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No scales Found',
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'scales Found',
                    'data' => $result,
                ], 200);
            }

            return $result;
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
}
