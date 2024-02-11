<?php

namespace Modules\Buying\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Buying\Entities\GRN;
use Modules\Buying\Entities\GRNDetail;
use Illuminate\Support\Facades\Log;

class GrnController extends Controller

{
    public function get_grn_hd_list(Request $request)
    {
        try {
            $query =  GRN::where('company_id', $request->company_id);

            if ($request->has('grntilldate')) {
                $query->whereBetween('grndate', [$request->grnfromdate, $request->grntilldate]);
            } else {
                $query->whereBetween('grndate', [$request->grnfromdate, $request->grnfromdate]);
            }

            if ($request->has('supplier_id')) {
                $query->where('supplier_id', $request->supplier_id);
            }
            if ($request->has('grn_type')) {
                $query->where('grn_type', $request->grn_type);
            }
            if ($request->has('grn_type')) {
                $query->where('grn_type', $request->grn_type);
            }

            $result = $query->get();
            $count = $result->count();

            if ($count == 0) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No GRNs Found',
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'GRNs Found',
                    'count' => $count,
                    'data' => $result,
                ], 200);
            }
        } catch (Exception $ex) {
            Log::channel('api')->error('API : get_grn_hd_list | Message : ' . $ex->getMessage());
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

    public function get_grn_details_list(Request $request)
    {
        try {
            $query = GRNDetail::where('grn_id', $request->grn_id);

            if ($request->has('lot_grnno')) {
                $query->where('lot_grnno', $request->lot_grnno);
            }

            if ($request->has('fish_type_id')) {
                $query->where('fish_type_id', $request->fish_type_id);
            }

            if ($request->has('boat_id')) {
                $query->where('boat_id', $request->boat_id);
            }

            if ($request->has('item_Status')) {
                $query->where('item_Status', $request->item_Status);
            }

            $result = $query->get();
            $count = $result->count();

            if ($count == 0) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No GRN Details Found',
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'GRN Details Found',
                    'count' => $count,
                    'data' => $result,
                ], 200);
            }
        } catch (Exception $ex) {
            Log::channel('api')->error('API : get_grn_details_list | Message : ' . $ex->getMessage());
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
}
