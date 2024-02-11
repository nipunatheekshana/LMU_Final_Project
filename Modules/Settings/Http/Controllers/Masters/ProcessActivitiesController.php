<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Settings\Entities\Activity;
use Modules\Settings\Entities\Process;
use Modules\Settings\Entities\ProcessActivity;

class ProcessActivitiesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'ActivityID' => ['required'],
            'ProcessID' => ['required'],
        ]);
        try {
            $ProcessActivity = new ProcessActivity();
            $ProcessActivity->ActivityID = $request->ActivityID;
            $ProcessActivity->ProcessID = $request->ProcessID;
            $ProcessActivity->ProcessActivityDescription = $request->ProcessActivityDescription;
            $ProcessActivity->list_index = $request->list_index;
            $ProcessActivity->AssignToIndivdualOutput = $request->has('AssignToIndivdualOutput');
            $ProcessActivity->enabled = $request->has('enabled');
            $ProcessActivity->created_by = Auth::user()->id;
            $save = $ProcessActivity->save();



            if ($save) {
                return $this->responseBody(true, "save", "ProcessActivity saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'ActivityID' => ['required'],
            'ProcessID' => ['required'],
        ]);
        try {
            $ProcessActivity = ProcessActivity::find($request->id);
            $ProcessActivity->ActivityID = $request->ActivityID;
            $ProcessActivity->ProcessID = $request->ProcessID;
            $ProcessActivity->ProcessActivityDescription = $request->ProcessActivityDescription;
            $ProcessActivity->list_index = $request->list_index;
            $ProcessActivity->AssignToIndivdualOutput = $request->has('AssignToIndivdualOutput');
            $ProcessActivity->enabled = $request->has('enabled');
            $ProcessActivity->modified_by = Auth::user()->id;
            $save = $ProcessActivity->save();

            if ($save) {
                return $this->responseBody(true, "save", "ProcessActivity saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadProcessActivities()
    {
        try {
            // $ProcessActivity = ProcessActivity::orderBy('id','ASC')
            // ->get();
            $ProcessActivity = DB::table('settings_process_activities')
                            ->leftJoin('settings_activities','settings_activities.id','=','settings_process_activities.ActivityID')
                            ->leftJoin('settings_processes','settings_processes.id','=','settings_process_activities.ProcessID')
                            ->orderBy('id','ASC')
                            ->select('settings_process_activities.id','settings_activities.ActivityName','settings_processes.ProcessName')
                            ->get();


            return $this->responseBody(true, "loadProcessActivitys", "found", $ProcessActivity);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadProcessActivitys", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $ProcessActivity = ProcessActivity::where('id', $id)->delete();
            return $this->responseBody(true, "User", "ProcessActivity Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $ProcessActivity = ProcessActivity::where('id', $id)->first();
            return $this->responseBody(true, "User", "ProcessActivity ", $ProcessActivity);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadProcessActivity($id)
    {
        try {
            $ProcessActivity = ProcessActivity::where('id', $id)->first();
            return $this->responseBody(true, "loadProcessActivity", "found", $ProcessActivity);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadProcessActivity", "error", $exception->getMessage());
        }
    }
    public function loadActivities()
    {
        try {
            $Activity = Activity::where('enabled',true)->get();

            return $this->responseBody(true, "loadActivities", '', $Activity);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadActivities", '', $ex->getMessage());
        }
    }
    public function loadProcesses()
    {
        try {
            $Process = Process::where('enabled',true)->get();

            return $this->responseBody(true, "loadProcesses", '', $Process);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadProcesses", '', $ex->getMessage());
        }
    }

}
