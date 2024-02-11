<?php

namespace Modules\Quality\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Quality\Entities\QualityCheckingRule;
use Illuminate\Support\Facades\Log;

class QcRulesController extends Controller

{
    public function get_qc_rules(Request $request)
    {
        try {
            $result =  QualityCheckingRule::where('CompanyID', $request->company_id);

            if ($request->has('only_enabled') && $request->only_enabled == 1) {
                $result = $result->where('enabled', true);
            }

            if ($request->has('search_like')) {
                $result = $result->where('QualityRuleName', 'LIKE', '%' . $request->search_like . '%');
            }

            $result = $result->where('enabled', $request->only_enabled)
                ->select([
                    "id",
                    "QualityRuleName",
                    "QualityRuleDescription",
                    "enabled",
                    "list_index",
                ])->get();

            $count = $result->count();

            if ($result->isEmpty()) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'Not found QC Rules'
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'QC Rules found',
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
