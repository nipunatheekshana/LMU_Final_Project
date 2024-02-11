<?php

namespace App\Http\Controllers;

use App\Http\common\commonFeatures;
use App\Models\Activity_log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class activityLogController extends Controller
{
    use commonFeatures;
    // public function loadActivityLog()
    // {
    //     try {
    //         // $activityLog = DB::table('activity_logs')->all();
    //         //     // ->leftJoin('users', 'activity_logs.user_id', '=', 'users.id')
    //         //     // ->leftJoin('activity_log_fields', 'activity_log_fields.activity_id', '=', 'activity_logs.id')
    //         //     // ->select('activity_logs.*')
    //         //     // ->get();

    //         $activityLog=Activity_log::all();

    //         $responseBody = $this->responseBody(true, "loadActivityLog", "found", $activityLog);
    //     } catch (Exception $ex) {
    //         $responseBody = $this->responseBody(false, "loadActivityLog", "found", $ex->getMessage());

    //     }
    // }
    public function loadActivityLog()
    {
        try {
            // $activityLog=Activity_log::find(6)->user('name')->activity_log_fields()->get();
            $Activity_log = DB::table('activity_logs')
                                ->join('users','activity_logs.user_id', '=', 'users.id')
                                ->leftJoin('activity_log_fields', 'activity_log_fields.activity_id', '=', 'activity_logs.id')
                                ->select('activity_logs.*','users.name as userName','activity_log_fields.*')
                                ->get();
            return $this->responseBody(true, "Activity_log", "found", $Activity_log);
        } catch (Exception $exception) {
            return $this->responseBody(false, "Activity_log", "Something went wrong", $exception->getMessage());
        }
    }
}
