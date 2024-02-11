<?php

namespace Modules\Settings\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\Printer;

class PrinterController extends Controller

{
    public function get_printers(Request $request)
    {
        try {
            $result = Printer::where('company_id', $request->company_id)
                ->where('location', $request->location);
            if ($request->has('only_enabled') && $request->only_enabled) {
                $result = $result->where('enabled', true);
            }
            $result = $result->select([
                "id",
                "printer_name",
                "location",
                "printer_port",
                "printer_id",
                "enabled",
            ])->get();
            if ($result->isEmpty()) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No Printers Found',
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'Printers Found',
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
