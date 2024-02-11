<?php

namespace Modules\Quality\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Quality\Entities\QualityRuleParameter;
use Illuminate\Support\Facades\Log;

class QcRuleParameterController extends Controller
{
    public function get_qc_rule_parameters(Request $request)
    {
        try {
            $result = QualityRuleParameter::where('QualityRuleID', $request->qc_rule_id)
                ->select([
                    "QParameterId",
                    "QParamName",
                    "QParamDescription",
                    "MinValue",
                    "MaxValue",
                    "DefaultValue",
                    "is_status_value_required",
                    "is_status_value_number",
                    "enabled",
                    "list_index",
                ])->get();
            $count = $result->count();
            if ($result->isEmpty()) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No Assigned QC Parameters found'
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'Assigned QC Parameters found',
                    'count' => $count,
                    'data' => $result
                ], 200);
            }
        } catch (Exception $ex) {
            Log::channel('api')->error('API : get_grn_hd_list | Message : ' . $ex->getMessage());
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}
