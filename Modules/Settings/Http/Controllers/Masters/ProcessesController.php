<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\Country;
use Modules\Settings\Entities\Process;

class ProcessesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'ProcessName' => ['required'],
        ]);
        try {
            $Process = new Process();
            $Process->CompanyID = $request->CompanyID;
            $Process->ProcessName = $request->ProcessName;
            $Process->ProcessDescription = $request->ProcessDescription;
            $Process->list_index = $request->list_index;
            $Process->enabled = $request->has('enabled');
            $Process->created_by = Auth::user()->id;
            $save = $Process->save();



            if ($save) {
                return $this->responseBody(true, "save", "Process saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'ProcessName' => ['required'],
        ]);
        try {
            $Process = Process::find($request->id);
            $Process->CompanyID = $request->CompanyID;
            $Process->ProcessName = $request->ProcessName;
            $Process->ProcessDescription = $request->ProcessDescription;
            $Process->list_index = $request->list_index;
            $Process->enabled = $request->has('enabled');
            $Process->modified_by = Auth::user()->id;
            $save = $Process->save();

            if ($save) {
                return $this->responseBody(true, "save", "Process saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadprocesses()
    {
        try {
            $Process = Process::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadprocesses", "found", $Process);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadprocesses", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Process = Process::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Process Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Process = Process::where('id', $id)->first();
            return $this->responseBody(true, "User", "Process ", $Process);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadProcess($id)
    {
        try {
            $Process = Process::where('id', $id)->first();
            return $this->responseBody(true, "loadProcess", "found", $Process);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadProcess", "error", $exception->getMessage());
        }
    }
    public function loadCompany()
    {
        try {
            $Company = Company::where('enabled',true)->get();

            return $this->responseBody(true, "loadCompany", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCompany", '', $ex->getMessage());
        }
    }

}

