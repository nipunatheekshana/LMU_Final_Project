<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Settings\Entities\Process;
use Modules\Settings\Entities\ProcessWorkstation;
use Modules\Settings\Entities\Workstation;

class ProcessWorkstationsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'ProcessID' => ['required'],
            'WorkstationID' => ['required'],
        ]);
        try {
            $ProcessWorkstation = new ProcessWorkstation();
            $ProcessWorkstation->ProcessID = $request->ProcessID;
            $ProcessWorkstation->WorkstationID = $request->WorkstationID;
            $ProcessWorkstation->list_index = $request->list_index;
            $ProcessWorkstation->enabled = $request->has('enabled');
            $ProcessWorkstation->created_by = Auth::user()->id;
            $save = $ProcessWorkstation->save();



            if ($save) {
                return $this->responseBody(true, "save", "ProcessWorkstation saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'ProcessID' => ['required'],
            'WorkstationID' => ['required'],
        ]);
        try {
            $ProcessWorkstation = ProcessWorkstation::find($request->id);
            $ProcessWorkstation->ProcessID = $request->ProcessID;
            $ProcessWorkstation->WorkstationID = $request->WorkstationID;
            $ProcessWorkstation->list_index = $request->list_index;
            $ProcessWorkstation->enabled = $request->has('enabled');
            $ProcessWorkstation->modified_by = Auth::user()->id;
            $save = $ProcessWorkstation->save();

            if ($save) {
                return $this->responseBody(true, "save", "ProcessWorkstation saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadProcessWorkstations()
    {
        try {
            // $ProcessWorkstation = ProcessWorkstation::orderBy('id','ASC')
            // ->get();
            $ProcessWorkstation = DB::table('settings_process_workstations')
                                ->join('settings_processes','settings_processes.id','=','settings_process_workstations.ProcessID')
                                ->join('settings_workstations','settings_workstations.id','=','settings_process_workstations.WorkstationID')
                                ->select('settings_process_workstations.id','settings_processes.ProcessName','settings_workstations.WorkstationName')
                                ->orderBy('id','ASC')
                                ->get();
            return $this->responseBody(true, "loadProcessWorkstations", "found", $ProcessWorkstation);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadProcessWorkstations", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $ProcessWorkstation = ProcessWorkstation::where('id', $id)->delete();
            return $this->responseBody(true, "User", "ProcessWorkstation Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $ProcessWorkstation = ProcessWorkstation::where('id', $id)->first();
            return $this->responseBody(true, "User", "ProcessWorkstation ", $ProcessWorkstation);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadProcessWorkstation($id)
    {
        try {
            $ProcessWorkstation = ProcessWorkstation::where('id', $id)->first();
            return $this->responseBody(true, "loadProcessWorkstation", "found", $ProcessWorkstation);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadProcessWorkstation", "error", $exception->getMessage());
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
    public function loadWorkstations()
    {
        try {
            $Workstation = Workstation::where('enabled',true)->get();

            return $this->responseBody(true, "loadWorkstations", '', $Workstation);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadWorkstations", '', $ex->getMessage());
        }
    }

}
