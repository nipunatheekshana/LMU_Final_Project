<?php

namespace Modules\Buying\Http\Controllers\API;

use App\Http\common\activityLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Buying\Entities\GRNDetail;

class FishController extends Controller
{
    use activityLog;
    public function reject_fish(Request $request)
    {
        try {
            $update = GRNDetail::where('id', $request->id)->update([
                'reject_status' => $request->reject_status,
                'reject_reason_code' => $request->reject_reason_code,
                'reject_user_id' => $request->reject_user_id,
                'reject_datetime' => Carbon::now()->toDateTimeString(),
            ]);
            $this->logActivity('fa fa-times-circle', 'warning', ' Fish Status Rejected', 'grnDetail', $request->id);


            if ($update) {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => "Fish Reject Success & Activity Log Updated"
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
